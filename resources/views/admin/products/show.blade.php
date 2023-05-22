@extends('admin.layouts.admin')

@section('title', 'نمایش محصول')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="mb-3">
                <h5 class="font-weight-bold">نمایش محصول</h5>
            </div>
            <hr>

                <div class="row mt-5">
                    <div class="form-group col-sm-6 col-lg-3">
                        <label>نام</label>
                        <input type="text" class="form-control" value="{{ $product->name }}" disabled>
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label>نام برند</label>
                        <input type="text" class="form-control" value="{{ $product->brand->name }}" disabled>
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label>نام دسته بندی</label>
                        <input type="text" class="form-control" value="{{ $product->category->name }}" disabled>
                    </div>
                    <div class="form-group col-sm-6 col-md-3">
                        <label>تگ ها</label>
                        <div class="form-control div-disabled">
                            @foreach($product->tags as $tag)
                                {{ $tag->name }}{{ $loop->last ? '' : '،' }}
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group col-sm-6 col-lg-3">
                        <label>وضعیت</label>
                        <input type="text" class="form-control" value="{{ $product->is_active }}" disabled>
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label>تاریخ ایجاد</label>
                        <input type="text" class="form-control" value="{{ verta($product->created_at)->format('H:i | Y-n-j') }}" disabled>
                    </div>
                    <div class="form-group col-12">
                        <label>توضیحات</label>
                        <textarea class="form-control" rows="3" disabled>{{ $product->description }}</textarea>
                    </div>
                </div>

{{--            Delivery Section            --}}
            <div class="col-md-12 mt-5">
                <hr>
                <p>هزینه ارسال :</p>
            </div>

            <div class="col-md-12 mt-3">
                <div class="row">
                    <div class="form-group col-sm-6 col-lg-3">
                        <label>هزینه ارسال</label>
                        <input type="text" class="form-control" value="{{ $product->delivery_amount }}" disabled>
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label>هزینه ارسال به ازای محصول اضافی</label>
                        <input type="text" class="form-control" value="{{ $product->delivery_amount_per_product }}" disabled>
                    </div>
                </div>
            </div>

{{--            Product Attributes & Variations            --}}
            <div class="col-md-12 mt-5">
                <hr>
                <p>ویژگی ها :</p>
            </div>

            <div class="col-md-12 mt-3">
                <div class="row">
                    @foreach($productAttributes as $productAttribute)
                        <div class="form-group col-sm-6 col-lg-3">
                            <label>{{ $productAttribute->attribute->name }}</label>
                            <input type="text" class="form-control" value="{{ $productAttribute->value }}" disabled>
                        </div>
                    @endforeach

                    @foreach($productVariations as $variation)
                            <div class="col-md-12">
                                <hr>
                                <div class="d-flex">
                                    <p class="mb-0"> قیمت و موجودی برای متغیر ( {{ $variation->value }} ) : </p>
                                    <p class="mb-0 mr-3">
                                        <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse"
                                                data-target="#collapse-{{ $variation->id }}">
                                            نمایش
                                        </button>
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="collapse mt-2" id="collapse-{{ $variation->id }}">
                                    <div class="card card-body">
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label> قیمت </label>
                                                <input type="text" disabled class="form-control" value="{{ $variation->price }}">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label> تعداد </label>
                                                <input type="text" disabled class="form-control" value="{{ $variation->quantity }}">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label> sku </label>
                                                <input type="text" disabled class="form-control" value="{{ $variation->sku }}">
                                            </div>

                                            {{-- Sale Section --}}
                                            <div class="col-md-12">
                                                <p> حراج : </p>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label> قیمت حراجی </label>
                                                <input type="text" value="{{ $variation->sale_price }}" disabled
                                                       class="form-control">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label> تاریخ شروع حراجی </label>
                                                <input type="text"
                                                       value="{{ $variation->date_on_sale_from == null ? null : verta($variation->date_on_sale_from)->format('H:i | Y-n-j') }}"
                                                       disabled class="form-control">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label> تاریخ پایان حراجی </label>
                                                <input type="text"
                                                       value="{{ $variation->date_on_sale_to == null ? null : verta($variation->date_on_sale_to)->format('H:i | Y-n-j') }}"
                                                       disabled class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach

{{--            Images            --}}
                    <div class="col-md-12 mt-2">
                        <hr>
                        <p>تصاویر محصول :</p>
                    </div>

                        <div class="form-group col-md-3">
                            <div class="card">
                                <img src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image) }}" alt="{{ $product->name }}">
                            </div>
                        </div>

                        <div class="col-12">
                            <hr>
                        </div>

                        @foreach($product->images as $productImage)
                            <div class="form-group col-md-3 mt-1">
                                <div class="card">
                                    <img src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$productImage->image) }}" alt="{{ $product->name }}">
                                </div>
                            </div>
                        @endforeach



                </div>
            </div>

                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5">بازگشت</a>
        </div>
    </div>

@endsection
