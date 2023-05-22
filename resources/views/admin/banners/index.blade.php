@extends('admin.layouts.admin')

@section('title', 'لیست بنر ها')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست بنر ها ({{$banners->total()}})</h5>
                <a href="{{ route('admin.banners.create') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fa fa-plus"></i> ایجاد بنر </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>تصویر</th>
                            <th>عنوان</th>
                            <th>متن</th>
                            <th>اولویت</th>
                            <th>وضعیت</th>
                            <th>نوع</th>
                            <th>متن دکمه</th>
                            <th>لینک دکمه</th>
                            <th>آیکون دکمه</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banners as $key => $banner)
                            <tr>
                                <td>{{$banners->firstItem() + $key}}</td>
                                <td>
                                    <a href="{{ asset(env('BANNER_IMAGES_UPLOAD_PATH').$banner->image) }}"
                                       target="_blank">{{ str()->limit($banner->image, 20) }}</a>
                                </td>
                                <td>{{$banner->title}}</td>
                                <td>{{ str()->limit($banner->text, 22) }}</td>
                                <td>{{$banner->priority}}</td>
                                <td>
                                    <span class="{{ $banner->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">
                                        {{$banner->is_active}}
                                    </span>
                                </td>
                                <td>{{$banner->type}}</td>
                                <td>{{$banner->button_text}}</td>
                                <td>{{$banner->button_link}}</td>
                                <td>{{$banner->button_icon}}</td>
                                <td class="d-flex flex-row">
                                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-outline-danger">حذف</button>
                                    </form>
                                    <a href="{{ route('admin.banners.edit', $banner->id) }}"
                                       class="btn btn-sm btn-outline-info mr-3">ویرایش</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $banners->render() }}
            </div>
        </div>
    </div>
@endsection
