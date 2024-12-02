<?php

namespace App\Models;
 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
use HasFactory;

protected $fillable = [
'ticket_id',
'user_id',
'message',
'is_read',
'attachment',
'message_type',
'parent_message_id',
];

public function user()
{
return $this->belongsTo(User::class);
}
}