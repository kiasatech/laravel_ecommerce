<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|min:5|max:7000',
            'rate' => 'required|digits_between:0,5'
        ]);

        if ($validator->fails()) {
            return redirect()->to(url()->previous() . '#comments')->withErrors($validator);
        }

        if (auth()->check()) {

            try {
                DB::beginTransaction();

                Comment::create([
                    'user_id' => auth()->id(),
                    'product_id' => $product->id,
                    'text' => $request->text,
                ]);

                if ($product->rates()->where('user_id', auth()->id())->exists()) {
                    $productRate = $product->rates()->where('user_id', auth()->id())->first();
                    $productRate->update([
                        'rate' => $request->rate
                    ]);
                    alert()->success('با تشکر', 'نظر ارزشمند شما با موفقیت برای این محصول بروزرسانی شد');
                } else {
                    ProductRate::create([
                        'user_id' => auth()->id(),
                        'product_id' => $product->id,
                        'rate' => $request->rate,
                    ]);
                    alert()->success('با تشکر', 'نظر ارزشمند شما با موفقیت برای این محصول ثبت شد');
                }

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollBack();
                alert()->error('مشکل در ویرایش محصول', $ex->getMessage())->persistent('حله');
                return redirect()->back();
            }
            return redirect()->back();
        } else {
            alert()->warning('دقت کنید', 'برای ثبت نظر نیاز است در ابتدا وارد حساب کاربری خود شوید')->persistent('حله');
            return redirect()->back();
        }
    }

    public function userProfileIndex()
    {
        $comments = Comment::where('user_id', auth()->id())->where('approved', 1)->get();
        return view('home.users_profile.comments', compact('comments'));
    }
}
