<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Member;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $transaction = Transaction::create($request->all());

        if ($request->member_id) {
            $member = Member::find($request->member_id);
            if ($member) {
                $member->poin += $transaction->poin_awarded;
                $member->total_visits += 1;
                $member->total_spent += $transaction->total_amount;
                $member->save();
            }
        }

        return response()->json(['success' => true, 'transaction' => $transaction]);
    }
}
