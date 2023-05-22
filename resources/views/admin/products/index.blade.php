@extends('admin.layouts.admin')

@section('title', 'لیست محصولات')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست محصولات ({{$products->total()}})</h5>
                <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fa fa-plus"></i> ایجاد محصول </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>نام برند</th>
                            <th>نام دسته بندی</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $key => $product)
                            <tr>
                                <td>{{$products->firstItem() + $key}}</td>
                                <td>
                                    <a href="{{ route('admin.products.show', $product->id) }}">
                                        {{ $product->name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.brands.show', $product->brand->id) }}">
                                        {{ $product->brand->name }}
                                    </a>
                                </td>
                                <td> {{ $product->category->name }} </td>
                                <td>
                                    <span class="{{ $product->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">
                                        {{$product->is_active}}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            عملیات
                                        </button>
                                        <div class="dropdown-menu text-right" aria-labelledby="dropdownMenu2">
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="dropdown-item">ویرایش محصول</a>
                                            <a href="{{ route('admin.products.images.edit', $product->id) }}" class="dropdown-item">ویرایش تصاویر</a>
                                            <a href="{{ route('admin.products.category.edit', $product->id) }}" class="dropdown-item">ویرایش دسته بندی و ویژگی</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $products->render() }}
            </div>
        </div>
    </div>
@endsection
