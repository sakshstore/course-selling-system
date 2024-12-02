<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    
protected $fillable = [
    'chat', 'user_id'
    ];
    
    public function user()
    {
    return $this->belongsTo(User::class);
    }
}
