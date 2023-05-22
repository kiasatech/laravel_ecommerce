@extends('admin.layouts.admin')

@section('title', 'ایجاد دسته بندی')

@section('script')
    <script>
        // Bootstrap Select Script
        $('#attributeSelect').selectpicker({
            'title' : 'انتخاب ویژگی'
        });

        $('#attributeSelect').on('changed.bs.select', function () {
            let attributesSelected = $(this).val();
            let attributes = @json($attributes);

            let attributesForFilter = [];

            attributes.map((attribute) => {
                $.each(attributesSelected , function (i, element){
                    if( attribute.id == element ){
                        attributesForFilter.push(attribute);
                    }
                });
            });
            $("#attributeIsFilterSelect").find("option").remove();
            $("#variationSelect").find("option").remove();
            attributesForFilter.forEach((element) => {
                let attributeFilterOption = $("<option/>" , {
                    value : element.id,
                    text : element.name
                });

                let variationOption = $("<option/>" , {
                    value : element.id,
                    text : element.name
                });

                $("#attributeIsFilterSelect").append(attributeFilterOption);
                $('#attributeIsFilterSelect').selectpicker('refresh');

                $("#variationSelect").append(variationOption);
                $('#variationSelect').selectpicker('refresh');
            })

        });

        $('#attributeIsFilterSelect').selectpicker({
            'title' : 'انتخاب ویژگی'
        });

        $('#variationSelect').selectpicker({
            'title' : 'انتخاب متغیر'
        });

    </script>
@endsection

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="mb-3">
                <h5 class="font-weight-bold">ایجاد دسته بندی</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="form-row mt-5">
                    <div class="form-group col-sm-6 col-md-3">
                        <label for="name">نام</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group col-sm-6 col-md-3">
                        <label for="slug">نام انگلیسی</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}">
                    </div>
                    <div class="form-group col-sm-6 col-md-3">
                        <label for="parent_id">انتخاب والد</label>
                        <select class="form-control" id="parent_id" name="parent_id">
                            <option value="0" selected>بدون والد</option>
                            @foreach($parentCategories as $parentCategory)
                                <option value="{{ $parentCategory->id }}" selected>{{ $parentCategory->name }}</option>
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
                </div>

                <div class="form-row mt-5">
                    <div class="form-group col-sm-6 col-md-3">
                        <label for="attribute_ids">ویژگی ها</label>
                        <select id="attributeSelect" name="attribute_ids[]" class="form-control" multiple data-live-search="true">
                            @foreach($attributes as $attribute)
                                <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-6 col-md-3">
                        <label for="attribute_is_filter_ids">انتخاب ویژگی های قابل فیلتر</label>
                        <select id="attributeIsFilterSelect" name="attribute_is_filter_ids[]" class="form-control" multiple data-live-search="true">

                        </select>
                    </div>
                    <div class="form-group col-sm-6 col-md-3">
                        <label for="variation_id">انتخاب ویژگی متغیر</label>
                        <select id="variationSelect" name="variation_id" class="form-control" data-live-search="true">

                        </select>
                    </div>
                    <div class="form-group col-sm-6 col-md-3">
                        <label for="icon">آیکون</label>
                        <input type="text" class="form-control" id="icon" name="icon" value="{{ old('icon') }}">
                    </div>
                </div>

                <div class="form-row mt-5">
                    <div class="form-group col-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" rows="4" id="description" name="description">{{ old('description') }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-outline-primary mt-5 px-4">ثبت</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>
    </div>

@endsection
