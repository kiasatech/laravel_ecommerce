@extends('admin.layouts.admin')

@section('title', 'ویرایش کاربر')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="mb-3">
                <h5 class="font-weight-bold">ویرایش کاربر</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row mt-5">
                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="name">نام کاربر</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" id="name" name="name">
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="email">ایمیل کاربر</label>
                        <input type="text" class="form-control" value="{{ $user->email }}" id="email" name="email">
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="cellphone">شماره موبایل</label>
                        <input type="text" class="form-control" value="{{ $user->cellphone }}" id="cellphone" name="cellphone">
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label for="role">نقش کاربر</label>
                        <select class="form-control" id="role" name="role">
                            <option selected disabled>انتخاب کنید</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}"
                                 {{ in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ $role->display_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row mt-4">
                    <div class="accordion col-md-12" id="accordionPermission">
                        <div class="card">
                            <div class="card-header p-1" id="headingPermission">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-right" type="button" data-toggle="collapse" data-target="#collapsePermission" aria-expanded="true" aria-controls="collapsePermission">
                                        مجوز های دسترسی
                                    </button>
                                </h2>
                            </div>

                            <div id="collapsePermission" class="collapse" aria-labelledby="headingPermission" data-parent="#accordionPermission">
                                <div class="card-body row">
                                    @foreach($permissions as $permission)
                                        <div class="form-group form-check col-md-3">
                                            <input type="checkbox" class="form-check-input" id="permission_{{$permission->id}}"
                                                   name="{{$permission->name}}" value="{{$permission->name}}"
                                                {{ in_array($permission->id, $user->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>
                                            <label class="form-check-label mr-3" for="permission_{{$permission->id}}">{{ $permission->display_name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-outline-primary mt-5 px-4">ویرایش</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>
    </div>

@endsection
