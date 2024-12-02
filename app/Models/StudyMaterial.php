<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'file_path',
        'type',
        'uploaded_by',
        'upload_date',
        'visibility',
        'tags',
        'order',
        'thumbnail',
        'duration',
        'size'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function playlists()
{
return $this->belongsToMany(Playlist::class, 'playlist_study_material');
}
}
