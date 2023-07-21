<?php

namespace App\Models\OD_cn;

use Carbon\Carbon;
use App\Casts\BillCycle;
use App\Casts\OrderType;
use App\Models\OrderDrop;
use App\Casts\OrderStatus;
use App\Casts\PaymentCode;
use App\Models\OD_cn\Store;
use App\Casts\AsIntegerable;
use App\Casts\AsDatetimeable;
use App\Models\OrderFreeze;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $connection = 'live_mysql';
    protected $table = 'order';
    protected $primaryKey = 'order_id';


    public $appends = [
        'preview_url',
    ];

    protected $casts = [
        'order_state' => OrderStatus::class,
        'order_type' => OrderType::class,
        'payment_code' => PaymentCode::class,
        'bill_cycle' => BillCycle::class,
        'handling_fee' => AsIntegerable::class,
        'handling_fee_ratio' => AsIntegerable::class,
        'payment_time' => AsDatetimeable::class,
        'order_date' => AsDatetimeable::class,
        'confirm_cash_pay_time' => AsDatetimeable::class,

    ];

    public function getPreviewUrlAttribute()
    {
        return 'https://ui-avatars.com/api/?name=N+O&color=7F9CF5&background=EBF4FF';
    }

    public function order_drop()
    {
        return $this->belongsTo(
            OrderDrop::class,
            'order_id',
            'order_id'
        );
    }

    public function recipe()
    {
        return $this->belongsTo(
            OrderFreeze::class,
            'order_sn',
            'order_sn'
        );
    }

    public function bayer(): object
    {
        return $this->belongsTo(
            Order_common::class,
            'order_id',
            'order_id'
        )->select(['order_id', 'reciver_info']);
    }

    public function store(): object
    {
        return $this->belongsTo(Store::class, 'store_id', 'store_id')
            ->select([
                'store_id',
                'store_name',
                'store_address',
                'member_id'
            ]);
    }

    public function order_items(): object
    {
        return $this->hasMany(
            Order_goods::class,
            'order_id',
            'order_id'
        );
    }
    public function products(): object
    {
        return $this->hasMany(
            Order_goods::class,
            'order_id',
            'order_id'
        )->with('parrent_product')
            ->select([
                'order_id',
                'goods_commonid',
                'goods_id',
                'goods_name',
                'goods_price',
                'goods_num',
                'goods_image',
                'goods_pay_price',
                'commis_rate'
            ])
            ->orderBy('rec_id', 'desc');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'buyer_id', 'member_id');
    }

    public function scopeForm(Builder $builder)
    {
        $builder->select([
            'order.order_id',
            'order.store_name',
            'order.order_sn',
            'order.add_time As order_date',
            'order.store_id',
            'order.store_name',
            'order.buyer_id',
            'order.buyer_name',
            'order.confirm_cash_pay_time',
            'order.delivery_fee',
            'order.shipping_fee_home',
            'order.order_amount',
            'order.goods_amount',
            'order.order_state',
            'order.order_state As order_state_id',
            'order.add_time'
        ])
            ->selectRaw('
            (SELECT SUM(goods_num) from aiteshop_order_goods WHERE order_id = aiteshop_order.order_id) As total_quantity,
            (SELECT SUM(goods_pay_price) from aiteshop_order_goods WHERE order_id = aiteshop_order.order_id) As total_price,
            (aiteshop_order.shipping_fee_home + aiteshop_order.delivery_fee) As total_delivery_fee,
            ((SELECT SUM(goods_pay_price) from aiteshop_order_goods WHERE order_id = aiteshop_order.order_id) + (aiteshop_order.shipping_fee_home + aiteshop_order.delivery_fee)) As grand_total_price,
            ROW_NUMBER()OVER (PARTITION BY FROM_UNIXTIME(aiteshop_order.add_time, "%Y-%m") ORDER BY FROM_UNIXTIME(aiteshop_order.add_time, "%Y-%m")) As rnumber
        ')
            ->with([
                'bayer',
                'order_items' =>  function ($query) {
                    $query->join(
                        'goods_common',
                        'order_goods.goods_commonid',
                        '=',
                        'goods_common.goods_commonid'
                    );

                    $query->join(
                        'goods_common_lang',
                        'goods_common_lang.goods_commonid',
                        '=',
                        'goods_common.goods_commonid'
                    );
                    $query->where('goods_common_lang.language_id', 5);

                    $query->select([
                        'order_goods.order_id',
                        'order_goods.goods_id',
                        'order_goods.goods_name As order_good_name',
                        'order_goods.goods_image',
                        'order_goods.goods_commonid',
                        'goods_common.bar_code',
                        'goods_common_lang.goods_name As product_name',
                        'order_goods.goods_price',
                        'order_goods.goods_num  As order_quantity',
                        'order_goods.goods_pay_price As total_price',
                        DB::raw(' round(  aiteshop_order_goods.goods_pay_price / aiteshop_order_goods.goods_num, 2) As product_price')
                    ]);
                }
            ])
            ->search(request('term'))
            ->where('order.store_id', '=', config('app.default_store_id'));
        return $builder;
    }

    public function scopeStatus(Builder $builder, $term = 0): object
    {
        switch ($term) {
            case 10:
                $builder->where([
                    'order.order_state' => 10,
                    'order.payment_code' => 'cash',
                    'order.confirm_cash_pay_time' => 0
                ]);
                break;
            case 20:
                $builder->where([
                    'order.order_state' => 20,
                ]);
                break;
            case 30:
                $builder->where([
                    'order.order_state' => 30,
                ]);
                break;
            case 40:
                $builder->where([
                    'order.order_state' => 40,
                ]);
                break;
            default:

                $builder->whereIn('order_state', [20, 30, 35, 40]);
                 $builder->orWhere([
                    ['order.order_state', '=', 10],
                    ['order.confirm_cash_pay_time', '=', 0],
                    ['order.payment_code', 'like', '%cash%']
                ]);
        }
        return $builder;
    }

    public function scopeMonth(Builder $builder, $date)
    {
        if (!is_null($date)) {
            $builder->whereBetween('add_time', [
                strtotime(Carbon::createFromFormat('d-m-Y', $date)->startOfMonth()),
                strtotime(Carbon::createFromFormat('d-m-Y', $date)->endOfMonth()),
            ]);
        }
        return $builder;
    }

    public function scopeRecipeNumber(Builder $builder)
    {
        return $builder->selectRaw('
            ROW_NUMBER()OVER (PARTITION BY FROM_UNIXTIME(aiteshop_order.add_time, "%Y-%m") ORDER BY FROM_UNIXTIME(aiteshop_order.add_time, "%Y-%m")) As rnumber
        ');
    }

    public function getOrderDateHumanAttribute($value)
    {

        return Carbon::parse($value)->format('H:i');
        // return Carbon::parse($value)->diffForHumans();

    }

    public function scopeLastRate(Builder $builder, $rate = 4000)
    {
        $builder->selectRaw(
            "
        '".$rate."' As riel_currency_rate,
        'khr' As curruncy_riel,
        '$' As currency,
        ROUND(((SELECT SUM(goods_pay_price) from aiteshop_order_goods WHERE order_id = aiteshop_order.order_id) + (aiteshop_order.shipping_fee_home + aiteshop_order.delivery_fee)) * '" . $rate . "' ) As grand_total_price_riel"
        );
    }

    public function scopeSearch(Builder $builder, $term): object
    {
        if (!is_null($term)) {

            $builder->where('order.order_sn', 'REGEXP', $term . '$');
            $builder->orWhere('order.order_id', '=', $term);
            $builder->orWhere('order.buyer_name', 'like', $term . '%');

            $builder->orWhereHas('member', function ($query) use ($term) {
                return $query->where('member_mobile', 'like', '%' . $term . '%');
            });
        }
        return $builder;
    }

    public function scopeBuyerNotIn(Builder $builder): object
    {
        $data = [
            23, 24, 256, 273, 272, 280, 273, 269, 255, 271, 253, 278, 282, 551,
            552, 254, 274, 275, 276, 279, 281, 283, 289, 365, 605, 606, 607, 614,
            615, 616, 617, 618, 619, 620, 621, 622, 623, 624, 625, 626, 627, 628,
            629, 630, 631, 632, 633, 634, 635, 636, 637, 638, 639, 640, 641, 642,
            643, 644, 645, 646, 647, 648, 649, 650, 651, 652, 653, 654, 655, 656,
            657, 658, 661, 662, 663, 664, 665, 666, 667, 668, 669, 670, 671, 672,
            674, 675, 676, 677, 678, 679, 709, 711, 712, 713, 714, 715, 716, 717,
            718, 719, 720, 721, 917, 918, 919, 920, 921, 922, 923, 924, 925, 926,
            927, 1174, 1221, 1312, 1652, 1669, 1671, 1673, 1802, 1803
        ];

        $builder->whereNotIn('order.buyer_id', $data);
        $builder->whereNotIn('order.order_state', [0, 10]);
        return $builder;
    }
}
