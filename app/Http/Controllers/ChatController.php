<?php




namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\ChatCreated;

class ChatController extends Controller
{
public function index()
{
$chats = Chat::with('user')->get();
return response()->json($chats);
}

public function store(Request $request)
{
$validatedData = $request->validate([
'chat' => 'required|string',
]);

$chat = Auth::user()->chats()->create($validatedData);
$chat->load('user'); // Load the user relationship

// Dispatch the chat created event
event(new ChatCreated(auth()->id(), $chat->id));

return response()->json($chat, 201);
}
}