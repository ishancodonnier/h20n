<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $primaryKey = 'warehouse_id';
    protected $table = 'warehouse';
    public $timestamps = false;

    protected $fillable = [
        'warehouse_id',
        'warehouse_name',
        'warehouse_area',
        'warehouse_zip_code',
        'warehouse_address_line1',
        'warehouse_address_line2',
        'warehouse_lat',
        'warehouse_lon',
        'is_deleted',
        'created_date',
        'updated_date'
    ];
}
