<?php

namespace Mortezaa97\Orders\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mortezaa97\Orders\Models\Cart;
use Mortezaa97\Orders\Models\Order;
use Mortezaa97\Orders\Services\OrderService;

class PayCartController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request,Cart $cart)
    {
        try {
            DB::beginTransaction();
            if (! $cart->created_by) {
                $cart->update(['created_by' => Auth::user()->id]);
                $cart->refresh();
            }
            $orderService = new OrderService;
            $order = $orderService->createOrderFromCart($cart);
            // $payType = PayType::where('id', $cart->pay_type_id)->first();

            // if ($payType->title === 'پرداخت از کیف پول') {
            //     if (Auth::user()->wallet < $cart->payable_price) {
            //         throw new \Exception('اعتبار کافی برای کسر از کیف پول ندارید');
            //     }

            //     $gateway = 'wallet';
            // } elseif ($payType->title === 'پرداخت آنلاین ( درگاه بانک ملی )') {
            //     $gateway = 'sadad';
            // } elseif ($payType->title === 'پرداخت آنلاین ( درگاه بانک صادرات )') {
            //     $gateway = 'sepehr';
            // } else {
            $gateway = 'zibal';
            // }
            $paymentService = new PaymentService();
            $payment = $paymentService->pay(Auth::user(), $order->payable_price, Order::class, $order->id, $gateway);
            // if ($payType->title === 'پرداخت از کیف پول') {
            //     $order->setStatus('پرداخت شده');
            // }

            if ($gateway != "$gateway") {
                $smsService = new SmsService();
                $smsService->sendVerifyWithKavenegar(
                    $order->user->cellphone,
                    'customerPendingOrder',
                    $order->user->first_name,
                    $order->code,
                    ''
                );
            }

            DB::commit();

            return $payment;
        } catch (\Exception $exception) {
            return response($exception, 419);
        }
    }
}
