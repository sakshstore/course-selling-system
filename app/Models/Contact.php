<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
protected $fillable = [
'name', 'email', 'phone', 'status', 'user_id',
'billing_address_line1', 'billing_address_line2', 'billing_city', 'billing_state', 'billing_country', 'billing_pin_code',
'shipping_address_line1', 'shipping_address_line2', 'shipping_city', 'shipping_state', 'shipping_country', 'shipping_pin_code'
];

public function user()
{
return $this->belongsTo(User::class);
}

public function notes()
{
return $this->hasMany(Note::class);
}

public function tags()
{
return $this->belongsToMany(Tag::class);
}

public function invoices()
{
return $this->hasMany(Invoice::class);
}
}
