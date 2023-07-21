<?php

namespace App\Http\Resources\Stores;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'product_id' => $this->goods_id,
            'product_name' => $this->product_name,
            'product_image' => $this->goods_image,
            'goods_commonid' => $this->goods_commonid,
            'product_price' => $this->product_price,
            'order_quantity' => $this->order_quantity,
            'drop_quantity' => 1,
            'total_price' => $this->total_price
        ];
        //return parent::toArray($request);
    }
}
