<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';
    protected $table = 'orders';
    public $timestamps = false;

    protected $fillable = [
        'order_hash_id',
        'order_status',
        'user_token',
        'order_detail',
        'user_address_id',
        'is_deleted',
        'created_date',
        'updated_date'
    ];
}
