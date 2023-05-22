@extends('admin.layouts.admin')

@section('title', 'ویرایش برند')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="mb-3">
                <h5 class="font-weight-bold">ویرایش برند</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row mt-5">
                    <div class="form-group col-sm-6 col-lg-4">
                        <label for="name">نام</label>
                        <input type="text" class="form-control" value="{{ $brand->name }}" id="name" name="name">
                    </div>
                    <div class="form-group col-sm-6 col-lg-4">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1" {{$brand->getRawOriginal('is_active') ? 'selected' : ''}}>فعال</option>
                            <option value="0" {{$brand->getRawOriginal('is_active') ? '' : 'selected'}}>غیر فعال</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-outline-primary mt-5 px-4">ویرایش</button>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>
    </div>

@endsection
