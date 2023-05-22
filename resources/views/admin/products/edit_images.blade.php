@extends('admin.layouts.admin')

@section('title', 'ویرایش تصاویر محصول')

@section('script')
    <script>
        //Show File Name
        $('#primary_image').change(function () {
            //get the file name
            var fileName = $(this).val();
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        });

        $('#images').change(function () {
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
                <h5 class="font-weight-bold">ویرایش تصاویر محصول</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
                <div class="row">
                    {{--            Primary Image            --}}
                    <div class="col-md-12">
                        <p class="mt-4">تصاویر اصلی :</p>
                    </div>

                    <div class="form-group col-md-3">
                        <div class="card">
                            <img src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image) }}" alt="{{ $product->name }}">
                        </div>
                    </div>

                    <div class="col-12">
                        <hr>
                        <p class="mt-5">تصاویر محصول :</p>
                    </div>

                    @foreach($product->images as $image)
                        <div class="form-group col-md-3 mt-1">
                            <div class="card">
                                <img class="card-img-top" src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$image->image) }}"
                                     alt="{{ $product->name }}">
                                <div class="card-body text-center">
                                    <form action="{{ route('admin.products.images.destroy', $product->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="image_id" value="{{ $image->id }}">
                                        <button class="btn btn-outline-danger btn-sm mb-3" type="submit">حذف</button>
                                    </form>
                                    <form action="{{ route('admin.products.images.set_primary', $product->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="image_id" value="{{ $image->id }}">
                                        <button class="btn btn-outline-primary btn-sm mb-3" type="submit">انتخاب به عنوان تصویر اصلی</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

{{--                Product Image Section--}}
                <div class="col-md-12">
                    <hr>
                </div>

            <form action="{{ route('admin.products.images.add', $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-row mt-5">
                    <div class="form-group col-sm-6 col-md-3">
                        <label for="primary_image"> انتخاب تصویر اصلی </label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="primary_image" id="primary_image">
                            <label for="primary_image" class="custom-file-label"> انتخاب فایل </label>
                        </div>
                    </div>
                    <div class="form-group col-sm-6 col-md-3">
                        <label for="images"> انتخاب تصویر </label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" value="{{ old('images[]') }}" multiple name="images[]" id="images">
                            <label for="images" class="custom-file-label"> انتخاب فایل ها </label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-outline-primary mt-5 px-4">ویرایش</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>
    </div>

@endsection
