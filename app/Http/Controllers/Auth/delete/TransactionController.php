<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function fetchTransactions()
    {
        $user = Auth::user();
        $transactions = Transaction::where('user_id', $user->id)->get();

        return response()->json($transactions);
    }
}
