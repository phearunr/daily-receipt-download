<?php

namespace App\Models\OD_cn;

use App\Models\OrderDropItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order_goods extends Model
{
    use HasFactory;
    protected $connection = 'live_mysql';
    protected $table = 'order_goods';
    // protected $appends = [];

    public function goods(): object
    {
        return $this->belongsTo(Goods::class, 'goods_id', 'goods_id')
            ->with(['translations' => function ($q) {
                $q->select([
                    'goods_id',
                    'language_id',
                    'goods_name',
                    'goods_spec'
                ]);
            }])
            ->select([
                'goods_id', 'goods_price', 'goods_image'
            ]);
    }

    public function parrent_product(): object
    {
        return $this->hasMany(Goods_common::class, 'goods_commonid', 'goods_commonid')
            ->with('languages')
            ->select(
                'goods_common.goods_commonid',
                'goods_common.bar_code',
            );
    }

    public function refund_return(): object
    {
        return  $this->hasOne(Refund_return::class, 'order_id', 'order_id')
            ->select(
                'order_id',
                'order_goods_id',
                'refund_amount',
                'refund_state',
                DB::raw('ifnull(refund_state,0) as is_refunded')
            );
    }

    public function order_drop_items(): object
    {
        return $this->hasOne(OrderDropItem::class, 'product_id', 'goods_id');
    }

    public function order(): object
    {
        return $this->hasMany(
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
                'add_time order_date',
                'goods_amount',
                'order_amount',
                'order_state',
                'delivery_fee',
                'shipping_fee_home'
            ]);
    }

    public function getGoodsImageAttribute($value): string
    {
        return empty($value) ? '' : config('app.image_url') . $value;
    }
}
