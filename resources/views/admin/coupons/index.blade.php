@extends('admin.layouts.admin')

@section('title', 'لیست کوپن ها')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست کوپن های تخفیف ({{$coupons->total()}})</h5>
                <a href="{{ route('admin.coupons.create') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fa fa-plus"></i> ایجاد کوپن </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>کد</th>
                            <th>نوع</th>
                            <th>تاریخ انقضا</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($coupons as $key => $coupon)
                            <tr>
                                <td>{{$coupons->firstItem() + $key}}</td>
                                <td>
                                    {{$coupon->name}}
                                </td>
                                <td>
                                    {{$coupon->code}}
                                </td>
                                <td>
                                    {{$coupon->type}}
                                </td>
                                <td>
                                    {{verta($coupon->expired_at)}}
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            عملیات
                                        </button>
                                        <div class="dropdown-menu text-right" aria-labelledby="dropdownMenu2">
                                            <a href="{{ route('admin.coupons.show', $coupon->id) }}" class="dropdown-item">نمایش کوپن</a>
                                            <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="dropdown-item">ویرایش کوپن</a>
                                            <a href="{{ route('admin.coupons.destroy', $coupon->id) }}" class="dropdown-item">حذف کوپن</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $coupons->render() }}
            </div>
        </div>
    </div>
@endsection
