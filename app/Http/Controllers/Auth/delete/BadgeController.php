<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Badge;
use App\Models\UserBadge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BadgeController extends Controller
{
    public function index()
    {
        $badges = Badge::all();
        return response()->json($badges);
    }

    public function awardBadge(Request $request)
    {
        $userBadge = UserBadge::create([
            'user_id' => $request->user_id, // ID of the user to be awarded
            'badge_id' => $request->badge_id, // ID of the badge to be awarded
        ]);
        return response()->json($userBadge);
    }

    public function store(Request $request)
    {
        $badge = Badge::create([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon,

            'event_name' => $request->event_name, // Add this line

            'user_id' => Auth::id(), // Get the ID of the logged-in user
        ]);
        return response()->json($badge, 201);
    }

    public function update(Request $request, $id)
    {
        $badge = Badge::findOrFail($id);
        $badge->update($request->all());
        return response()->json($badge, 200);
    }

    public function destroy($id)
    {
        Badge::destroy($id);
        return response()->json(null, 204);
    }
}
