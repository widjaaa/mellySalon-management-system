<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Member;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Simpan transaksi baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'member_id' => 'nullable|exists:members,id',
            'services_summary' => 'required|string',
            'subtotal' => 'required|integer|min:0',
            'discount_amount' => 'required|integer|min:0',
            'total_amount' => 'required|integer|min:0',
            'payment_method' => 'required|in:Tunai,QRIS,Transfer',
            'cash_received' => 'nullable|integer|min:0',
            'cash_change' => 'nullable|integer|min:0',
            'poin_awarded' => 'integer|min:0',
            'items' => 'required|array|min:1',
            'items.*.service_name' => 'required|string',
            'items.*.service_price' => 'required|integer|min:0',
            'items.*.quantity' => 'integer|min:1',
        ]);

        // Validasi server-side: subtotal = sum of items
        $calculatedSubtotal = collect($validatedData['items'])->sum(function ($item) {
            return $item['service_price'] * ($item['quantity'] ?? 1);
        });

        if ($calculatedSubtotal !== $validatedData['subtotal']) {
            return response()->json([
                'success' => false,
                'message' => 'Subtotal tidak sesuai dengan total item.',
            ], 422);
        }

        // Validasi diskon jika member
        $discountAmount = 0;
        if ($validatedData['member_id']) {
            $member = Member::find($validatedData['member_id']);
            if ($member) {
                $discountPercent = $member->getDiscountPercent();
                $discountAmount = (int) round($calculatedSubtotal * $discountPercent / 100);
            }
        }

        $expectedTotal = $calculatedSubtotal - $discountAmount;
        if ($expectedTotal !== $validatedData['total_amount']) {
            return response()->json([
                'success' => false,
                'message' => 'Total pembayaran tidak sesuai kalkulasi server.',
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Buat transaksi
            $transaction = Transaction::create([
                'invoice_number' => Transaction::generateInvoiceNumber(),
                'member_id' => $validatedData['member_id'],
                'customer_name' => $validatedData['customer_name'],
                'services_summary' => $validatedData['services_summary'],
                'subtotal' => $calculatedSubtotal,
                'discount_amount' => $discountAmount,
                'total_amount' => $expectedTotal,
                'payment_method' => $validatedData['payment_method'],
                'cash_received' => $validatedData['cash_received'] ?? null,
                'cash_change' => $validatedData['cash_change'] ?? null,
                'poin_awarded' => $validatedData['poin_awarded'] ?? 0,
                'status' => 'completed',
            ]);

            // Simpan item detail
            foreach ($validatedData['items'] as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'service_name' => $item['service_name'],
                    'service_price' => $item['service_price'],
                    'quantity' => $item['quantity'] ?? 1,
                ]);
            }

            // Update data member jika ada
            if ($validatedData['member_id']) {
                $member = Member::find($validatedData['member_id']);
                if ($member) {
                    $member->poin += $transaction->poin_awarded;
                    $member->total_visits += 1;
                    $member->total_spent += $transaction->total_amount;
                    $member->save();
                }
            }

            DB::commit();

            $transaction->load('items', 'member');

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil!',
                'transaction' => $transaction,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Ambil daftar transaksi (untuk riwayat) — dengan search & pagination.
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['items', 'member'])
            ->orderBy('created_at', 'desc');

        // Filter by status (default: semua)
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->has('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        // Search by customer name or invoice number
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('invoice_number', 'like', "%{$search}%");
            });
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $transactions = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $transactions->items(),
            'pagination' => [
                'current_page' => $transactions->currentPage(),
                'last_page' => $transactions->lastPage(),
                'per_page' => $transactions->perPage(),
                'total' => $transactions->total(),
            ],
        ]);
    }

    /**
     * Ambil detail satu transaksi (untuk invoice).
     */
    public function show($id)
    {
        $transaction = Transaction::with(['items', 'member'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $transaction,
        ]);
    }

    /**
     * Void / batalkan transaksi.
     */
    public function void($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status === 'voided') {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi ini sudah dibatalkan sebelumnya.',
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Batalkan poin & spending member jika ada
            if ($transaction->member_id) {
                $member = Member::find($transaction->member_id);
                if ($member) {
                    $member->poin = max(0, $member->poin - $transaction->poin_awarded);
                    $member->total_visits = max(0, $member->total_visits - 1);
                    $member->total_spent = max(0, $member->total_spent - $transaction->total_amount);
                    $member->save();
                }
            }

            $transaction->status = 'voided';
            $transaction->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dibatalkan.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal membatalkan transaksi: ' . $e->getMessage(),
            ], 500);
        }
    }
}
