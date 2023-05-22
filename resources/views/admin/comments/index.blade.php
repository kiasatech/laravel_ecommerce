@extends('admin.layouts.admin')

@section('title', 'لیست کامنت ها')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست کامنت ها ({{$comments->total()}})</h5>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام کاربر</th>
                            <th>نام محصول</th>
                            <th>متن کامنت</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comments as $key => $comment)
                            <tr>
                                <td>{{$comments->firstItem() + $key}}</td>
                                <td>{{$comment->user->name ? $comment->user->name : $comment->user->cellphone}}</td>
                                <td>
                                    <a href="{{ route('admin.products.show', $comment->product->id) }}" class="">
                                        {{$comment->product->name}}
                                    </a>
                                </td>
                                <td>{{$comment->text}}</td>
                                <td>
                                    <span class="{{ $comment->getRawOriginal('approved') ? 'text-success' : 'text-danger' }}">
                                        {{$comment->approved}}
                                    </span>
                                </td>
                                <td class="d-flex flex-row">
                                    <a href="{{ route('admin.comments.show', $comment->id) }}"
                                       class="btn btn-sm btn-outline-success">نمایش</a>
                                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-outline-danger mr-3">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $comments->render() }}
            </div>
        </div>
    </div>
@endsection
