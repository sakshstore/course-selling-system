<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotificationCampaignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaign;

/**
 * Create a new job instance.
 *
 * @param Campaign $campaign
 */
    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

/**
 * Execute the job.
 */
    public function handle(): void
    {
// Retrieve the recipients for the campaign
        $recipients = $this->campaign->recipients;

// Send notifications to each recipient
        foreach ($recipients as $recipient) {
// Assuming the recipient contact is an email
            $user = User::where('email', $recipient->contact)->first();
            if ($user) {
                $user->notify(new UserNotification($this->campaign->message));
            }
        }
    }
}
