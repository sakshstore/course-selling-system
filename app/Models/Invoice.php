<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'user_id',
        'invoice_number',
        'order_number',
        'invoice_date',
        'due_date',
        'customer_note',
        'terms',
        'status',
        'file_path'
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'description', 'price')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}