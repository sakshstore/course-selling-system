<?php

namespace App\Jobs;

use App\Mail\CampaignMail;
use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailCampaignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaign;

    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    public function handle()
    {
        $this->campaign->recipients()->chunk(100, function ($recipients) {
            foreach ($recipients as $recipient) {
                try {
                    Mail::to($recipient->contact)->send(new CampaignMail($this->campaign->subject, $this->campaign->message));
                    Log::info('Email sent to: ' . $recipient->contact . ' for campaign ID: ' . $this->campaign->id);

                    $recipient->update(['status' => 'sent']);
                } catch (\Exception $e) {
                    Log::error('Failed to send email to: ' . $recipient->contact . ' for campaign ID: ' . $this->campaign->id . ' - Error: ' . $e->getMessage());

                    $recipient->update(['status' => 'failed']);
                }

// Optional: Add a delay to avoid hitting rate limits
                usleep(100000); // 100ms delay
            }
        });


        $this->campaign->update(['status' => 'delivered']); 

        
    }
}
