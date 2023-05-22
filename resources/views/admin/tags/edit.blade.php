@extends('admin.layouts.admin')

@section('title', 'ویرایش تگ')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="mb-3">
                <h5 class="font-weight-bold">ویرایش تگ</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row mt-5">
                    <div class="form-group col-sm-6 col-lg-4">
                        <label for="name">نام</label>
                        <input type="text" class="form-control" value="{{ $tag->name }}" id="name" name="name">
                    </div>
                </div>

                <button type="submit" class="btn btn-outline-primary mt-5 px-4">ویرایش</button>
                <a href="{{ route('admin.tags.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>
    </div>

@endsection
