<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
use HasFactory;

protected $fillable = [
'type', 'subject', 'message', 'user_id'
];

public function recipients()
{
return $this->hasMany(Recipient::class);
}
}
