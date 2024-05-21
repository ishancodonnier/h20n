<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_category_id';
    protected $table = 'product_categories';
    public $timestamps = false;

    protected $fillable = [
        'product_category_id',
        'product_category_name',
        'is_deleted',
        'created_date',
        'updated_date'
    ];
}
