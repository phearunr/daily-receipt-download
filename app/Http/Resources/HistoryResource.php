<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'pinpoint' => $this['pinpoint'],
            'latitude' => $this['latitude'],
            'longitude' => $this['longitude'],
            'comments' => $this['comments'],
            'status' => $this['status'],
            'order_id' => $this['order']['order_id'],
            'order_sn' => $this['order']['order_sn'],
            'buyer_id' => $this['order']['buyer_id'],
            'buyer_name' => $this['order']['buyer_name'],
            'order_date' => $this['order']['order_date'],
            'total_price' => $this['order']['goods_amount'],
            'total_quantity' => $this['order_drop_items_sum_order_quantity'],
            'total_drop_quantity' => $this['order_drop_items_sum_drop_quantity'],
            'grand_total_price' => $this['order']['order_amount'],
            'delivery_fee' => $this['order']['delivery_fee'],
            'preview_url' => $this['order']['preview_url'],
            'reciver_info' => $this['order']['bayer']['reciver_info'] ?? null,
            'currency' => '$',
            'order_items' => collect($this['order_items'])
                ->map(function ($item) {
                    return [
                        'order_id' => $item['order_id'],
                        'product_id' => $item['goods_id'],
                        'product_name' => $item['goods_name'],
                        'product_price' => $item['goods_price'],
                        'product_image' => $item['goods_image'],
                        'bar_code' => $item['bar_code'],
                        'order_quantity' => $item['goods_num'],
                        'goods_pay_price' => $item['goods_pay_price'],
                        'currency' => '$',
                        'drop_quantity' => $item['order_drop_items']['drop_quantity'] ?? 1,
                        'drop_status' => $item['order_drop_items']['drop_status']
                    ];
                })

         ];
        }
}
