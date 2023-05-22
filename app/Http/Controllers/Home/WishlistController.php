<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function add(Product $product)
    {
        if (auth()->check()){
            if ($product->checkUserWishlist(auth()->id())){
                alert()->warning('دقت کنید', 'محصول مورد نظر از قبل اضافه شده است')->persistent('حله');
                return redirect()->back();
            }else{
                Wishlist::create([
                    'user_id' => auth()->id(),
                    'product_id' => $product->id
                ]);

                alert()->success('با تشکر', 'محصول مورد نظر به لیست علاقه مندی ها اضافه شد')->persistent('حله');
                return redirect()->back();
            }
        }else{
            alert()->warning('دقت کنید', 'برای افزودن به لیست علاقه مندی ها، ابتدا وارد حساب کاربری خود شوید')->persistent('حله');
            return redirect()->back();
        }
    }

    public function remove(Product $product)
    {
        if (auth()->check()){
            $wishlist = Wishlist::where('product_id', $product->id)->where('user_id', auth()->id())->firstOrFail();
            if ($wishlist){
                Wishlist::where('product_id', $product->id)->where('user_id', auth()->id())->delete();
            }

            alert()->success('با تشکر', 'محصول مورد نظر از لیست علاقه مندی ها حذف شد')->persistent('حله');
            return redirect()->back();
        }else{
            alert()->warning('دقت کنید', 'برای حذف از لیست علاقه مندی ها، ابتدا وارد حساب کاربری خود شوید')->persistent('حله');
            return redirect()->back();
        }
    }

    public function userProfileIndex()
    {
        $wishlist = Wishlist::where('user_id', auth()->id())->get();
        return view('home.users_profile.wishlist', compact('wishlist'));
    }
}
