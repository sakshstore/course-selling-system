<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Message;





use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
// Display a listing of the user's tickets
    public function index()
    {
        $tickets = Auth::user()->tickets;
        return response()->json($tickets);
    }

// Store a newly created ticket in storage
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'priority' => 'required|string|max:255',
            'attachment' => 'sometimes|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', // Adjust file types and size as needed
        ]);

        if ($request->hasFile('attachment')) {
            $filePath = $request->file('attachment')->store('attachments', 'public');
            $validatedData['attachment'] = $filePath;
        }

        $ticket = Auth::user()->tickets()->create($validatedData);
        return response()->json($ticket, 201);
    }

// Display the specified ticket
    public function show($id)
    {
        $ticket = Auth::user()->tickets()->findOrFail($id);
        return response()->json($ticket);
    }

// Update the specified ticket in storage
    public function update(Request $request, $id)
    {
        $ticket = Auth::user()->tickets()->findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'category' => 'sometimes|required|string|max:255',
            'priority' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required|string|max:255',
        ]);

        $ticket->update($validatedData);
        return response()->json($ticket);
    }

// Remove the specified ticket from storage
    public function destroy($id)
    {
        $ticket = Auth::user()->tickets()->findOrFail($id);
        $ticket->delete();
        return response()->json(null, 204);
    }

// Get categories and priorities for tickets
    public function getCategoriesAndPriorities()
    {
        $data = [
            'categories' => [
                "Technical Issue",
                "Billing Inquiry",
                "Account Management",
                "Feature Request",
                "General Inquiry",
                "Feedback",
                "Bug Report",
                "Security Concern",
            ],
            'priorities' => [
                "Low",
                "Medium",
                "High",
                "Urgent",
            ],
        ];

        return response()->json($data);
    }

// Get messages for a specific ticket
    public function getMessages($ticketId)
    {
        $messages = Message::where('ticket_id', $ticketId)->with('user')->get();
        return response()->json($messages);
    }

// Post a new message to a specific ticket
    public function postMessage(Request $request, $ticketId)
    {
        $validatedData = $request->validate([
            'message' => 'required|string',
            'attachment' => 'sometimes|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', // Adjust file types and size as needed
            'message_type' => 'sometimes|string|max:255',
            'parent_message_id' => 'sometimes|integer|exists:messages,id',
        ]);

        if ($request->hasFile('attachment')) {
            $filePath = $request->file('attachment')->store('attachments', 'public');
            $validatedData['attachment'] = $filePath;
        }

        $message = new Message();
        $message->ticket_id = $ticketId;
        $message->user_id = Auth::id();
        $message->message = $validatedData['message'];
        $message->is_read = false;
        $message->attachment = $validatedData['attachment'] ?? null;
        $message->message_type = $validatedData['message_type'] ?? 'customer';
        $message->parent_message_id = $validatedData['parent_message_id'] ?? null;
        $message->save();

        return response()->json($message, 201);
    }

// Fetch all tickets in the system
    public function getAllTickets()
    {
        $tickets = Ticket::all();
        return response()->json($tickets);
    }
}