<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Http\Controllers;

use App\Http\Controllers\Controller;
use Mortezaa97\Orders\Http\Resources\CartResource;
use Mortezaa97\Orders\Models\Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CartController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Cart::class);

        return CartResource::collection(Cart::all());
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Cart::class);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), 419);
        }

        return new CartResource($cart);
    }

    public function show(Cart $cart)
    {
        Gate::authorize('view', $cart);

        return new CartResource($cart);
    }

    public function update(Request $request, Cart $cart)
    {
        Gate::authorize('update', $cart);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), 419);
        }

        return new CartResource($cart);
    }

    public function destroy(Cart $cart)
    {
        Gate::authorize('delete', $cart);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), 419);
        }

        return response()->json('با موفقیت حذف شد');
    }
}
