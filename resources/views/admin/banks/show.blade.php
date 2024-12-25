@extends('admin.layouts.admin')
@section('title', 'تفاصيل التحويل البنكي')
@section('content')
<section class=" show-user">
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb bg-light p-3 d-flex justify-content-between">
            <li href="" class="breadcrumb-item" aria-current="page">
                تحويل بنكي من العضو <a target="_blank" href="{{ $bankTransfer->user->type=='client'?route('admin.clients.show',$bankTransfer->user):route('admin.vendors.show',$bankTransfer->user) }}">{{ $bankTransfer->user->name }}</a>
            </li>
        </ol>
    </nav>
    <div class="content_view">
        <h4>تفاصيل التحويل البنكي</h4>
        <div class="">
            المبلغ: {{ $bankTransfer->invoice->total }}
            تاريخ الطلب: {{ $bankTransfer->created_at->diffForHumans() }}
        </div>
        <div class="">
            <h4>معلومات الفاتورة</h4>
            <table class="table table-n-border sm table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">رقم الفاتورة</th>
                        <th scope="col">رقم الطلب</th>
                        <th scope="col">نوع الفاتورة</th>
                        <th scope="col">قيمة الفاتورة</th>
                        <th>عرض</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>{{ $bankTransfer->invoice->id }}</td>
                        <td><a target="_blank"
                                href="{{ $bankTransfer->invoice->order_type=='App\Models\Order'?route('admin.orders.show',$bankTransfer->invoice->order?->hash_code): route('admin.consulting.show', $bankTransfer->invoice->order) }}">{{
                                $bankTransfer->invoice->order?->id }}</a></td>
                        <td>فاتورة {{ $bankTransfer->invoice->order_type=='App\Models\Order'?'طلب':'استشارة' }}
                        </td>
                        <td>{{ $bankTransfer->invoice->total }}</td>
                        <td>
                            <a target="_blank" class="btn btn-sm btn-info"
                                href="{{ route(auth()->user()->type.'.invoices.show',$bankTransfer->invoice) }}">عرض</a>
                        </td>
                    </tr>

                </tbody>
            </table>
            <div class="">
                <form action="{{ route('admin.bankTransfers.update', $bankTransfer) }}" method="post">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="pending">
                    <button class="btn btn-sm btn-warning" type="pending">تعليق التحويل</button>
                </form>
                <form action="{{ route('admin.bankTransfers.update', $bankTransfer) }}" method="post">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="accepted">
                    <button class="btn btn-sm btn-success" type="submit">تأكيد التحويل</button>
                </form>
                <form action="{{ route('admin.bankTransfers.update', $bankTransfer) }}" method="post">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="rejected">
                    <div class="form-check form-switch d-flex">
                        <label for="">سبب الرفض</label>
                        <textarea name="rejected_msg" id="" cols="30" rows="10"></textarea>
                    </div>
                    <button class="btn btn-sm btn-danger" type="submit">رفض التحويل</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection