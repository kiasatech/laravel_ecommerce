@extends('admin.layouts.admin')

@section('title', 'ویرایش دسته بندی محصول')

@section('script')
    <script>
        // Bootstrap Select Script
        $('#categorySelect').selectpicker({
            'title' : 'انتخاب دسته بندی'
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
                <h5 class="font-weight-bold">ویرایش دسته بندی محصول : <ins
                        class="font-weight-normal">{{ $product->name }}</ins></h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.products.category.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

{{--        Category&Attributes Section         --}}
                <div class="form-row mt-5 justify-content-center">
                    <div class="form-group col-sm-6 col-md-4">
                        <label for="category_id">دسته بندی</label>
                        <select id="categorySelect" name="category_id" class="form-control" data-live-search="true">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $product->category->id ? 'selected' : '' }}
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

                </div>

                <button type="submit" class="btn btn-outline-primary mt-5 px-4">ویرایش</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>
    </div>

@endsection
