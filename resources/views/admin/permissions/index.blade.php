@extends('admin.layouts.admin')

@section('title', 'لیست مجوز ها')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست مجوز ها ({{$permissions->total()}})</h5>
                <a href="{{ route('admin.permissions.create') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fa fa-plus"></i> ایجاد مجوز </a>
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
                        @foreach($permissions as $key => $permission)
                            <tr>
                                <td>{{$permissions->firstItem() + $key}}</td>
                                <td>
                                    {{$permission->name}}
                                </td>
                                <td>
                                    {{$permission->display_name}}
                                </td>
                                <td class="d-flex flex-row justify-content-center">
                                    <a href="{{ route('admin.permissions.edit', $permission->id) }}"
                                       class="btn btn-sm btn-outline-info mr-3">ویرایش</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $permissions->render() }}
            </div>
        </div>
    </div>
@endsection
