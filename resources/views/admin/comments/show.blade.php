@extends('admin.layouts.admin')

@section('title', 'نمایش کامنت')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="mb-3">
                <h5 class="font-weight-bold">نمایش کامنت</h5>
            </div>
            <hr>

                <div class="row mt-5">
                    <div class="form-group col-sm-6 col-lg-3">
                        <label>نام کاربر</label>
                        <input type="text" class="form-control"
                               value="{{$comment->user->name ? $comment->user->name : $comment->user->cellphone}}" disabled>
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label>نام محصول</label>
                        <input type="text" class="form-control" value="{{ $comment->product->name }}" disabled>
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label>وضعیت</label>
                        <input type="text" class="form-control" value="{{ $comment->approved }}" disabled>
                    </div>
                    <div class="form-group col-sm-6 col-lg-3">
                        <label>تاریخ ایجاد</label>
                        <input type="text" class="form-control" value="{{ verta($comment->created_at)->format('H:i | Y-n-j') }}" disabled>
                    </div>
                    <div class="form-group col-12">
                        <label>متن کامنت</label>
                        <textarea class="form-control" rows="4" disabled>{{ $comment->text }}</textarea>
                    </div>
                </div>

                <a href="{{ route('admin.comments.index') }}" class="btn btn-dark mt-5">بازگشت</a>

        @if($comment->getRawOriginal('approved'))
            <a href="{{ route('admin.comment.change-status', $comment->id) }}" class="btn btn-warning mt-5">عدم تایید</a>
        @else
            <a href="{{ route('admin.comment.change-status', $comment->id) }}" class="btn btn-success mt-5">تایید</a>
        @endif
        </div>
    </div>

@endsection
