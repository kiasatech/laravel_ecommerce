@extends('admin.layouts.admin')

@section('title', 'لیست ویژگی ها')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست ویژگی ها ({{$attributes->total()}})</h5>
                <a href="{{ route('admin.attributes.create') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fa fa-plus"></i> افزودن ویژگی </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attributes as $key => $attribute)
                            <tr>
                                <td>{{$attributes->firstItem() + $key}}</td>
                                <td>{{$attribute->name}}</td>
                                <td class="d-flex flex-row">
                                    <a href="{{ route('admin.attributes.show', $attribute->id) }}"
                                       class="btn btn-sm btn-outline-success">نمایش</a>
                                    <a href="{{ route('admin.attributes.edit', $attribute->id) }}"
                                       class="btn btn-sm btn-outline-info mr-3">ویرایش</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $attributes->render() }}
            </div>
        </div>
    </div>
@endsection
