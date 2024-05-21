<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'is_deleted',
        'created_date',
        'updated_date'
    ];
}
