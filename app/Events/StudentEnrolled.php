<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Student;
use App\Models\Course;


class StudentEnrolled
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $student;
    public $userId;
    public $course_id;
    
    public function __construct(Student $student,   $course_id,$userId)
    {
    $this->student = $student;
    $this->course_id = $course_id;

    $this->userId = $userId;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
