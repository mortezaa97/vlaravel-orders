<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mortezaa97\Addresses\Models\Address;
use Mortezaa97\Orders\Http\Requests\CartStoreRequest;
use Mortezaa97\Orders\Http\Requests\CartUpdateRequest;
use Mortezaa97\Orders\Http\Resources\CartResource;
use Mortezaa97\Orders\Models\Cart;
use Mortezaa97\Orders\Models\SendType;
use Mortezaa97\Orders\Services\CartService;
use function Amp\Promise\first;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $item = new Cart;

        if ($request->storage_id) {
            $item = $item->where('storage_id', $request->storage_id);
        }

        return new CartResource($item->first());
    }

    public function store(CartStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $item = new Cart;
            $data = $request->only($item->fillable);

            $data['created_by'] = Auth::guard('api')->user()?->id;
            if (! isset($data['send_type_id'])) {
                // TODO: get it dynamically from settings
                $sendType = SendType::first();

                if ($sendType) {
                    $data['send_type_id'] = $sendType->id;
                }
            }
            $cart = $item->create($data);

            $cartService = new CartService;
            $cartService->updateCart($cart, $request->product_id, $request->count);

            DB::commit();
            $cart->refresh();

            return new CartResource($cart);
        } catch (Exception $exception) {
            return response($exception->getMessage(), 420);
        }
    }

    public function show(Cart $cart)
    {
        return new CartResource($cart);
    }

    public function update(CartUpdateRequest $request, Cart $cart)
    {
        try {
            DB::beginTransaction();
            $data = $request->only($cart->fillable);

            // Handle address creation if address_id is not provided
            if (! isset($data['address_id']) && isset($request->address)) {
                $addressData = json_decode($request->address, true);
                $address = Address::create([
                    'created_by' => Auth::user()->id,
                    ...$addressData,
                ]);
                $data['address_id'] = $address->id;
            }

            $cart->update($data);

            if (isset($request->product_id)) {
                $cartService = new CartService;
                $cartService->updateCart($cart, $request->product_id, $request->count);
            }
            DB::commit();
            $cart->refresh();

            return new CartResource($cart);
        } catch (Exception $exception) {
            return response($exception->getMessage(), 420);
        }
    }

    public function destroy(Cart $cart)
    {
        if ($cart->created_by) {
            if (Auth::check()) {
                if (Auth::user()->id !== $cart->created_by && ! Auth::user()->hasRole('admin')) {
                    return response('Unauthorized', 403);
                }
            }
        }

        return $cart->delete();
    }
}
