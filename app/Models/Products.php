<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductCategories;
use App\Models\ProductImages;

class Products extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';
    protected $table = 'products';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'product_name',
        'product_description',
        'product_price',
        'product_category_id',
        'is_popular_product',
        'is_available',
        'is_deleted',
        'created_date',
        'updated_date'
    ];

    public function images()
    {
        return $this->hasMany(ProductImages::class, 'product_id', 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategories::class, 'product_category_id', 'product_category_id');
    }
}
