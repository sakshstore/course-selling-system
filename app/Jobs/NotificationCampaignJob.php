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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
        Log::warning('Job initialized');
    }

/**
 * Execute the job.
 */
    public function handle(): void
    {
        Log::warning('Job started');
        Log::warning('Campaign data: ' . json_encode($this->campaign));

        $recipients = $this->campaign->recipients;

        foreach ($recipients as $recipient) {
// Log recipient contact
            Log::warning('Processing recipient: ' . $recipient->contact);

// Send email
            Mail::raw('This is a test email', function ($message) use ($recipient) {
                $message->to($recipient->contact)
                    ->subject('Test Email');
            });

            $user = User::where('email', $recipient->contact)->first();

            if ($user) {
                Log::warning('User found: ' . $recipient->contact);

                try {
                    $user->notify(new UserNotification($this->campaign->subject, $this->campaign->message));
                    $recipient->update(['status' => 'sent']);
                } catch (\Exception $e) {
                    Log::error('Notification failed for ' . $recipient->contact . ': ' . $e->getMessage());
                    $recipient->update(['status' => 'failed']);
                }
            } else {
                Log::warning('User not found: ' . $recipient->contact);
                $recipient->update(['status' => 'failed']);
            }
        }

        Log::warning('Job completed');

        $this->campaign->update(['status' => 'delivered']); 


    }
}
