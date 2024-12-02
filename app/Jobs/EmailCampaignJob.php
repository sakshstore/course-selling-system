<?php
 
namespace App\Jobs;

use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class  EmailCampaignJob implements ShouldQueue
{
use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

protected $campaign;

public function __construct(Campaign $campaign)
{
$this->campaign = $campaign;
}

public function handle()
{
foreach ($this->campaign->recipients as $recipient) {
Mail::raw($this->campaign->message, function ($message) use ($recipient) {
$message->to($recipient->contact)
->subject($this->campaign->subject);
});
}
}
}
