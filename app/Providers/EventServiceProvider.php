<?php

namespace App\Providers;

use App\Events\AdminLoggedIn;
use App\Events\ChatCreated;
use App\Events\CourseCreated;
use App\Events\CourseDeleted;
use App\Events\CourseUpdated;
use App\Events\CourseViewed;
use App\Events\LeadCreated;
use App\Events\LeadDeleted;
use App\Events\LeadUpdated;
use App\Events\StudentEnrolled;
use App\Events\StudentRemoved;
use App\Events\UserLoggedIn;
use App\Events\VideoCreated;
use App\Listeners\LogActivity;
use App\Listeners\LogLoginHistory;
use App\Listeners\SendAdminLoginNotification;
use App\Listeners\SendNotification;



use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [

        AdminLoggedIn::class => [

            SendAdminLoginNotification::class,
        ],

        StudentEnrolled::class => [
            SendEnrollmentNotification::class,
        ],

        StudentRemoved::class => [
            SendRemovalNotification::class,
        ],

        StudentEnrolled::class => [
            LogActivity::class,
        ],

        StudentRemoved::class => [
            LogActivity::class,
        ],

        


        UserLoggedIn::class => [
        LogActivity::class,
          LogLoginHistory::class,

           SendNotification::class,
            ],
            
        CourseViewed::class => [
            LogActivity::class,
        ],
        CourseCreated::class => [
            LogActivity::class,
        ],
        CourseUpdated::class => [
            LogActivity::class,
        ],
        CourseDeleted::class => [
            LogActivity::class,
        ],
        VideoCreated::class => [
            LogActivity::class,
        ],
        ChatCreated::class => [
            LogActivity::class,
        ],
        LeadCreated::class => [
            LogActivity::class,
        ],
        LeadUpdated::class => [
            LogActivity::class,
        ],
        LeadDeleted::class => [
            LogActivity::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
