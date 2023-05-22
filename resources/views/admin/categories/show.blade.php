@extends('admin.layouts.admin')

@section('title', 'نمایش دسته بندی')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="mb-3">
                <h5 class="font-weight-bold">نمایش دسته بندی</h5>
            </div>
            <hr>

            <div class="row mt-5">
                <div class="form-group col-sm-6 col-md-3">
                    <label>دسته بندی</label>
                    <input type="text" class="form-control" value="{{ $category->name }}" disabled>
                </div>
                <div class="form-group col-sm-6 col-md-3">
                    <label>نام انگلیسی</label>
                    <input type="text" class="form-control" value="{{ $category->slug }}" disabled>
                </div>
                <div class="form-group col-sm-6 col-md-3">
                    <label>والد</label>
                    <input type="text" class="form-control"
                           value="{{$category->parent_id == 0 ? 'دسته بندی اصلی' : $category->parent->name}}" disabled>
                </div>
                <div class="form-group col-sm-6 col-md-3">
                    <label>وضعیت</label>
                    <input type="text" value="{{$category->is_active}}" disabled
                           class="form-control {{ $category->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">
                </div>
            </div>

            <div class="row mt-3">
                <div class="form-group col-sm-6 col-md-3">
                    <label>آیکون</label>
                    <input type="text" class="form-control" value="{{ $category->icon }}" disabled>
                </div>
                <div class="form-group col-sm-6 col-md-3">
                    <label>تاریخ ایجاد</label>
                    <input type="text" class="form-control" value="{{ verta($category->created_at)->format('H:i | Y-n-j') }}" disabled>
                </div>
            </div>

            <div class="form-row mt-3">
                <div class="form-group col-12">
                    <label for="description">توضیحات</label>
                    <textarea class="form-control" rows="3" id="description"
                              name="description" disabled>{{ old('description') }}</textarea>
                </div>
            </div>
            <hr>

            <div class="row mt-4">
                <div class="form-group col-sm-6 col-md-3">
                    <label>ویژگی ها</label>
                    <div class="form-control div-disabled">
                        @foreach($category->attributes as $attribute)
                            {{ $attribute->name }}{{ $loop->last ? '' : '،' }}
                        @endforeach
                    </div>
                </div>
                <div class="form-group col-sm-6 col-md-3">
                    <label>ویژگی های قابل فیلتر</label>
                    <div class="form-control div-disabled">
                        @foreach($category->attributes()->wherePivot('is_filter', 1)->get() as $attribute)
                            {{ $attribute->name }}{{ $loop->last ? '' : '،' }}
                        @endforeach
                    </div>
                </div>
                <div class="form-group col-sm-6 col-md-3">
                    <label>ویژگی متغیر</label>
                    <div class="form-control div-disabled">
                        @foreach($category->attributes()->wherePivot('is_variation', 1)->get() as $attribute)
                            {{ $attribute->name }}{{ $loop->last ? '' : '،' }}
                        @endforeach
                    </div>
                </div>
            </div>

                <a href="{{ route('admin.categories.index') }}" class="btn btn-dark mt-5">بازگشت</a>
        </div>
    </div>

@endsection
