<?php

namespace App\Http\Middleware;

use App\Jobs\LogApiRequestsJob;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogApiRequests
{
    protected $logs = [];

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check()) {
            $this->logs[] = [
                'user_id' => Auth::id(),
                'method' => $request->method(),
                'url' => $request->url(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'response_status' => $response->status(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($this->logs) >= 10) { // Adjust the batch size as needed
                LogApiRequestsJob::dispatch($this->logs);
                $this->logs = [];
            }
        }

        return $response;
    }

    public function terminate($request, $response)
    {
        if (!empty($this->logs)) {
            LogApiRequestsJob::dispatch($this->logs);
        }
    }
}
