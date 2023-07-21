<?php

namespace App\Http\Controllers\System;

use App\Models\User;
use Inertia\Inertia;
use App\Models\OrderDrop;
use App\Models\OD_cn\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\OrderResource;
use App\Notifications\AddToBasketNotification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('notification_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        auth()->user()->unreadNotifications->markAsRead();
        $items =  auth()->user()->notifications()
            ->latest()
            ->withCasts([
                'updated_at' => 'datetime:y-m-d H:s',
                'created_at' => 'datetime:y-m-d H:s',
                'read_at' => 'datetime:y-m-d H:s',
            ])
            ->paginate();
        if (request()->wantsJson()) return $items;
        return Inertia::render('IndexNotifications', [
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
    public function fetch()
    {
        $order_drop = OrderDrop::find(1);
        // return $order_drop->user;
        // Notification::send($user, new OrdersNotification($orderData))
        // $user->notify(new AddToBasketNotification($orderData));;
        $user = User::find(1);
        $user->notify(new AddToBasketNotification($order_drop, auth()->user()));
        return $order_drop->user->notify(new AddToBasketNotification($order_drop, auth()->user()));
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
