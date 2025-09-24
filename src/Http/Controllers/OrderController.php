<?php

namespace Mortezaa97\Orders\Http\Controllers;

use App\Http\Controllers\Controller;
use Mortezaa97\Orders\Models\Order;
use Illuminate\Http\Request;;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Mortezaa97\Orders\Http\Resources\OrderResource;
class OrderController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Order::class);
        return OrderResource::collection(Order::all());
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Order::class);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return new OrderResource($order);
    }

    public function show(Order $order)
    {
        Gate::authorize('view', $order);
        return new OrderResource($order);
    }

    public function update(Request $request, Order $order)
    {
        Gate::authorize('update', $order);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return new OrderResource($order);
    }

    public function destroy(Order $order)
    {
        Gate::authorize('delete', $order);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return response()->json("با موفقیت حذف شد");
    }
}
