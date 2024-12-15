<?php

namespace App\Listeners;

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
use App\Models\ActivityLog;
use App\Models\Badge;
use App\Models\EventScore;
use App\Models\Leaderboard;
use App\Models\ScoreHistory;
use App\Models\UserBadge;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

class LogActivity
{
/**
 * Handle the event and log the activity.
 *
 * @param  mixed  $event
 * @return void
 */
    public function handle($event)
    {

        $action = '';
        $details = [];
        $message = '44';

// Capture IP address and media device
        $ipAddress = Request::ip();
        $mediaDevice = Request::header('User-Agent');
        $dateTime = Carbon::now()->toDateTimeString();

        // Log the event name

// Determine the action and details based on the event type
        if ($event instanceof UserLoggedIn) {
            $action = 'login';
            $message = "User logged in from IP address $ipAddress on $dateTime";
        } elseif ($event instanceof CourseViewed) {
            $action = 'view_course';
            $details = ['course_id' => $event->courseId];
            $message = "Course viewed from IP address $ipAddress on $dateTime";
        } elseif ($event instanceof CourseCreated) {
            $action = 'create_course';
            $details = ['course_id' => $event->courseId];
            $message = "Course created from IP address $ipAddress on $dateTime";
        } elseif ($event instanceof CourseUpdated) {
            $action = 'update_course';
            $details = ['course_id' => $event->courseId];
            $message = "Course updated from IP address $ipAddress on $dateTime";
        } elseif ($event instanceof CourseDeleted) {
            $action = 'delete_course';
            $details = ['course_id' => $event->courseId];
            $message = "Course deleted from IP address $ipAddress on $dateTime";
        } elseif ($event instanceof VideoCreated) {
            $action = 'create_video';
            $details = ['video_id' => $event->videoId];
            $message = "Video created from IP address $ipAddress on $dateTime";
        } elseif ($event instanceof ChatCreated) {
            $action = 'create_chat';
            $details = ['chat_id' => $event->chatId];
            $message = "Chat created from IP address $ipAddress on $dateTime";
        } elseif ($event instanceof LeadCreated) {
            $action = 'create_lead';
            $details = ['lead_id' => $event->leadId];
            $message = "Lead created from IP address $ipAddress on $dateTime";
        } elseif ($event instanceof LeadUpdated) {
            $action = 'update_lead';
            $details = ['lead_id' => $event->leadId];
            $message = "Lead updated from IP address $ipAddress on $dateTime";
        } elseif ($event instanceof LeadDeleted) {
            $action = 'delete_lead';
            $details = ['lead_id' => $event->leadId];
            $message = "Lead deleted from IP address $ipAddress on $dateTime";
        } elseif ($event instanceof StudentEnrolled) {
            $action = 'enroll_student';
            $details = ['student_id' => $event->student->id, 'course_id' => $event->course_id];
            $message = "Student enrolled in course from IP address $ipAddress on $dateTime";
        } elseif ($event instanceof StudentRemoved) {
            $action = 'remove_student';
            $details = ['student_id' => $event->student->id, 'course_id' => $event->course_id];
            $message = "Student removed from course from IP address $ipAddress on $dateTime";
        }

// Log the activity
        ActivityLog::create([
            'user_id' => $event->userId,
            'action' => $action,
            'details' => json_encode($details),
            'ip_address' => $ipAddress,
            'media_device' => $mediaDevice,
            'message' => $message,
        ]);

// Award badge based on activity
        $this->awardBadge($event->userId, $action);

// Award score based on activity
        $this->awardScore($event->userId, $event, $details, $message);
    }

/**
 * Award a badge to the user based on the action.
 *
 * @param  int  $userId
 * @param  string  $action
 * @return void
 */
    protected function awardBadge($userId, $action)
    {

        //  $eventName = get_class($event);
        //  dd($eventName);

// Find the badge associated with the action
        $badge = Badge::where('event_name', $action)->first();

        if ($badge) {
// Award the badge to the user
            UserBadge::create([
                'user_id' => $userId,
                'badge_id' => $badge->id,
            ]);
        }
    }

/**
 * Award score to the user based on the event.
 *
 * @param  int  $userId
 * @param  string  $event
 * @param  array  $details
 * @return void
 */

    protected function awardScore($userId, $event, $details, $message)
    {
// Get the event name without the namespace
        $eventName = class_basename($event);
        \Log::info("Awarding score for event: $eventName", ['user_id' => $userId, 'details' => $details]);

// Fetch the score for the event
        $eventScore = EventScore::where('event_name', $eventName)->first();
        \Log::info($eventScore);

        $score = $eventScore ? $eventScore->score : 0;

        if ($score > 0) {

           
            $leaderboard = Leaderboard::where('user_id', $userId)->first();

            if ($leaderboard) {
                $leaderboard->score += $score;
                $leaderboard->save();
            } else {
                Leaderboard::create([
                    'user_id' => $userId,
                    'score' => $score,
                ]);
            }


            ScoreHistory::create([
                'user_id' => $userId,
                'increment' => $score,
                'event' => $eventName,
                'description' => $message,
                'updated_by' => $userId,
            ]);


            

        }

    }

}
