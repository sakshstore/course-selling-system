<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventScore extends Model
{
use HasFactory;

protected $fillable = [
'event_name',
'score',
'user_id',
];
}