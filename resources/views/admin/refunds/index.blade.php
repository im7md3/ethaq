@extends('admin.layouts.admin')
@section('title', 'طلبات الاسترجاع')
@section('content')
    <section class="">
        <div class="main-title">
            <div class="small">
                الحسابات المالية
            </div>
            <div class="large">
                طلبات الاسترجاع
            </div>
        </div>
        <div class="section_content content_view">
            <div class="table-responsive">
                <table class="main-table mb-2">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>الطلب</th>
                            <th>المبلغ الكلي</th>
                            <th>مبلغ الادارة</th>
                            <th>المبلغ</th>
                            <th>الحالة</th>
                            <th>تحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($refunds as $refund)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $refund->user->name }}</td>
                                <td>{{ $refund->order?->title }}</td>
                                <td>{{ $refund->amount }}</td>
                                <td>{{ $refund->admin_ratio }}</td>
                                <td>{{ $refund->user_ratio }}</td>
                                <td>{{ __($refund->status) }}</td>
                                <td class="text-center">
                                    <form action="{{ route('admin.refunds.update', $refund) }}" method="post">
                                        @csrf @method('PUT')
                                        <div class="form-check form-switch d-flex">
                                            <select name="status" onchange="this.form.submit()">
                                                <option value="">اختر حالة الطلب</option>
                                                <option value="pending" @selected($refund->status=='pending') >بالانتظار</option>
                                                <option value="completed" @selected($refund->status=='completed')>تم الاسترجاع</option>
                                                <option value="refused" @selected($refund->status=='refused')>رفض عملية الاسترجاع</option>
                                            </select>
                                        </div>

                                    </form>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $refunds->links() }}
            </div>
        </div>
    </section>
@endsection
