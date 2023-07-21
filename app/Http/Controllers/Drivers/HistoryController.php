<?php

namespace App\Http\Controllers\Drivers;

use Inertia\Inertia;
use App\Models\OrderDrop;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\HistoryResource;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('history_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $items =
            HistoryResource::collection(
                OrderDrop::query()
                    ->with([
                        'order.bayer',
                        'order_items' => function ($query) {
                            $query->with([
                                'order_drop_items',
                            ]);
                            $query->select([
                                'rec_id',
                                'order_id',
                                'goods_id',
                                'goods_commonid',
                                'goods_name',
                                'goods_price',
                                'goods_num',
                                'goods_image',
                                'goods_num'
                            ]);
                        }
                    ])

                    ->where([
                        'status' => 1,
                        'user_id' => auth()->id()
                    ])
                    ->withSum('order_drop_items', 'order_quantity')
                    ->withSum('order_drop_items', 'drop_quantity')
                    ->paginate()
            );
        if (request()->wantsJson()) return $items;
        return Inertia::render('IndexHistory', [
            'items' => $items
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
