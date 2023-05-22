@extends('admin.layouts.admin')

@section('title', 'لیست تراکنشن ها')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست تراکنشن ها ({{$transactions->total()}})</h5>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام کاربر</th>
                            <th>شماره سفارش</th>
                            <th>مبلغ</th>
                            <th>شماره پیگری</th>
                            <th>نام درگاه پرداخت</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $key => $transaction)
                            <tr>
                                <td>
                                    {{ $transactions->firstItem() + $key }}
                                </td>
                                <td>
                                    {{ $transaction->user->name == null ? 'کاربر' : $transaction->user->name }}
                                </td>
                                <td>
                                    {{ $transaction->order_id }}
                                </td>
                                <td>
                                    {{ number_format($transaction->amount) }}
                                </td>
                                <td>
                                    {{ $transaction->ref_id ?: '----' }}
                                </td>
                                <td>
                                    {{ $transaction->gateway_name }}
                                </td>
                                <td>
                                    {{ $transaction->status }}
                                </td>
                                <td class="d-flex flex-row justify-content-center">
                                    <a href="{{ route('admin.transactions.show', $transaction->id) }}"
                                       class="btn btn-sm btn-outline-success">نمایش</a>
{{--                                    <a href="{{ route('admin.transactions.edit', $transaction->id) }}"--}}
{{--                                       class="btn btn-sm btn-outline-info mr-3">ویرایش</a>--}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $transactions->render() }}
            </div>
        </div>
    </div>
@endsection
