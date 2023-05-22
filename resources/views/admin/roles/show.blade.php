@extends('admin.layouts.admin')

@section('title', 'نمایش نقش')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="mb-3">
                <h5 class="font-weight-bold">نمایش نقش</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="form-row mt-5">
                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="name">نام</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" disabled>
                    </div>

                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="display_name">نام نمایشی</label>
                        <input type="text" class="form-control" id="display_name" name="display_name" value="{{ $role->display_name }}" disabled>
                    </div>
                </div>

                <div class="form-row mt-4">
                    <div class="accordion col-md-12" id="accordionPermission">
                        <div class="card">
                            <div class="card-header p-1" id="headingPermission">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-right" type="button" data-toggle="collapse" data-target="#collapsePermission" aria-expanded="true" aria-controls="collapsePermission">
                                        {{ $role->permissions->all() ? 'مجوز های دسترسی' : 'هیچ مجوز دسترسی برای این کاربر وجود ندارد!' }}
                                    </button>
                                </h2>
                            </div>
                            @if($role->permissions->all())
                                <div id="collapsePermission" class="collapse" aria-labelledby="headingPermission" data-parent="#accordionPermission">
                                    <div class="card-body row">
                                        @foreach($role->permissions as $permission)
                                            <div class="form-group form-check col-md-3">
                                                <input type="checkbox" class="form-check-input" id="permission_{{$permission->id}}"
                                                       name="{{$permission->name}}" value="{{$permission->name}}" disabled checked>
                                                <label class="form-check-label mr-3" for="permission_{{$permission->id}}">{{ $permission->display_name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <a href="{{ route('admin.roles.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>
    </div>

@endsection
