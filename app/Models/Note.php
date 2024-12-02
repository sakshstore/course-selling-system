<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['contact_id', 'content'];

    public function contact()
    {
    return $this->belongsTo(Contact::class);
    }
}
