@extends('admin.layouts.admin')
@section('title','المبالغ المعلقة')
@section('content')
<section class="">
    <div class="main-title">
        <div class="small">
            الحسابات المالية
        </div>
        <div class="large">
            المبالغ المعلقة
        </div>
    </div>
    <div class="section_content content_view">
        <div class="table-responsive">
            <table class="main-table mb-2">
                <thead>
                    <tr>
                        <th>رقم الطلب</th>
                        <th>تاريخ الطلب</th>
                        <th>معلق من</th>
                        <th>معلق ل</th>
                        <th>قيمة الفاتورة</th>
                        <th>نسبة الادارة</th>
                        <th>الضريبة</th>
                        <th>المبلغ</th>
                        <th>تحويلها للسحب</th>
                        <th>تحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suspended as $suspend)
                    <tr>
                        <td>{{ $suspend->order?->id }}</td>
                        <td>{{ $suspend->order?->created_at->format('Y-m-d') }}</td>
                        <td>{{ $suspend->fromUser?->name }}</td>
                        <td>{{ $suspend->toUser?->name }}</td>
                        <td>{{ $suspend->invoice?->total }}</td>
                        <td>{{ $suspend->invoice?->admin_ratio }}</td>
                        <td>{{ $suspend->invoice?->tax }}</td>
                        <td>{{ $suspend->amount }}</td>
                        <td>{{ __($suspend->status) }}</td>
                        <td class="d-flex gap-1">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{ $suspend->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                            @include('admin.suspended-balances.delete-modal',['suspend'=>$suspend])
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $suspended->links() }}
        </div>
    </div>
</section>
@endsection
