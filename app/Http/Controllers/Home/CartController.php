<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Province;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'qtybutton' => 'required'
        ]);

        $product = Product::findOrFail($request->product_id);
        $productVariation = ProductVariation::findOrFail(json_decode($request->variation)->id);

        if ($request->qtybutton > $productVariation->quantity){
            alert()->error('دقت کنید', 'تعداد محصول انتخابی درست نمی باشد')->persistent('حله');
            return redirect()->back();
        }

        $rowId = $product->id . '-' . $productVariation->id;
        if (Cart::get($rowId) == null) {
            Cart::add(array(
                'id' => $rowId,
                'name' => $product->name,
                'price' => $productVariation->is_sale ? $productVariation->sale_price : $productVariation->price,
                'quantity' => $request->qtybutton,
                'attributes' => $productVariation->toArray(),
                'associatedModel' => $product,
            ));
        }else{
            alert()->warning('انجام نشد', 'این محصول از قبل به سبد خرید اضافه شده است');
            return redirect()->back();
        }

        alert()->success('انجام شد', 'محصول مورد نظر به سبد خرید شما اضافه شد');
        return redirect()->back();
    }

    public function index()
    {
        return view('home.cart.index');
    }

    public function update(Request $request)
    {
        $request->validate([
           'qtybutton' => 'required'
        ]);

        foreach ($request->qtybutton as $rowId => $quantity) {
            $item = Cart::get($rowId);

            if ($quantity > $item->attributes->quantity) {
                alert()->error('دقت کنید', 'تعداد محصول انتخابی درست نمی باشد')->persistent('حله');
                return redirect()->back();
            }

            Cart::update($rowId, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $quantity
                ),
            ));
        }
        alert()->success('با تشکر', 'سبد خرید شما ویرایش شد')->persistent('حله');
        return redirect()->back();
    }

    public function remove($rowId)
    {
        Cart::remove($rowId);

        alert()->success('انجام شد', 'محصول مورد نظر از سبد خرید شما حذف شد');
        return redirect()->back();
    }

    public function clear()
    {
        Cart::clear();

        alert()->warning('انجام شد', 'سبد خرید شما خالی شد');
        return redirect()->back();
    }

    public function checkCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        if (!auth()->check()){
            alert()->error('دقت کنید', 'برای استفاده از کد تخفیف نیاز هست ابتدا وارد حساب کاربری خود شوید');
            return redirect()->back();
        }

        $result = checkCoupon($request->code);

        if (array_key_exists('error', $result)){
            alert()->error('دقت کنید', $result['error']);
        }else{
            alert()->success('انجام شد', $result['success']);
        }
        return redirect()->back();
    }

    public function checkout()
    {
        if (Cart::isEmpty()){
            alert()->warning('دقت کنید', 'سبد خرید شما خالی می باشد');
            return redirect()->route('home.index');
        }

        $addresses = UserAddress::where('user_id', auth()->id())->get();
        $provinces = Province::all();
        return view('home.cart.checkout', compact('provinces', 'addresses'));
    }

    public function usersProfileIndex()
    {
        $orders = Order::where('user_id', auth()->id())->get();
        return view('home.users_profile.orders', compact('orders'));
    }
}
