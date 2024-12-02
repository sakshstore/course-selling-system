<?php

namespace App\Http\Controllers;

use App\Jobs\EmailCampaignJob;
use App\Jobs\NotificationCampaignJob;
use App\Jobs\SmsCampaignJob;
use App\Jobs\WhatsappCampaignJob;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Lead;
use App\Models\Student;


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
        $validatedData = $request->validate([
            'type' => 'required|string|in:email,sms,whatsapp,notification',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'contacts' => 'required_if:recipientType,manual|array',
           
            'recipientType' => 'required|string|in:students,leads,manual',
            'tagIds' => 'nullable|array',
            'tagIds.*' => 'integer',
        ]);

        $campaign = Auth::user()->campaigns()->create([
            'type' => $validatedData['type'],
            'subject' => $validatedData['subject'],
            'message' => $validatedData['message'],
        ]);

        if ($request->recipientType === 'manual') {
            foreach ($validatedData['contacts'] as $contact) {
                $campaign->recipients()->create(['contact' => $contact]);
            }
        } else {
// Handle students or leads based on tags
            $tagIds = $validatedData['tagIds'];

            if ($request->recipientType === 'students') {
                $recipients = Student::whereHas('tags', function ($query) use ($tagIds) {
                    $query->whereIn('tags.id', $tagIds);
                })->get();
            } elseif ($request->recipientType === 'leads') {
                $recipients = Lead::whereHas('tags', function ($query) use ($tagIds) {
                    $query->whereIn('tags.id', $tagIds);
                })->get();
            }

            foreach ($recipients as $recipient) {
                $campaign->recipients()->create(['contact' => $recipient->email]);
            }

            \Log::info('Campaign created with recipients:', [
                'campaign_id' => $campaign->id,
                'recipients' => $recipients->pluck('email')->toArray()
                ]);
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

}
