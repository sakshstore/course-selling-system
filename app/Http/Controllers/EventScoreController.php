<?php

namespace App\Http\Controllers;

use App\Models\EventScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventScoreController extends Controller
{
// List all event scores
    public function index()
    {
        $eventScores = EventScore::all();
        return response()->json($eventScores);
    }

// Store a new event score
    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|unique:event_scores',
            'score' => 'required|integer',
        ]);

        $eventScore = EventScore::create([
            'event_name' => $request->event_name,
            'score' => $request->score,
            'user_id' => Auth::id(), // Set the user_id to the currently authenticated user
        ]);

        return response()->json($eventScore);
    }

// Show a specific event score
    public function show($id)
    {
        $eventScore = EventScore::findOrFail($id);
        return response()->json($eventScore);
    }

// Update an existing event score
    public function update(Request $request, $id)
    {
        $request->validate([
            'event_name' => 'required|string|unique:event_scores,event_name,' . $id,
            'score' => 'required|integer',
        ]);

        $eventScore = EventScore::findOrFail($id);
        $eventScore->update([
            'event_name' => $request->event_name,
            'score' => $request->score,
            'user_id' => Auth::id(), // Update the user_id to the currently authenticated user
        ]);

        return response()->json($eventScore);
    }

// Delete an event score
    public function destroy($id)
    {
        $eventScore = EventScore::findOrFail($id);
        $eventScore->delete();

        return response()->json(['message' => 'Event score deleted successfully']);
    }
}
