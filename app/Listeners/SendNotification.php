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
use App\Events\UserLoggedIn;
use App\Events\VideoCreated;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Notification;

class SendNotification
{
    public function handle($event)
    {
        $notificationData = [];

        if ($event instanceof UserLoggedIn) {
            $notificationData = [
                'message' => 'A user has successfully logged in to the system.',
                'subject' => 'User Login Notification',
            ];
        } elseif ($event instanceof CourseViewed) {
            $notificationData = [
                'message' => 'The course with ID ' . $event->courseId . ' has been viewed.',
                'subject' => 'Course Viewed Notification',
                'course_id' => $event->courseId,
            ];
        } elseif ($event instanceof CourseCreated) {
            $notificationData = [
                'message' => 'A new course has been created with ID ' . $event->courseId . '.',
                'subject' => 'Course Created Notification',
                'course_id' => $event->courseId,
            ];
        } elseif ($event instanceof CourseUpdated) {
            $notificationData = [
                'message' => 'The course with ID ' . $event->courseId . ' has been updated.',
                'subject' => 'Course Updated Notification',
                'course_id' => $event->courseId,
            ];
        } elseif ($event instanceof CourseDeleted) {
            $notificationData = [
                'message' => 'The course with ID ' . $event->courseId . ' has been deleted.',
                'subject' => 'Course Deleted Notification',
                'course_id' => $event->courseId,
            ];
        } elseif ($event instanceof VideoCreated) {
            $notificationData = [
                'message' => 'A new video has been created with ID ' . $event->videoId . '.',
                'subject' => 'Video Created Notification',
                'video_id' => $event->videoId,
            ];
        } elseif ($event instanceof ChatCreated) {
            $notificationData = [
                'message' => 'A new chat has been created with ID ' . $event->chatId . '.',
                'subject' => 'Chat Created Notification',
                'chat_id' => $event->chatId,
            ];
        } elseif ($event instanceof LeadCreated) {
            $notificationData = [
                'message' => 'A new lead has been created with ID ' . $event->leadId . '.',
                'subject' => 'Lead Created Notification',
                'lead_id' => $event->leadId,
            ];
        } elseif ($event instanceof LeadUpdated) {
            $notificationData = [
                'message' => 'The lead with ID ' . $event->leadId . ' has been updated.',
                'subject' => 'Lead Updated Notification',
                'lead_id' => $event->leadId,
            ];
        } elseif ($event instanceof LeadDeleted) {
            $notificationData = [
                'message' => 'The lead with ID ' . $event->leadId . ' has been deleted.',
                'subject' => 'Lead Deleted Notification',
                'lead_id' => $event->leadId,
            ];
        }

        Notification::send($event->user, new UserNotification($notificationData));
    }
}
