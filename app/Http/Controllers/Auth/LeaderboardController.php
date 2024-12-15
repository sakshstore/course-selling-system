<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Leaderboard;
use App\Models\ScoreHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaderboardController extends Controller
{
     
  
  
 






    public function myScore(Request $request)
{
$user = Auth::user();
$leaderboard = Leaderboard::where('user_id', $user->id)->first();
$score = $leaderboard ? $leaderboard->score : 0;

return response()->json(['score' => $score]);
}

public function myScoreHistory(Request $request)
{
$user = Auth::user();
$scoreHistory = ScoreHistory::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

return response()->json($scoreHistory);
}





}
