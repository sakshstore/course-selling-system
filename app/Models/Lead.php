<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lead extends Model
{

    protected $table = 'contacts'; // Specify the table name

    protected $fillable = ['name', 'email', 'phone', 'status', 'customer_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
 
    public function tags()
    {
    return $this->belongsToMany(Tag::class, 'contact_tag', 'contact_id', 'tag_id');
    }
    
}