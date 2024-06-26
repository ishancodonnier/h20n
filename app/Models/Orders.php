<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserAddress;
use App\Models\Users;
use Illuminate\Database\Eloquent\Collection;

class Orders extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';
    protected $table = 'orders';
    public $timestamps = false;

    protected $fillable = [
        'order_hash_id',
        'order_status',
        'driver_token',
        'user_token',
        'order_detail',
        'user_address_id',
        'created_date',
        'updated_date',
        'is_deleted',
        'warehouse_id',
        'delivery_time',
        'contact_name',
        'contact_number',
        'area_zone',
        'local_area_id'
    ];

    protected $casts = [
        'order_detail' => 'array',
    ];

    public function driver()
    {
        return $this->belongsTo(Users::class, 'driver_token', 'user_token');
    }

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_token', 'user_token');
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class, 'user_address_id', 'user_address_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'warehouse_id');
    }

    public function local_area()
    {
        return $this->belongsTo(DeliveryArea::class, 'local_area_id', 'delivery_area_id');
    }

    // public function products()
    // {
    //     if($this->order_detail) {
    //         $productIds = array_column($this->order_detail, 'product_id');
    //         $quantity = array_column($this->order_detail, 'quantity');

    //         $products = array();
    //         foreach($productIds as $key => $prod_id) {
    //             $prod = Products::where('product_id', $prod_id)->get();
    //             $products[] = [
    //                 'product' => $prod,
    //                 'quantity' => $quantity[$key]
    //             ];
    //         }
    //         return $products;
    //     } else {
    //         return [];
    //     }
    // }

    public function getProductsAttribute()
    {
        if ($this->order_detail) {
            $productIds = array_column($this->order_detail, 'product_id');
            $quantities = array_column($this->order_detail, 'quantity');

            $products = Products::whereIn('product_id', $productIds)->with(['category'])->get();

            return $products->map(function ($product) use ($quantities) {
                $productId = $product->product_id;
                $quantityKey = array_search($productId, array_column($this->order_detail, 'product_id'));
                $product->quantity = $this->order_detail[$quantityKey]['quantity'];
                return $product;
            });
        } else {
            return new Collection();
        }
    }
}
