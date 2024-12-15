<?php

namespace App\Jobs;

use App\Models\ApiLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogApiRequestsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $logs;

    public function __construct(array $logs)
    {
        $this->logs = $logs;
    }

    public function handle()
    {
        ApiLog::insert($this->logs);
    }
}
