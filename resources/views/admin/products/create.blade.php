@extends('admin.layouts.admin')

@section('title', 'ایجاد محصول')

@section('script')
    <script>
        // Bootstrap Select Script
        $('#brandSelect').selectpicker({
            'title' : 'انتخاب برند'
        });

        $('#tagSelect').selectpicker({
            'title' : 'انتخاب تگ'
        });

        $('#categorySelect').selectpicker({
            'title' : 'انتخاب دسته بندی'
        });

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

        $('#attributeContainer').hide();

        function categorySelectItem(){
            let categoryId = $('#categorySelect').val();

            $.get(`{{ url('/admin-panel/management/category-attributes/${categoryId}') }}`, function (response, status) {
                if(status == 'success') {

                    $('#attributeContainer').fadeIn();

                    // Empty Attribute Container
                    $('#attributes').find('div').remove();

                    // Create Attributes Input
                    response.attributes.forEach(attribute => {
                        let attributeFormGroup = $('<div/>', {
                            class : 'form-group col-sm-6 col-lg-3'
                        });
                        let attributeLabel = $('<label/>', {
                            for : attribute.name,
                            text : attribute.name
                        });
                        let attributeInput = $('<input/>', {
                            type : 'text',
                            class : 'form-control',
                            id : attribute.name,
                            name : `attribute_ids[${attribute.id}]`
                        });

                        // Append Attributes
                        attributeFormGroup.append(attributeLabel, attributeInput);
                        $('#attributes').append(attributeFormGroup);
                    });

                    $('#variationName').text(response.variation.name);
                }else{
                    alert('مشکل در دریافت لیست ویژگی ها');
                }
            }).fail(function () {
                alert('مشکل در دریافت لیست ویژگی ها');
            });
        }

        $(window).on('load', function () {
            if($('#categorySelect').val()) {
                categorySelectItem()
            }
        });

        $('#categorySelect').on('changed.bs.select', function () {
            categorySelectItem()
        });

        $("#czContainer").czMore();

    </script>
@endsection

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="mb-3">
                <h5 class="font-weight-bold">ایجاد محصول</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-row mt-5">
                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="name">نام</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group col-sm-6 col-md-3">
                        <label for="brand_id">برند</label>
                        <select id="brandSelect" name="brand_id" class="form-control" data-live-search="true">
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-6 col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1" selected>فعال</option>
                            <option value="0">غیر فعال</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6 col-md-3">
                        <label for="tag_ids">تگ</label>
                        <select id="tagSelect" name="tag_ids[]" class="form-control" multiple data-live-search="true">
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row mt-4">
                    <div class="form-group col-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" rows="4" id="description" name="description">{{ old('description') }}</textarea>
                    </div>
                </div>

{{--                Product Image Section--}}
                <div class="col-md-12">
                    <hr>
                    <p>تصاویر محصول : </p>
                </div>

                <div class="form-row mt-4">
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

{{--                Category&Attributes Section--}}
                <div class="col-md-12">
                    <hr>
                    <p>دسته بندی و ویژگی ها : </p>
                </div>

                <div class="form-row mt-2 justify-content-center">
                    <div class="form-group col-sm-6 col-md-4">
                        <label for="category_id">دسته بندی</label>
                        <select id="categorySelect" name="category_id" class="form-control" data-live-search="true">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}
                                >{{ $category->name }} - {{ $category->parent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="attributeContainer" class="col-12 mt-3">
                    <div id="attributes" class="row">
                        {{-- Created Input With JS --}}
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <p>افزودن قیمت و موجودی برای متغیر <span class="font-weight-bold" id="variationName"></span> :</p>
                    </div>

                    <div id="czContainer">
                        <div id="first">
                            <div class="recordset">
                                <div class="row mt-2">
                                    <div class="form-group col-sm-6 col-lg-3">
                                        <label>نام</label>
                                        <input type="text" class="form-control" name="variation_values[value][]">
                                    </div>
                                    <div class="form-group col-sm-6 col-lg-3">
                                        <label>قیمت</label>
                                        <input type="text" class="form-control" name="variation_values[price][]">
                                    </div>
                                    <div class="form-group col-sm-6 col-lg-3">
                                        <label>تعداد</label>
                                        <input type="text" class="form-control" name="variation_values[quantity][]">
                                    </div>
                                    <div class="form-group col-sm-6 col-lg-3">
                                        <label>شناسه انبار</label>
                                        <input type="text" class="form-control" name="variation_values[sku][]">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

{{--                Delivery Section--}}
                    <div class="col-md-12 mt-5">
                        <hr>
                        <p>هزینه ارسال :</p>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="row">
                            <div class="form-group col-sm-6 col-lg-3">
                                <label for="delivery_amount">هزینه ارسال</label>
                                <input type="text" class="form-control" id="delivery_amount" name="delivery_amount" value="{{ old('delivery_amount') }}">
                            </div>
                            <div class="form-group col-sm-6 col-lg-3">
                                <label for="delivery_amount_per_product">هزینه ارسال به ازای محصول اضافی</label>
                                <input type="text" class="form-control" id="delivery_amount_per_product" name="delivery_amount_per_product" value="{{ old('delivery_amount_per_product') }}">
                            </div>
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-outline-primary mt-5 px-4">ثبت</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>
    </div>

@endsection
