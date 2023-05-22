@extends('admin.layouts.admin')

@section('title', 'لیست دسته بندی ها')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست دسته بندی ها ({{$categories->total()}})</h5>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fa fa-plus"></i> ایجاد دسته بندی </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>نام انگلیسی</th>
                            <th>والد</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $key => $category)
                            <tr>
                                <td>{{$categories->firstItem() + $key}}</td>
                                <td>{{$category->name}}</td>
                                <td>{{$category->slug}}</td>
                                <td>
                                    @if($category->parent_id == 0)
                                        دسته بندی اصلی
                                    @else
                                        {{$category->parent->name}}
                                    @endif
                                </td>
                                <td>
                                    <span class="{{ $category->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">
                                        {{$category->is_active}}
                                    </span>
                                </td>
                                <td class="d-flex flex-row justify-content-center">
                                    <a href="{{ route('admin.categories.show', $category->id) }}"
                                       class="btn btn-sm btn-outline-success">نمایش</a>
                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                       class="btn btn-sm btn-outline-info mr-3">ویرایش</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $categories->render() }}
            </div>
        </div>
    </div>
@endsection
