<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
use HasFactory;

protected $fillable = [
'contact', 'campaign_id', 'status'
];
 



public function campaign()
{
return $this->belongsTo(Campaign::class);
}
}