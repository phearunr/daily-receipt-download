<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\OrderDrop;
use App\Models\OD_cn\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class DriverDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        abort_if(Gate::denies('driver_dashboard_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $today_start = strtotime(Carbon::now()->format('Y-m-d 00:00:00'));
        $today_end = strtotime(Carbon::now()->format('Y-m-d 23:59:59'));

        $orders = Order::query()
        ->select([
            'order_id',
            'add_time',
            'add_time As order_date_human',
            'order_sn',
            'buyer_name',
        ])
        ->with('bayer')
        ->whereBetween(
            'add_time',
            [$today_start, $today_end]
        )

        ->where('store_id', 1590)
        ->buyerNotIn()
        ->withSum('products', 'goods_num')
        ->orderBy('order.order_id', 'DESC')
        ->paginate();

        if(request()->wantsJson()) return $orders;

        return Inertia::render('DriverDashboard', [
            'date' => date('Y-m-d'),
            'todaySuccess' => OrderDrop::query()
                ->where([
                    'status' => 1, 'user_id' => auth()->id()
                ])
                ->whereDate('updated_at', Carbon::today())
                ->count(),
            'historyUntilNow' => OrderDrop::query()
                ->where(['status' => 1, 'user_id' => auth()->id()])
                ->count(),
            'orders' => $orders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
