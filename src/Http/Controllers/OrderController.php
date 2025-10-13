<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Mortezaa97\Orders\Http\Resources\OrderResource;
use Mortezaa97\Orders\Http\Resources\OrderSimpleResource;
use Mortezaa97\Orders\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Order::class);

        $orders = Order::with(['sendType', 'payType'])->where('user_id', Auth::user()?->id)->get();

        return OrderSimpleResource::collection($orders);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Order::class);
        try {
            DB::beginTransaction();
            // TODO: Implement order creation logic
            DB::commit();
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), 419);
        }

        return response()->json('سفارش با موفقیت ثبت شد');
    }

    public function show(Order $order)
    {
        Gate::authorize('view', $order);

        $order->load(['address', 'coupon', 'sendType', 'payType', 'createdBy', 'user', 'payments', 'products.product.parent', 'products.product.attributeProducts']);

        return new OrderResource($order);
    }

    public function update(Request $request, Order $order)
    {
        Gate::authorize('update', $order);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), 419);
        }

        return new OrderResource($order);
    }

    public function destroy(Order $order)
    {
        Gate::authorize('delete', $order);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), 419);
        }

        return response()->json('با موفقیت حذف شد');
    }

    public function print(Order $order)
    {
        Gate::authorize('view', $order);

        // Load all necessary relationships
        $order->load([
            'address',
            'coupon',
            'sendType',
            'payType',
            'createdBy',
            'user',
            'payments',
            'products.product.parent',
            'products.product.attributeProducts',
        ]);

        // Return print-friendly view
        return view('orders.print', compact('order'));
    }
}
