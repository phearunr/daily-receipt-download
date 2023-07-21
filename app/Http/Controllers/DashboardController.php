<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\OrderDrop;
use App\Models\OD_cn\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (in_array(auth()->user()->role, ['Driverman'])) {
            return to_route('drivers.dashboard.index');
        }
        return Inertia::render('Dashboard', []);
    }
}
