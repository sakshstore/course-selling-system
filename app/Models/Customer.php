<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
use HasFactory;

protected $fillable = [
'name',
'email',
'mobile',
'address',
'tax_number',
'city',
'pin'
];

public function invoices()
{
return $this->hasMany(Invoice::class);
}
}