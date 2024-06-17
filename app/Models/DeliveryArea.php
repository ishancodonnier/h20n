<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryArea extends Model
{
    use HasFactory;

    protected $primaryKey = 'delivery_area_id';
    public $timestamps = false;

    protected $fillable = [
        'delivery_area_id',
        'delivery_area_name',
        'is_deleted',
        'created_date',
        'updated_date'
    ];
}
