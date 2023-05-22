@extends('admin.layouts.admin')

@section('title', 'لیست نقش ها')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست نقش ها ({{$roles->total()}})</h5>
                <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fa fa-plus"></i> ایجاد نقش </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>نام نمایشی</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $key => $role)
                            <tr>
                                <td>{{$roles->firstItem() + $key}}</td>
                                <td>
                                    {{$role->name}}
                                </td>
                                <td>
                                    {{$role->display_name}}
                                </td>
                                <td class="d-flex flex-row justify-content-center">
                                    <a href="{{ route('admin.roles.show', $role->id) }}"
                                       class="btn btn-sm btn-outline-success">نمایش</a>
                                    <a href="{{ route('admin.roles.edit', $role->id) }}"
                                       class="btn btn-sm btn-outline-info mr-3">ویرایش</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $roles->render() }}
            </div>
        </div>
    </div>
@endsection
