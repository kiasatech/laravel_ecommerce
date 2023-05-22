@extends('admin.layouts.admin')

@section('title', 'ویرایش بنر')

@section('script')
    <script>
        //Show File Name
        $('#banner_image').change(function () {
            //get the file name
            var fileName = $(this).val();
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        });
    </script>
@endsection

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="mb-3">
                <h5 class="font-weight-bold">ویرایش بنر</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-row justify-content-center mt-5">
                    <div class="col-12 col-sm-9 col-md-8 col-lg-5 col-xl-3">
                        <div class="card">
                            <img class="card-img-top" src="{{ asset(env('BANNER_IMAGES_UPLOAD_PATH').$banner->image) }}" alt="{{ $banner->title }}">
                        </div>
                    </div>
                </div>

                <div class="form-row mt-5">
                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="primary_image"> انتخاب تصویر </label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="image" id="banner_image">
                            <label for="banner_image" class="custom-file-label"> انتخاب فایل </label>
                        </div>
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="title">عنوان</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $banner->title }}">
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="text">متن</label>
                        <input type="text" class="form-control" id="text" name="text" value="{{ $banner->text }}">
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="priority">اولویت</label>
                        <input type="number" class="form-control" id="priority" name="priority" value="{{ $banner->priority }}">
                    </div>

                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1" {{$banner->getRawOriginal('is_active') ? 'selected' : ''}}>فعال</option>
                            <option value="0" {{$banner->getRawOriginal('is_active') ? '' : 'selected'}}>غیر فعال</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="type">نوع بنر</label>
                        <input type="text" class="form-control" id="type" name="type" value="{{ $banner->type }}">
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="button_text">متن دکمه</label>
                        <input type="text" class="form-control" id="button_text" name="button_text" value="{{ $banner->button_text }}">
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="button_link">لینک دکمه</label>
                        <input type="text" class="form-control" id="button_link" name="button_link" value="{{ $banner->button_link }}">
                    </div>

                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="button_icon">آیکون دکمه</label>
                        <input type="text" class="form-control" id="button_icon" name="button_icon" value="{{ $banner->button_icon }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-outline-primary mt-5 px-4">ویرایش</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>
    </div>

@endsection
