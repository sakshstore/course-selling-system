<?php

namespace App\Http\Controllers\Admin;

 
use App\Http\Controllers\Controller;

use App\Exports\ContactsExport;
use App\Imports\ContactsImport;
use App\Models\Contact;
use App\Models\Note;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Auth::user()->contacts()->with(['notes', 'tags'])->get();
        return response()->json($contacts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:15',
            'billing_address_line1' => 'nullable|string|max:255',
            'billing_address_line2' => 'nullable|string|max:255',
            'billing_city' => 'nullable|string|max:255',
            'billing_state' => 'nullable|string|max:255',
            'billing_country' => 'nullable|string|max:255',
            'billing_pin_code' => 'nullable|string|max:10',
            'shipping_address_line1' => 'nullable|string|max:255',
            'shipping_address_line2' => 'nullable|string|max:255',
            'shipping_city' => 'nullable|string|max:255',
            'shipping_state' => 'nullable|string|max:255',
            'shipping_country' => 'nullable|string|max:255',
            'shipping_pin_code' => 'nullable|string|max:10',
            'notes' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
        ]);

        $contact = Auth::user()->contacts()->create($request->only([
            'name',
            'email',
            'phone',
            'billing_address_line1',
            'billing_address_line2',
            'billing_city',
            'billing_state',
            'billing_country',
            'billing_pin_code',
            'shipping_address_line1',
            'shipping_address_line2',
            'shipping_city',
            'shipping_state',
            'shipping_country',
            'shipping_pin_code',
        ]));

        $this->syncTags($contact, $request->tags);
        $this->syncNotes($contact, $request->notes);

        return response()->json($contact->load(['notes', 'tags']), 201);
    }

    public function update(Request $request, Contact $contact)
    { 

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:15',
            'billing_address_line1' => 'nullable|string|max:255',
            'billing_address_line2' => 'nullable|string|max:255',
            'billing_city' => 'nullable|string|max:255',
            'billing_state' => 'nullable|string|max:255',
            'billing_country' => 'nullable|string|max:255',
            'billing_pin_code' => 'nullable|string|max:10',
            'shipping_address_line1' => 'nullable|string|max:255',
            'shipping_address_line2' => 'nullable|string|max:255',
            'shipping_city' => 'nullable|string|max:255',
            'shipping_state' => 'nullable|string|max:255',
            'shipping_country' => 'nullable|string|max:255',
            'shipping_pin_code' => 'nullable|string|max:10',
            'notes' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
        ]);

        $contact->update($request->only([
            'name',
            'email',
            'phone',
            'billing_address_line1',
            'billing_address_line2',
            'billing_city',
            'billing_state',
            'billing_country',
            'billing_pin_code',
            'shipping_address_line1',
            'shipping_address_line2',
            'shipping_city',
            'shipping_state',
            'shipping_country',
            'shipping_pin_code',
        ]));

        $this->syncTags($contact, $request->tags);
        $this->syncNotes($contact, $request->notes);

        return response()->json($contact->load(['notes', 'tags']));
    }

    public function destroy(Contact $contact)
    { 

        $contact->delete();
        return response()->json(null, 204);
    }

    private function syncTags(Contact $contact, $tags)
    {
        if ($tags) {
            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $contact->tags()->sync($tagIds);
        }
    }

    private function syncNotes(Contact $contact, $notes)
    {
        if ($notes) {
            $note = new Note();
            $note->content = $notes;
            $contact->notes()->save($note);
        }
    }

    

    public function getContactfields()
    {
        $tableColumns = [
            ['value' => 'name', 'text' => 'Name'],
            ['value' => 'email', 'text' => 'Email'],
            ['value' => 'phone', 'text' => 'phone'],
            ['value' => 'address', 'text' => 'Address'],
            ['value' => 'city', 'text' => 'City'],
            ['value' => 'state', 'text' => 'State'],
            ['value' => 'pin', 'text' => 'Pin'],
            ['value' => 'company', 'text' => 'Company'],
            ['value' => 'position', 'text' => 'Position'],
        ];

        $tableFields = [
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'phone', 'label' => 'phone'],
            ['key' => 'address', 'label' => 'Address'],
            ['key' => 'city', 'label' => 'City'],
            ['key' => 'state', 'label' => 'State'],
            ['key' => 'pin', 'label' => 'Pin'],
            ['key' => 'company', 'label' => 'Company'],
            ['key' => 'position', 'label' => 'Position'],
        ];

        return [$tableColumns, $tableFields];
    }

    public function importContacts(Request $request)
    {
        $data = $request->json()->all();
        $mandatoryFields = ['name', 'email']; // Add other mandatory fields here
        $newContacts = []; // Array to store new contacts' emails
        $errors = []; // Array to store errors

        foreach ($data as $row) {
// Check for mandatory fields
            $missingFields = [];
            foreach ($mandatoryFields as $field) {
                if (!isset($row[$field])) {
                    $missingFields[] = $field;
                }
            }

            if (!empty($missingFields)) {
                $errors[] = [
                    'row' => $row,
                    'missing_fields' => $missingFields,
                ];
                continue; // Skip to the next row
            }

// Check if contact already exists
            $existingContact = Contact::where('email', $row['email'])->first();
            if (!$existingContact) {
                
                $row['status'] = $row['status'] ?? 'active'; // Replace 'active' with your default status value


                Auth::user()->contacts()->create($row);
                $newContacts[] = $row['email']; // Add new contact's email to the array
            }
        }

// Return the total number of new contacts, their emails, and any errors
        return response()->json([
            'message' => 'Contacts import completed',
            'total_new_contacts' => count($newContacts),
            'new_contacts_emails' => $newContacts,
            'errors' => $errors,
        ], 200);
    }




    
    public function getFilteredContacts(Request $request)
    {
        $selectedColumns = $request->input('columns', []);
        if (empty($selectedColumns)) {
            return response()->json(['message' => 'No columns selected'], 400);
        }

        $contacts = Contact::select($selectedColumns)->get();
        return response()->json($contacts);
    }

}
