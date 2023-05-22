@extends('admin.layouts.admin')

@section('title', 'نمایش برند')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="mb-3">
                <h5 class="font-weight-bold">نمایش برند</h5>
            </div>
            <hr>

                <div class="row mt-5">
                    <div class="form-group col-sm-6 col-lg-4">
                        <label>نام</label>
                        <input type="text" class="form-control" value="{{ $brand->name }}" disabled>
                    </div>
                    <div class="form-group col-sm-6 col-lg-4">
                        <label>وضعیت</label>
                        <input type="text" class="form-control" value="{{ $brand->is_active }}" disabled>
                    </div>
                    <div class="form-group col-sm-6 col-lg-4">
                        <label>تاریخ ایجاد</label>
                        <input type="text" class="form-control" value="{{ verta($brand->created_at)->format('H:i | Y-n-j') }}" disabled>
                    </div>
                </div>

                <a href="{{ route('admin.brands.index') }}" class="btn btn-dark mt-5">بازگشت</a>
        </div>
    </div>

@endsection
