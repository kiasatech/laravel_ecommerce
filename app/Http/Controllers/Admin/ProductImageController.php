<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductImageController extends Controller
{
    public function upload($primaryImage, $images)
    {
        // one image
        $picCustomName = generateFileName($primaryImage->getClientOriginalName());
        $primaryImage->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')), $picCustomName);


        // many images
        $imagesCustomName = [];
        foreach ($images as $image) {
            $imageCustomName = generateFileName($image->getClientOriginalName());
            $image->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')), $imageCustomName);
            array_push($imagesCustomName, $imageCustomName);
        }

        return ['picCustomName' => $picCustomName, 'imagesCustomName' => $imagesCustomName];
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit_images', compact('product'));
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'image_id' => 'required|exists:product_images,id'
        ]);

        ProductImage::destroy($request->image_id);

        alert()->success('با تشکر','تصویر محصول مورد نظر حذف شد!');
        return redirect()->back();
    }

    public function setPrimary(Request $request, Product $product)
    {
        $request->validate([
            'image_id' => 'required|exists:product_images,id'
        ]);

        $productImage = ProductImage::findOrFail($request->image_id);

        $product->update([
            'primary_image' => $productImage->image
        ]);

        alert()->success('با تشکر','ویرایش تصویر اصلی محصول با موفقیت انجام شد!');
        return redirect()->back();
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'primary_image' => 'nullable|mimes:jpg,jpeg,png,svg',
            'images.*' => 'nullable|mimes:jpg,jpeg,png,svg'
        ]);

        if ($request->primary_image == null && $request->images == null){
            return redirect()->back()->withErrors(['msg' => 'تصویر یا تصاویر محصول الزامی است']);
        }

        try {
            DB::beginTransaction();

            // one image
            if ($request->has('primary_image')){
                $picCustomName = generateFileName($request->primary_image->getClientOriginalName());
                $request->primary_image->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')), $picCustomName);

                $product->update([
                    'primary_image' => $picCustomName
                ]);
            }

            // many images
            if ($request->has('images')) {
                foreach ($request->images as $image) {

                    $imageCustomName = generateFileName($image->getClientOriginalName());
                    $image->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')), $imageCustomName);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $imageCustomName
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            alert()->error('مشکل در ایجاد محصول', $ex->getMessage())->persistent('حله');
            return redirect()->back();
        }

        alert()->success('با تشکر','ویرایش تصویر اصلی محصول با موفقیت انجام شد!');
        return redirect()->back();
    }
}
