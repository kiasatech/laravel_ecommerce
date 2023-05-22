@extends('admin.layouts.admin')

@section('title', 'لیست برند ها')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست برند ها ({{$brands->total()}})</h5>
                <a href="{{ route('admin.brands.create') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fa fa-plus"></i> ایجاد برند </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($brands as $key => $brand)
                            <tr>
                                <td>{{$brands->firstItem() + $key}}</td>
                                <td>{{$brand->name}}</td>
                                <td>
                                    <span class="{{ $brand->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">
                                        {{$brand->is_active}}
                                    </span>
                                </td>
                                <td class="d-flex flex-row">
                                    <a href="{{ route('admin.brands.show', $brand->id) }}"
                                       class="btn btn-sm btn-outline-success">نمایش</a>
                                    <a href="{{ route('admin.brands.edit', $brand->id) }}"
                                       class="btn btn-sm btn-outline-info mr-3">ویرایش</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $brands->render() }}
            </div>
        </div>
    </div>
@endsection
