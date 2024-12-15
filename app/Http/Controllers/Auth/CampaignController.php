<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Jobs\EmailCampaignJob;
use App\Jobs\NotificationCampaignJob;
use App\Jobs\SmsCampaignJob;
use App\Jobs\WhatsappCampaignJob;
use App\Models\Campaign;
use App\Models\Lead;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{

    public function index()
    {
        $campaigns = Auth::user()->campaigns()->with('recipients')->get();
        return response()->json($campaigns);
    }

    public function show(Campaign $campaign)
    {
        $campaign->load('recipients');
        return response()->json($campaign);
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'type' => 'required|string|in:email,sms,whatsapp,notification',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'contacts' => 'required_if:recipientType,manual|array',
            'recipientType' => 'required|string|in:students,leads,manual',
            'tagIds' => 'nullable|array',
            'tagIds.*' => 'integer',
        ]);

        // Create a new campaign for the authenticated user
        $campaign = Auth::user()->campaigns()->create([
            'type' => $validatedData['type'],
            'subject' => $validatedData['subject'],
            'message' => $validatedData['message'],
            'status' => 'pending', // Set initial status
        ]);

        // Handle recipients based on the recipient type
        if ($request->recipientType === 'manual') {
            // Manually add contacts to the campaign
            foreach ($validatedData['contacts'] as $contact) {
                $campaign->recipients()->create(['contact' => $contact]);
            }
        } else {
            // Handle students or leads based on tags
            $tagIds = $validatedData['tagIds'];
            $recipients = collect();

            if ($request->recipientType === 'students') {
                if (count($tagIds) < 1) {
                    // Select all students if no tags are provided
                    $recipients = Student::all();
                } else {
                    // Query students with the specified tags
                    $recipients = Student::whereHas('tags', function ($query) use ($tagIds) {
                        \Log::info('Querying students with tags:', ['tagIds' => $tagIds]);
                        $query->whereIn('tags.id', $tagIds);
                    })->get();
                }
            } elseif ($request->recipientType === 'leads') {
                if (count($tagIds) < 1) {
                    // Select all leads if no tags are provided
                    $recipients = Lead::all();
                } else {
                    // Query leads with the specified tags
                    $recipients = Lead::whereHas('tags', function ($query) use ($tagIds) {
                        \Log::info('Querying leads with tags:', ['tagIds' => $tagIds]);
                        $query->whereIn('tags.id', $tagIds);
                    })->get();
                }
            }

            // Add recipients to the campaign
            foreach ($recipients as $recipient) {
                $campaign->recipients()->create(['contact' => $recipient->email]);
            }

        }

        // Dispatch the appropriate job based on the campaign type
        switch ($campaign->type) {
            case 'email':
                EmailCampaignJob::dispatch($campaign);
                break;
            case 'sms':
                SmsCampaignJob::dispatch($campaign);
                break;
            case 'whatsapp':
                WhatsappCampaignJob::dispatch($campaign);
                break;
            case 'notification':
                NotificationCampaignJob::dispatch($campaign);
                break;
        }

        return response()->json($campaign, 201);
    }

    public function duplicate(Campaign $campaign)
    {
// Duplicate the campaign
        $newCampaign = $campaign->replicate();
        $newCampaign->created_at = now();
        $newCampaign->updated_at = now();

  

        $newCampaign->status = 'pending'; // Set initial status
        $newCampaign->save();

// Duplicate the recipients
        foreach ($campaign->recipients as $recipient) {
            $newCampaign->recipients()->create([
                'contact' => $recipient->contact,
            ]);
        }

// Dispatch the appropriate job based on the campaign type
        switch ($newCampaign->type) {
            case 'email':
                EmailCampaignJob::dispatch($newCampaign);
                break;
            case 'sms':
                SmsCampaignJob::dispatch($newCampaign);
                break;
            case 'whatsapp':
                WhatsappCampaignJob::dispatch($newCampaign);
                break;
            case 'notification':
                NotificationCampaignJob::dispatch($newCampaign);
                break;
        }

        return response()->json($newCampaign, 201);
    }

}
