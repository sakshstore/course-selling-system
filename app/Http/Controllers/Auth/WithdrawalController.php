<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
public function requestWithdrawal(Request $request)
{
$request->validate([
'amount' => 'required|numeric|min:1',
]);

$user = Auth::user();

if ($request->amount > $user->referral_income) {
return response()->json(['error' => 'Insufficient balance'], 400);
}

Withdrawal::create([
'user_id' => $user->id,
'amount' => $request->amount,
]);

$user->referral_income -= $request->amount;
$user->save();

// Record the transaction
Transaction::create([
'user_id' => $user->id,
'amount' => $request->amount,
'type' => 'debit',
'description' => 'Withdrawal request',
]);

return response()->json(['message' => 'Withdrawal request submitted successfully']);
}

public function adminIndex()
{
$withdrawals = Withdrawal::where('status', 'pending')->get();
return view('admin.withdrawals', compact('withdrawals'));
}

public function approveWithdrawal($id)
{
$withdrawal = Withdrawal::find($id);
$withdrawal->status = 'approved';
$withdrawal->save();

// Process the payment to the user (e.g., via PayPal, bank transfer, etc.)

return redirect()->back()->with('message', 'Withdrawal approved successfully');
}


public function fetchWithdrawals()
{
$user = Auth::user();
$withdrawals = Withdrawal::where('user_id', $user->id)->get();

return response()->json($withdrawals);
}


}