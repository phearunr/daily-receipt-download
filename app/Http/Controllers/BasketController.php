<?php

namespace App\Http\Controllers;

use App\Models\OrderDrop;
use App\Models\OD_cn\Order;
use Illuminate\Http\Request;
use App\Models\OrderDropItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Stores\OrderResource;
use App\Notifications\AddToBasketNotification;

class BasketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            OrderDrop::query()
                ->with('order_items', function ($query) {
                    $query->with('order_drop_items');
                    $query->leftJoin(
                        'goods_common',
                        'order_goods.goods_commonid',
                        '=',
                        'goods_common.goods_commonid'
                    );

                    $query->select([
                        'order_goods.order_id',
                        'order_goods.goods_id',
                        'order_goods.goods_name As product_name',
                        'order_goods.goods_price As product_price',
                        'order_goods.goods_image',
                        'goods_common.bar_code',
                        'order_goods.goods_num As order_quantity',
                        'order_goods.goods_pay_price As total_price',
                        DB::raw("
                        IF(aiteshop_order_goods.goods_num = 1, 1, 0) As drop_status,
                        '$' As currency
                    ")
                    ]);

                    $query->when(request('term'), function ($query) {
                        $query->where('goods_common.bar_code', request('term'));
                    });
                })
                ->where([
                    'status' => 0,
                    'user_id' => auth()->id()
                ])
                ->get()
                ->map(function ($order_drop) {
                    return [
                        'id' => $order_drop['id'],
                        'pinpoint' => $order_drop['pinpoint'],
                        'latitude' => $order_drop['latitude'],
                        'longitude' => $order_drop['longitude'],
                        'comments' => $order_drop['comments'],
                        'status' => $order_drop['status'],
                        'order_items' => collect($order_drop['order_items'])
                            ->map(function ($item) {
                                return [
                                    'order_id' => $item['order_id'],
                                    'goods_id' => $item['goods_id'],
                                    'product_name' => $item['product_name'],
                                    'product_price' => $item['product_price'],
                                    'goods_image' => $item['goods_image'],
                                    'bar_code' => $item['bar_code'],
                                    'order_quantity' => $item['order_quantity'],
                                    'total_price' => $item['total_price'],
                                    'currency' => $item['currency'],
                                    'drop_quantity' => $item['order_drop_items']['drop_quantity'] ?? 1,
                                    'drop_status' => $item['drop_status']
                                ];
                            })

                    ];
                })
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|unique:order_drops,order_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $orders =
            Order::query()
            ->with('order_items')
            ->findOr($request['order_id']);


        $order_drops = OrderDrop::query()
            ->create([
                'order_id' => $orders['order_id'],
                'status' => 0,
                'user_id' => auth()->id(),
            ]);

        collect($orders['order_items'])
            ->map(function ($item) use ($order_drops) {
                OrderDropItem::query()
                    ->create([
                        'order_drop_id' => $order_drops['id'],
                        'product_id' => $item['goods_id'],
                        'order_quantity' => $item['goods_num'],
                        'drop_quantity' => 1,
                        'drop_status' => $item['goods_num'] == 1 ? 1 : 0,
                        'drop_time' => now(),
                    ]);
            });

        $order_drops->user->notify(
            new AddToBasketNotification($order_drops, auth()->user(), 'scanout a new order')
        );
        return response()->json(['success' => 'added!.']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function confirm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
            'pinpoint' => 'required|array|min:1',
            'orders' => 'required|array|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $orders = collect($request['orders'])->map(function ($order) {
            $order_drop = OrderDrop::query()
                ->find($order['id']);
            $order_drop->update([
                'pinpoint' => request('pinpoint'),
                'latitude' => request('latitude'),
                'longitude' => request('longitude'),
                'status' => 1
            ]);

            collect($order['order_items'])->map(function ($item) use ($order) {
                OrderDropItem::query()
                    ->where([
                        'order_drop_id' => $order['id'],
                        'product_id' =>  $item['goods_id']
                    ])
                    ->first()
                    ->update([
                        'order_quantity' => $item['order_quantity'],
                        'drop_quantity' => $item['drop_quantity'],
                        'drop_status' => $item['drop_status'],
                        'drop_time' => now()
                    ]);
            });

            // send notification
            $order_drop->user->notify(
                new AddToBasketNotification($order_drop, auth()->user(), 'confirmed order')
            );
        });
        // return $orders;
        return response()->json(['success' => 'Confirm!.']);
    }

    public function confirmBarcodeIncreaseDropQuantity(Request $request, $order_drop_id)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $product = OrderDropItem::query()
            ->where([
                'order_drop_id' => $order_drop_id,
                'product_id' =>  $request['product_id']
            ])->first();
        $product->increment('drop_quantity', 1);
        return response()->json(['success' => 'verified!, and increase 1.']);
    }
}
