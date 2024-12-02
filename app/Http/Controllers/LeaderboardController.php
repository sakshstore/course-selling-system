<?php

namespace App\Http\Controllers;

use App\Models\Leaderboard;
use App\Models\ScoreHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaderboardController extends Controller
{
    public function index()
    {
        $leaderboard = Leaderboard::with('user')->orderBy('score', 'desc')->get();
        return response()->json($leaderboard);
    }

    public function updateScore(Request $request)
    {
        $leaderboard = Leaderboard::updateOrCreate(
            ['user_id' => $request->user_id],
            ['score' => $request->score]
        );
        return response()->json($leaderboard);
    }

    public function increaseStudentScore(Request $request, $studentId)
    {

        $user = Auth::user();

        $request->validate([
            'increment' => 'required|integer|min:1',
            'event' => 'required|string',
            'description' => 'required|string',
            'updated_by' => 'required|exists:users,id',
        ]);

        $scoreHistory = ScoreHistory::create([
            'user_id' => $user->id,
            'student_id' => $studentId,
            'increment' => $request->increment,
            'event' => $request->event,
            'description' => $request->description,
            'updated_by' => $request->updated_by,
        ]);

        $leaderboard = Leaderboard::where('student_id', $studentId)->first();

        if ($leaderboard) {
            $leaderboard->score += $request->increment;
            $leaderboard->save();
        } else {
            $leaderboard = Leaderboard::create([
                'student_id' => $studentId,
                'score' => $request->increment,
            ]);
        }

        return response()->json($scoreHistory);
    }

    public function fetchScoreHistory($studentId)
    {
        $scoreHistory = ScoreHistory::where('student_id', $studentId)->orderBy('created_at', 'desc')->get();
        return response()->json($scoreHistory);
    }

    public function completeTarget(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'target_id' => 'required|exists:targets,id', // Assuming you have a targets table
            'score' => 'required|integer|min:1',
            'event' => 'required|string',
            'description' => 'required|string',
            'updated_by' => 'required|exists:users,id',
        ]);

        $user = Auth::user();

// Log the score change in ScoreHistory
        $scoreHistory = ScoreHistory::create([
            'user_id' => $user->id,
            'student_id' => $request->student_id,
            'increment' => $request->score,
            'event' => $request->event,
            'description' => $request->description,
            'updated_by' => $request->updated_by,
        ]);

// Update the leaderboard
        $leaderboard = Leaderboard::where('user_id', $request->student_id)->first();

        if ($leaderboard) {
            $leaderboard->score += $request->score;
            $leaderboard->save();
        } else {
            $leaderboard = Leaderboard::create([
                'user_id' => $request->student_id,
                'score' => $request->score,
            ]);
        }

        return response()->json($leaderboard);
    }






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
$scoreHistory = ScoreHistory::where('student_id', $user->id)->orderBy('created_at', 'desc')->get();

return response()->json($scoreHistory);
}





}
