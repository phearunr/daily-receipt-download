<?php

namespace App\Http\Resources\Stores;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order_id' => $this->order_id,
            'order_sn' => $this->order_sn,
            'order_date' => $this->order_date,
            'buyer_name' => $this->buyer_name,
            'store_id' => $this->store_id,
            'store_name' => $this->store_name,
            'featured_image' => $this->preview_url,
            'grand_total_price' => $this->grand_total_price,
            'grand_total_riel'=> $this->grand_total_price_riel,
            'total_quantity' => $this->total_quantity,
            'total_price' => $this->total_price,
            'total_delivery_fee' => $this->total_delivery_fee,
            'order_state' => $this->order_state,
            'delivery_fee' => $this->delivery_fee,
            'shipping_fee_home' => $this->shipping_fee_home,
            'add_time' => $this->add_time,
            'order_items' => OrderItemResource::collection($this->order_items),
            'currency' => $this->currency,
            'curruncy_riel' => $this->curruncy_riel,
            'riel_currency_rate' => $this->riel_currency_rate
        ];
    }
}
