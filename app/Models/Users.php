<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserAddress;

class Users extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    protected $table = 'user';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'user_token',
        'auth_token',
        'first_name',
        'last_name',
        'email',
        'user_type',
        'user_profile_photo',
        'password',
        'social_id',
        'login_type',
        'country_code',
        'phone_number',
        'device_push_token',
        'device_type',
        'verify_forgot_code',
        'is_logged_out',
        'is_active',
        'is_deleted',
        'created_date',
        'updated_date'
    ];

    public function address() {
        return $this->hasMany(UserAddress::class, 'user_token', 'user_token');
    }
}
