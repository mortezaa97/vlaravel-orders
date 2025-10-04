<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mortezaa97\Orders\Http\Resources\CartResource;
use Mortezaa97\Orders\Models\Cart;

class MergeCartController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Cart $cart)
    {
        try {
            DB::beginTransaction();
            if (! Auth::user()->active_cart) {
                $cart->update([
                    'create_by' => Auth::user()->id,
                ]);
            } else {
                $cartService = new CartService;
                $cartService->mergeCart($cart, Auth::user()->active_cart);
            }

            DB::commit();

            return new CartResource(Auth::user()->active_cart);
        } catch (Exception $exception) {
            return response($exception->getMessage(), 420);
        }
    }
}
