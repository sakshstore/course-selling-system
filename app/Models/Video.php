<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [


        'course_id',
        'playlist_id',
        'user_id',       // Added user_id
        'title',
        'description',
        'path',          // Added path
        'url',

    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }
}