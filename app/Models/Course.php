<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'instructor_id',
        'category',
        'duration',
        'level',
        'price',
        'start_date',
        'end_date',
        'status',
        'thumbnail' // Add this line
        
    ];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function studyMaterials()
    {
        return $this->hasMany(StudyMaterial::class);
    }


    public function students()
{
return $this->belongsToMany(Student::class, 'course_user', 'course_id', 'student_id'); // Ensure correct pivot table and keys
}


}
