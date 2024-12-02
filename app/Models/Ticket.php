<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //

    
    protected $fillable = [
        'title', 'description', 'category', 'priority', 'status', 'user_id'
        ];

    public function user()
{
return $this->belongsTo(User::class);
}


}
