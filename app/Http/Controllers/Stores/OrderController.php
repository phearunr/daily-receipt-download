<?php

namespace App\Http\Controllers\Stores;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\OD_cn\Order;
use App\Models\OrderFreeze;
use Illuminate\Support\Str;
use App\Exports\OrderExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Resources\Stores\OrderResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $items =
            OrderResource::collection(
                Order::query()
                    ->form()
                    ->status(request('status'))
                    ->lastRate(request('rate', 4000))
                    ->orderByDesc('order.order_id')
                    ->paginate()
            );

        // return $items;
        if ($request->wantsJson()) return $items;

        return Inertia::render('IndexOrders', [
            'items' => $items,
            'rates' => [
                [
                    'label' => '4000',
                    'value' => '4000'
                ],
                [
                    'label' => '4020',
                    'value' => 4020
                ],
                [
                    'label' => '4100',
                    'value' => 4100
                ],
                [
                    'label' => '4120',
                    'value' => 4120
                ],
                [
                    'label' => '4150',
                    'value' => 4150
                ]
            ],
            'order_status' => [
                [
                    'label' => 'Alls',
                    'value' => 'alls'
                ],
                [
                    'label' => 'Reviews',
                    'value' => 10
                ],
                [
                    'label' => 'Ship',
                    'value' => 20
                ],
                [
                    'label' => 'Receive',
                    'value' => 30
                ],
                [
                    'label' => 'Complete',
                    'value' => 40
                ],

            ],
            'queryParams' => request()->all(['store', 'status', 'month', 'rate', 'term'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function download(string $id)
    {
        $this->recipe_freeze_numbers(request('store_id', 1590));

        $item = Order::query()
            ->form()
            ->lastRate(request('rate', 4000))
            ->findOrFail($id);

        QrCode::format('png')->generate(
            $item['order_sn'],
            public_path('/QRCode/' . $item['order_sn'] . '.png')
        );

        return Excel::download(new OrderExport(
            [
                'order' => [
                    'order_sn' => $item['order_sn'],
                    'order_date' => $item['order_date'],
                    'recipe_sn' =>  @Str::of($item['order_sn'])->substr(8) ?? NULL,
                    'recipe_number' => $item->recipe['recipe_number'],
                    'buyer_id' => $item['buyer_id'],
                    'buyer_name' => $item['buyer_name'],
                    'bayer_mobile' => @$item->bayer['reciver_info']['phone'] ?? NULL,
                    'buyer_address' => @$item->bayer['reciver_info']['address'] ??  NULL,
                    'store_id' => $item['store_id'],
                    'store_name' => $item['store_name'],
                    'products' => $item['order_items'],
                    'currency' => $item['currency'],
                    'exchange_rate' => request('rate', 4000),
                    'total_quantity' => 2,
                    'delivery_fee' =>  $item['total_delivery_fee'],
                    'total_price' => $item['total_price'],
                    'grand_total_price' => $item['grand_total_price'],
                    'grand_total_price_riel' => $item['grand_total_price_riel']
                ]
            ],
            count($item['order_items']) ?? 9,
            $item['order_sn']
        ), $item['order_sn'] . '.xlsx');
    }

    private function recipe_freeze_numbers($store_id = 0): bool
    {
        $recipe_freeze_number = Order::query()
            ->form()
            ->where([
                'order.store_id' => $store_id
            ])
            ->when(
                Order::query()
                    ->where([
                        'store_id' => $store_id
                    ])->exists(),
                function ($query) {
                    $query->whereBetween(
                        'order.add_time',
                        [
                            strtotime(Carbon::now()->startOfMonth()),
                            strtotime(Carbon::now()->endOfMonth())
                        ]
                    );
                }
            )
            ->orderBy('order.order_id', 'asc')
            ->get()
            ->map(function ($item) {
                if (!OrderFreeze::query()
                    ->where([
                        'store_id' => $item['store_id'],
                        'order_sn' => $item['order_sn']
                    ])
                    ->exists()) {
                    OrderFreeze::create([
                        'store_id' => $item['store_id'],
                        'order_id' => $item['order_id'],
                        'order_sn' => $item['order_sn'],
                        'order_full_number' => $item['rnumber'],
                        'recipe_reference' => Str::of($item['order_sn'])->substr(8) ?? 0,
                        'buyer_id' => $item['buyer_id'],
                        'order_date' =>  date('Y-m-d H:i:s', strtotime($item['order_date'])),
                    ]);
                }
            });

        return !empty($recipe_freeze_number) ? true : false;
    }
}
