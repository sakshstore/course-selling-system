<?php

namespace App\Listeners;


use App\Events\UserLoggedIn;
use App\Models\ActivityLog;

class LogUserLogin
{
    public function handle(UserLoggedIn $event)
    {
        ActivityLog::create([
            'user_id' => $event->userId,
            'action' => 'login',
            'details' => null
        ]);


        
    }
}

