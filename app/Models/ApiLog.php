<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ApiLog extends Model
{
    protected $fillable = [
        'user_id', 'method', 'url', 'ip_address', 'user_agent', 'response_status'
        ];
}
