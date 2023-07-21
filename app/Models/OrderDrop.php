<?php

namespace App\Models;

use App\Models\OD_cn\Order;
use App\Casts\OrderDropStatus;
use App\Models\OD_cn\Order_goods;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDrop extends Model
{
    use HasFactory;
    protected $connection = 'sqlite';
    protected $table = 'order_drops';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'order_id',
        'pinpoint',
        'latitude',
        'longitude',
        'comments',
        'status'
    ];
    protected $casts = [
        'status' => OrderDropStatus::class,
       // 'pinpoint' => 'String'
    ];

    public function order(): object
    {
        return $this->hasOne(
            Order::class,
            'order_id',
            'order_id'
        )
            ->select([
                'order_id',
                'order_sn',
                'buyer_id',
                'buyer_name',
                'add_time',
                'add_time As order_date',
                'goods_amount',
                'order_amount',
                'order_state',
                'delivery_fee',
                'shipping_fee_home'
            ]);
    }


    public function order_items(): object
    {
        return $this->hasMany(Order_goods::class, 'order_id', 'order_id');
    }

    public function order_drop_items(): object
    {
        return $this->hasMany(OrderDropItem::class, 'order_drop_id', 'id');
    }

    public function user(): Object
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
