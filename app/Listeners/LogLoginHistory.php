<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Models\LoginHistory;
use Illuminate\Support\Facades\Request;

class LogLoginHistory
{
/**
 * Handle the event.
 *
 * @param  \App\Events\UserLoggedIn  $event
 * @return void
 */
    public function handle(UserLoggedIn $event)
    {
        $request = Request::instance();

// You can use a service to get the location from the IP address
        $location = $this->getLocationFromIp($request->ip());

        LoginHistory::create([
            'user_id' => $event->userId,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'location' => $location,
            'device' => $this->getDeviceFromUserAgent($request->header('User-Agent')),
            'session_id' => session()->getId(),
            'login_method' => 'OTP', // or 'Password', 'Social', etc.
            'login_status' => true,
        ]);

    }

    private function getLocationFromIp($ip)
    {
// Implement a service to get location from IP address
// For example, using an external API
        return 'Sample Location'; // Replace with actual implementation
    }

    private function getDeviceFromUserAgent($userAgent)
    {
// Implement a service to parse the user agent string
// For example, using a library like "jenssegers/agent"
        return 'Sample Device'; // Replace with actual implementation
    }
}
