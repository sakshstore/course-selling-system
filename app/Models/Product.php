<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'sku',
        'category_id',
        'stock_quantity',
        'image_url',
        'status',
        'discount',
        'weight',
        'dimensions',
        'tags',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
