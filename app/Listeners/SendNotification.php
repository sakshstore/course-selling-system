<?php
namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Events\CourseViewed;
use App\Events\CourseCreated;
use App\Events\CourseUpdated;
use App\Events\CourseDeleted;
use App\Events\VideoCreated;
use App\Events\ChatCreated;
use App\Events\LeadCreated;
use App\Events\LeadUpdated;
use App\Events\LeadDeleted;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ActivityNotification;

class SendNotification
{
public function handle($event)
{
$notificationData = [];

if ($event instanceof UserLoggedIn) {
$notificationData = ['message' => 'User logged in'];
} elseif ($event instanceof CourseViewed) {
$notificationData = ['message' => 'Course viewed', 'course_id' => $event->courseId];
} elseif ($event instanceof CourseCreated) {
$notificationData = ['message' => 'Course created', 'course_id' => $event->courseId];
} elseif ($event instanceof CourseUpdated) {
$notificationData = ['message' => 'Course updated', 'course_id' => $event->courseId];
} elseif ($event instanceof CourseDeleted) {
$notificationData = ['message' => 'Course deleted', 'course_id' => $event->courseId];
} elseif ($event instanceof VideoCreated) {
$notificationData = ['message' => 'Video created', 'video_id' => $event->videoId];
} elseif ($event instanceof ChatCreated) {
$notificationData = ['message' => 'Chat created', 'chat_id' => $event->chatId];
} elseif ($event instanceof LeadCreated) {
$notificationData = ['message' => 'Lead created', 'lead_id' => $event->leadId];
} elseif ($event instanceof LeadUpdated) {
$notificationData = ['message' => 'Lead updated', 'lead_id' => $event->leadId];
} elseif ($event instanceof LeadDeleted) {
$notificationData = ['message' => 'Lead deleted', 'lead_id' => $event->leadId];
}

Notification::send($event->user, new ActivityNotification($notificationData));
}
}