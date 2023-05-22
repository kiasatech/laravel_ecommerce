<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\ProductVariation;
use App\PaymentGateway\Pay;
use App\PaymentGateway\Zarinpal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'address_id' => 'required',
            'payment_method' => 'required',
        ]);

        if ($validator->fails()) {
            alert()->error('دقت کنید', 'انتخاب آدرس تحویل سفارش الزامی می باشد')->persistent('حله');
            return redirect()->back();
        }

        $checkCart = $this->checkCart();
        if (array_key_exists('error', $checkCart)) {
            alert()->error('دقت کنید', $checkCart['error']);
            return redirect()->route('home.index');
        }

        $amounts = $this->getAmounts();
        if (array_key_exists('error', $amounts)) {
            alert()->error('دقت کنید', $amounts['error']);
            return redirect()->route('home.index');
        }

        if ($request->payment_method == 'pay') {
            $payGateway = new Pay();
            $payGatewayRasult = $payGateway->send($amounts, $request->address_id);
            if (array_key_exists('error', $payGatewayRasult)) {
                alert()->error('دقت کنید', $payGatewayRasult['error'])->persistent('حله');
                return redirect()->back();
            }else{
                return redirect()->to($payGatewayRasult['success']);
            }
        }

        if ($request->payment_method == 'zarinpal') {
            $zarinpalGateway = new Zarinpal();
            $zarinpalGatewayRasult = $zarinpalGateway->send($amounts, 'خرید تستی', $request->address_id);
            if (array_key_exists('error', $zarinpalGatewayRasult)) {
                alert()->error('دقت کنید', $zarinpalGatewayRasult['error'])->persistent('حله');
                return redirect()->back();
            }else{
                return redirect()->to($zarinpalGatewayRasult['success']);
            }
        }

        alert()->error('دقت کنید', 'درگاه پرداخت انتخابی اشتباه میباشد');
        return redirect()->back();
    }

    public function paymentVerify(Request $request, $gatewayName)
    {
        if ($gatewayName == 'pay')
        {
            $payGateway = new Pay();
            $payGatewayRasult = $payGateway->verify($request->token, $request->status);
            if (array_key_exists('error', $payGatewayRasult)) {
                alert()->error('دقت کنید', $payGatewayRasult['error'])->persistent('حله');
                return redirect()->back();
            }else{
                alert()->success('با تشکر', $payGatewayRasult['success']);
                return redirect()->route('home.index');
            }
        }

        if ($gatewayName == 'zarinpal')
        {
            $amounts = $this->getAmounts();
            if (array_key_exists('error', $amounts)) {
                alert()->error('دقت کنید', $amounts['error']);
                return redirect()->route('home.index');
            }

            $zarinpalGateway = new Zarinpal();
            $zarinpalGatewayRasult = $zarinpalGateway->verify($request->Authority, $amounts['paying_amount']);
            if (array_key_exists('error', $zarinpalGatewayRasult)) {
                alert()->error('دقت کنید', $zarinpalGatewayRasult['error'])->persistent('حله');
                return redirect()->back();
            }else{
                alert()->success('با تشکر', $zarinpalGatewayRasult['success']);
                return redirect()->route('home.index');
            }
        }

        alert()->error('دقت کنید', 'مسیر بازگشت از درگاه پرداخت اشتباه میباشد');
        return redirect()->route('home.orders.checkout');
    }

    public function checkCart()
    {
        if (\Cart::isEmpty()) {
            return ['error' => 'سبد خرید شما خالی می باشد'];
        }

        foreach (\Cart::getContent() as $item) {
            $variation = ProductVariation::find($item->attributes->id);

            $price = $variation->is_sale ? $variation->sale_price : $variation->price;

            if ($item->price != $price) {
                \Cart::clear();
                return ['error' => 'قیمت محصول تغییر پیدا کرد'];
            }

            if ($item->quantity > $variation->quantity) {
                \Cart::clear();
                return ['error' => 'تعداد محصول تغییر پیدا کرد'];
            }

            return ['success' => 'success!'];
        }
    }

    public function getAmounts()
    {
        if (session()->has('coupon')) {
            $checkCoupon = checkCoupon(session()->get('coupon.code'));
            if (array_key_exists('error', $checkCoupon)) {
                return $checkCoupon;
            }
        }

        return [
            'total_amount' => (\Cart::getTotal() + cartTotalSaleAmount()),
            'delivery_amount' => cartTotalDeliveryAmount(),
            'coupon_amount' => session()->has('coupon') ? session()->get('coupon.amount') : 0,
            'paying_amount' => cartTotalAmount()
        ];
    }
}
