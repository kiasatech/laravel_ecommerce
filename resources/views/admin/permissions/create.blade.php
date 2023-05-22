@extends('admin.layouts.admin')

@section('title', 'ایجاد مجوز دسترسی')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="mb-3">
                <h5 class="font-weight-bold">ایجاد مجوز دسترسی</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.permissions.store') }}" method="POST">
                @csrf
                <div class="form-row mt-5">
                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="name">نام</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                    </div>

                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="display_name">نام نمایشی</label>
                        <input type="text" class="form-control" id="display_name" name="display_name" value="{{ old('display_name') }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-outline-primary mt-5 px-4">ثبت</button>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>
    </div>

@endsection
