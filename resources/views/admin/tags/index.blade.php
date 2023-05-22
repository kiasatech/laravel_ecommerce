@extends('admin.layouts.admin')

@section('title', 'لیست تگ ها')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست تگ ها ({{$tags->total()}})</h5>
                <a href="{{ route('admin.tags.create') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fa fa-plus"></i> ایجاد تگ </a>
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
                        @foreach($tags as $key => $tag)
                            <tr>
                                <td>{{$tags->firstItem() + $key}}</td>
                                <td>{{$tag->name}}</td>
                                <td>
{{--                                    <a href="{{ route('admin.tags.show', $tag->id) }}"--}}
{{--                                       class="btn btn-sm btn-outline-success">نمایش</a>--}}
                                    <a href="{{ route('admin.tags.edit', $tag->id) }}"
                                       class="btn btn-sm btn-outline-info mr-3">ویرایش</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $tags->render() }}
            </div>
        </div>
    </div>
@endsection
