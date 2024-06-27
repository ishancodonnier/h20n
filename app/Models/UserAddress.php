<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users;

class UserAddress extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_address_id';
    protected $table = 'user_address';
    public $timestamps = false;

    protected $fillable = [
        'user_address_id',
        'user_token',
        'address_type',
        'full_name',
        'address_line1',
        'address_line2',
        'city',
        'zip_code',
        'phone_number',
        'state',
        'warehouse_id',
        'area_zone',
        'local_area_id',
        'is_deleted',
        'created_date',
        'updated_date'
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_token', 'user_token');
    }

    public function warehouse()
    {
        return $this->hasOne(Warehouse::class, 'warehouse_id', 'warehouse_id');
    }

    public function local_area()
    {
        return $this->hasOne(DeliveryArea::class, 'delivery_area_id', 'local_area_id');
    }
}
