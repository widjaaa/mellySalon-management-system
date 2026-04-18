<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Member;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Data rekapitulasi penghasilan.
     */
    public function index(Request $request)
    {
        $period = $request->get('period', 'harian');
        $now = Carbon::now();

        // Tentukan rentang tanggal berdasarkan periode
        switch ($period) {
            case 'mingguan':
                $startDate = $now->copy()->startOfWeek();
                $endDate = $now->copy()->endOfWeek();
                break;
            case 'bulanan':
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                break;
            default: // harian
                $startDate = $now->copy()->startOfDay();
                $endDate = $now->copy()->endOfDay();
                break;
        }

        // Transaksi dalam periode
        $transactions = Transaction::with(['items', 'member'])
            ->where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistik ringkasan
        $totalRevenue = $transactions->sum('total_amount');
        $totalTransactions = $transactions->count();
        $averageTransaction = $totalTransactions > 0 ? round($totalRevenue / $totalTransactions) : 0;
        $memberTransactions = $transactions->whereNotNull('member_id')->count();

        // Metode pembayaran breakdown
        $paymentBreakdown = $transactions->groupBy('payment_method')
            ->map(fn($group) => [
                'count' => $group->count(),
                'total' => $group->sum('total_amount'),
            ]);

        // Layanan terpopuler (dari transaction items)
        $popularServices = DB::table('transaction_items')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->where('transactions.status', 'completed')
            ->whereBetween('transactions.created_at', [$startDate, $endDate])
            ->select('transaction_items.service_name', DB::raw('SUM(transaction_items.quantity) as total_qty'), DB::raw('SUM(transaction_items.service_price * transaction_items.quantity) as total_revenue'))
            ->groupBy('transaction_items.service_name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'period' => $period,
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'summary' => [
                    'total_revenue' => $totalRevenue,
                    'total_transactions' => $totalTransactions,
                    'average_transaction' => $averageTransaction,
                    'member_transactions' => $memberTransactions,
                ],
                'payment_breakdown' => $paymentBreakdown,
                'popular_services' => $popularServices,
                'transactions' => $transactions,
            ],
        ]);
    }

    /**
     * Data kinerja salon (dashboard widgets).
     */
    public function performance()
    {
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();

        // Pendapatan hari ini
        $todayRevenue = Transaction::where('status', 'completed')
            ->whereDate('created_at', $today)
            ->sum('total_amount');

        // Pelanggan hari ini
        $todayCustomers = Transaction::where('status', 'completed')
            ->whereDate('created_at', $today)
            ->count();

        // Poin diberikan hari ini
        $todayPoints = Transaction::where('status', 'completed')
            ->whereDate('created_at', $today)
            ->sum('poin_awarded');

        // Total member aktif bulan ini
        $activeMembers = Member::count();

        // Pendapatan 7 hari terakhir (untuk chart)
        $weeklyRevenue = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $revenue = Transaction::where('status', 'completed')
                ->whereDate('created_at', $date)
                ->sum('total_amount');
            $weeklyRevenue[] = [
                'date' => $date->format('D'),
                'day' => $date->translatedFormat('D'),
                'revenue' => $revenue,
            ];
        }

        // Member yang ulang tahun bulan ini
        $currentMonth = $today->month;
        $birthdayMembers = Member::whereMonth('bday', $currentMonth)->get();

        return response()->json([
            'success' => true,
            'data' => [
                'today_revenue' => $todayRevenue,
                'today_customers' => $todayCustomers,
                'today_points' => $todayPoints,
                'active_members' => $activeMembers,
                'weekly_revenue' => $weeklyRevenue,
                'birthday_members' => $birthdayMembers,
            ],
        ]);
    }
}
