@extends('admin.layouts.admin')

@section('title', 'نمایش سفارش')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="mb-3">
                <h5 class="font-weight-bold">نمایش سفارش</h5>
            </div>
            <hr>

                <div class="row mt-5">
                    <div class="form-group col-sm-6 col-lg-3">
                        <label>نام کاربر</label>
                        <input type="text" class="form-control" value="{{ $order->user->name == null ? 'کاربر' : $order->user->name }}" disabled>
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label>کد کوپن</label>
                        <input type="text" class="form-control" value="{{ $order->coupon_id == null ? 'استفاده نشده' : $order->coupon->name }}" disabled>
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label>وضعیت</label>
                        <input type="text" class="form-control" value="{{ $order->status }}" disabled>
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label>مبلغ</label>
                        <input type="text" class="form-control" value="{{ number_format($order->total_amount) }} تومان" disabled>
                    </div>
                </div>

            <div class="row mt-3">
                <div class="form-group col-sm-6 col-lg-3">
                    <label>هزینه ارسال</label>
                    <input type="text" class="form-control" value="{{ number_format($order->delivery_amount) }} تومان" disabled>
                </div>
                <div class="form-group col-sm-6 col-lg-3">
                    <label>مبلغ کد تخفیف</label>
                    <input type="text" class="form-control" value="{{ number_format($order->coupon_amount) }} تومان" disabled>
                </div>
                <div class="form-group col-sm-6 col-lg-3">
                    <label>مبلغ پرداختی</label>
                    <input type="text" class="form-control" value="{{ number_format($order->paying_amount) }} تومان" disabled>
                </div>
                <div class="form-group col-sm-6 col-lg-3">
                    <label>نوع پرداخت</label>
                    <input type="text" class="form-control" value="{{ $order->payment_type }}" disabled>
                </div>
            </div>

            <div class="row mt-3">
                <div class="form-group col-sm-6 col-lg-3">
                    <label>وضعیت پرداخت</label>
                    <input type="text" class="form-control" value="{{ $order->payment_status }}" disabled>
                </div>
            </div>

            <div class="row mt-3">
                <div class="form-group col-12">
                    <label>آدرس تحویل</label>
                    <textarea class="form-control" rows="3" disabled>{{ $order->address->address }}</textarea>
                </div>
            </div>

            <div class="row mt-3">
                <h5>محصولات</h5>
                <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                        <thead>
                        <tr>
                            <th> تصویر محصول </th>
                            <th> نام محصول </th>
                            <th> فی </th>
                            <th> تعداد </th>
                            <th> قیمت کل </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td class="product-thumbnail">
                                    <a href="{{ route('admin.products.show', $item->product->id) }}">
                                        <img src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH') . $item->product->primary_image) }}" width="70">
                                    </a>
                                </td>
                                <td class="product-name"><a href="{{ route('admin.products.show', $item->product->id) }}"> {{ $item->product->name }} </a></td>
                                <td class="product-price-cart"><span class="amount">
                                                            {{ number_format($item->price) }}
                                                            تومان
                                                        </span></td>
                                <td class="product-quantity">
                                    {{ $item->quantity }}
                                </td>
                                <td class="product-subtotal">
                                    {{ number_format($item->subtotal) }}
                                    تومان
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

                <a href="{{ route('admin.orders.index') }}" class="btn btn-dark mt-5">بازگشت</a>
        </div>
    </div>

@endsection
