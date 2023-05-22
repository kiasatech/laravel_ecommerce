@extends('admin.layouts.admin')

@section('title', 'لیست سفارشات')

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 p-lg-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست سفارشات ({{$orders->total()}})</h5>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام کاربر</th>
                            <th>وضعیت</th>
                            <th>مبلغ</th>
                            <th>نوع پرداخت</th>
                            <th>وضعیت پرداخت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $key => $order)
                            <tr>
                                <td>
                                    {{ $orders->firstItem() + $key }}
                                </td>
                                <td>
                                    {{ $order->user->name == null ? 'کاربر' : $order->user->name }}
                                </td>
                                <td>
                                    {{ $order->status }}
                                </td>
                                <td>
                                    {{ number_format($order->total_amount) }}
                                </td>
                                <td>
                                    {{ $order->payment_type }}
                                </td>
                                <td>
                                    {{ $order->payment_status }}
                                </td>
                                <td class="d-flex flex-row">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                       class="btn btn-sm btn-outline-success">نمایش</a>
                                    <a href="{{ route('admin.orders.edit', $order->id) }}"
                                       class="btn btn-sm btn-outline-info mr-3">ویرایش</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $orders->render() }}
            </div>
        </div>
    </div>
@endsection
