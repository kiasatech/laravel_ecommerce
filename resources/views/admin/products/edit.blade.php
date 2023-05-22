@extends('admin.layouts.admin')

@section('title', 'ویرایش محصول')

@section('script')
    <script>
        // Bootstrap Select Script
        $('#brandSelect').selectpicker({
            'title' : 'انتخاب برند'
        });

        $('#tagSelect').selectpicker({
            'title' : 'انتخاب تگ'
        });

        let variations = @json($productVariations);
        variations.forEach(variation => {
            $(`#variationDateOnSaleFrom-${variation.id}`).MdPersianDateTimePicker({
                targetTextSelector: `#variationInputDateOnSaleFrom-${variation.id}`,
                englishNumber: true,
                enableTimePicker: true,
                textFormat: 'yyyy-MM-dd HH:mm:ss'
            });

            $(`#variationDateOnSaleTo-${variation.id}`).MdPersianDateTimePicker({
                targetTextSelector: `#variationInputDateOnSaleTo-${variation.id}`,
                englishNumber: true,
                enableTimePicker: true,
                textFormat: 'yyyy-MM-dd HH:mm:ss'
            });
        })


    </script>
@endsection

@section('content')
    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="mb-3">
                <h5 class="font-weight-bold">ویرایش محصول</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row mt-5">
                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="name">نام</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}">
                    </div>
                    <div class="form-group col-sm-6 col-md-3">
                        <label for="brand_id">برند</label>
                        <select id="brandSelect" name="brand_id" class="form-control" data-live-search="true">
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ $brand->id == $product->brand_id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-6 col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1" {{$product->getRawOriginal('is_active') ? 'selected' : ''}}>فعال</option>
                            <option value="0" {{$product->getRawOriginal('is_active') ? '' : 'selected'}}>غیر فعال</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6 col-md-3">
                        <label for="tag_ids">تگ</label>
                        <select id="tagSelect" name="tag_ids[]" class="form-control" multiple data-live-search="true">
                            @php
                                $productTagIds = $product->tags()->pluck('id')->toArray()
                            @endphp
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}"
                                  {{ in_array($tag->id, $productTagIds) ? 'selected' : '' }}>{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row mt-4">
                    <div class="form-group col-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" rows="4" id="description" name="description">{{ $product->description }}</textarea>
                    </div>
                </div>

{{--                Delivery Section--}}
                <div class="col-md-12 mt-2">
                    <hr>
                    <p>هزینه ارسال :</p>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="row">
                        <div class="form-group col-sm-6 col-lg-3">
                            <label for="delivery_amount">هزینه ارسال</label>
                            <input type="text" class="form-control" id="delivery_amount" name="delivery_amount" value="{{ $product->delivery_amount }}">
                        </div>
                        <div class="form-group col-sm-6 col-lg-3">
                            <label for="delivery_amount_per_product">هزینه ارسال به ازای محصول اضافی</label>
                            <input type="text" class="form-control" id="delivery_amount_per_product" name="delivery_amount_per_product" value="{{ $product->delivery_amount_per_product }}">
                        </div>
                    </div>
                </div>

{{--            Product Attributes & Variations            --}}
                <div class="col-md-12 mt-5">
                    <hr>
                    <p>ویژگی ها :</p>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="row">
                        @foreach($productAttributes as $productAttribute)
                            <div class="form-group col-sm-6 col-lg-3">
                                <label>{{ $productAttribute->attribute->name }}</label>
                                <input type="text" class="form-control" name="attribute_values[{{$productAttribute->id}}]" value="{{ $productAttribute->value }}">
                            </div>
                        @endforeach

                        @foreach($productVariations as $variation)
                            <div class="col-md-12">
                                <hr>
                                <div class="d-flex">
                                    <p class="mb-0"> قیمت و موجودی برای متغیر ( {{ $variation->value }} ) : </p>
                                    <p class="mb-0 mr-3">
                                        <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse"
                                                data-target="#collapse-{{ $variation->id }}">
                                            نمایش
                                        </button>
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="collapse mt-2" id="collapse-{{ $variation->id }}">
                                    <div class="card card-body">
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label> قیمت </label>
                                                <input type="text" class="form-control" name="variation_values[{{ $variation->id }}][price]" value="{{ $variation->price }}">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label> تعداد </label>
                                                <input type="text" class="form-control" name="variation_values[{{ $variation->id }}][quantity]" value="{{ $variation->quantity }}">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label> sku </label>
                                                <input type="text" class="form-control" name="variation_values[{{ $variation->id }}][sku]" value="{{ $variation->sku }}">
                                            </div>

                                            {{-- Sale Section --}}
                                            <div class="col-md-12">
                                                <p> حراج : </p>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label> قیمت حراجی </label>
                                                <input type="text"  name="variation_values[{{ $variation->id }}][sale_price]" value="{{ $variation->sale_price }}" class="form-control">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label> تاریخ شروع حراجی </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend order-2">
                                                        <span class="input-group-text" id="variationDateOnSaleFrom-{{ $variation->id }}">
                                                            <i class="fas fa-clock"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" name="variation_values[{{ $variation->id }}][date_on_sale_from]" id="variationInputDateOnSaleFrom-{{ $variation->id }}"
                                                           value="{{ $variation->date_on_sale_from == null ? null : verta($variation->date_on_sale_from) }}"
                                                           class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label> تاریخ پایان حراجی </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend order-2">
                                                        <span class="input-group-text" id="variationDateOnSaleTo-{{ $variation->id }}">
                                                            <i class="fas fa-clock"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" name="variation_values[{{ $variation->id }}][date_on_sale_to]" id="variationInputDateOnSaleTo-{{ $variation->id }}"
                                                           value="{{ $variation->date_on_sale_to == null ? null : verta($variation->date_on_sale_to) }}"
                                                           class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                <button type="submit" class="btn btn-outline-primary mt-5 px-4">ویرایش</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
