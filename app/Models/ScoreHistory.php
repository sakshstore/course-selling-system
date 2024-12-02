<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'increment',
        'event',
        'description',
        'updated_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
