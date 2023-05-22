@extends('admin.layouts.admin')

@section('title', 'ایجاد کوپن تخفیف')

@section('script')
    <script>
        $('#expireDate').MdPersianDateTimePicker({
            targetTextSelector: '#expireInput',
            englishNumber: true,
            enableTimePicker: true,
            textFormat: 'yyyy-MM-dd HH:mm:ss'
        });
    </script>
@endsection

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="mb-3">
                <h5 class="font-weight-bold">ایجاد کوپن تخفیف</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.coupons.store') }}" method="POST">
                @csrf
                <div class="form-row mt-5">
                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="name">نام</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="name">کد</label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}">
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="type">نوع</label>
                        <select class="form-control" id="type" name="type">
                            <option value="amount">مبلغی</option>
                            <option value="percentage">درصدی</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="amount">مبلغ</label>
                        <input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount') }}">
                    </div>
                </div>

                <div class="form-row mt-5">
                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="percentage">درصد</label>
                        <input type="text" class="form-control" id="percentage" name="percentage" value="{{ old('percentage') }}">
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="max_percentage_amount">حداکثر مبلغ نوع درصدی</label>
                        <input type="text" class="form-control" id="max_percentage_amount" name="max_percentage_amount" value="{{ old('max_percentage_amount') }}">
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label> تاریخ انقضا </label>
                        <div class="input-group">
                            <div class="input-group-prepend order-2">
                                <span class="input-group-text" id="expireDate">
                                    <i class="fas fa-clock"></i>
                                </span>
                            </div>
                            <input type="text" name="expired_at" id="expireInput" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-row mt-4">
                    <div class="form-group col-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" rows="4" id="description" name="description">{{ old('description') }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-outline-primary mt-5 px-4">ثبت</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>
    </div>

@endsection
