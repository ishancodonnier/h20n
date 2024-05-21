<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_resource_id';
    protected $table = 'product_resources';
    public $timestamps = false;

    protected $fillable = [
        'product_resource_id',
        'product_id',
        'product_resource_name',
        'product_resource_secondary_name',
        'product_resource_type',
        'is_deleted',
        'is_created',
        'is_updated'
    ];
}
