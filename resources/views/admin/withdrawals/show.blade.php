@extends('admin.layouts.admin')
@section('title', 'تفاصيل طلب السحب')
@section('content')
<section class=" show-user">
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb bg-light p-3 d-flex justify-content-between">
            <li href="" class="breadcrumb-item" aria-current="page">
                طلب سحب من العضو <a target="_blank" href="{{ $withdrawal->user->type=='client'?route('admin.clients.show',$withdrawal->user):route('admin.vendors.show',$withdrawal->user) }}">{{ $withdrawal->user->name }}</a>
            </li>
        </ol>
    </nav>
    <div class="content_view">
        <h4>تفاصيل الطلب</h4>
        <div class="">
            المبلغ: {{ $withdrawal->amount }}
            تاريخ الطلب: {{ $withdrawal->created_at->diffForHumans() }}
        </div>
        <div class="">
            <h4>الفواتير المطلوب سحبها</h4>
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

                    @foreach ($withdrawal->invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->id }}</td>
                        <td><a target="_blank"
                                href="{{ $invoice->order_type=='App\Models\Order'?route('admin.orders.show',$invoice->order?->hash_code): route('admin.consulting.show', $invoice->order) }}">{{
                                $invoice->order?->id }}</a></td>
                        <td>فاتورة {{ $invoice->order_type=='App\Models\Order'?'طلب':'استشارة' }}
                        </td>
                        <td>{{ $invoice->net }}</td>
                        <td>
                            <a target="_blank" class="btn btn-sm btn-info"
                                href="{{ route(auth()->user()->type.'.invoices.show',$invoice) }}">عرض</a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            <div class="">
                <form action="{{ route('admin.withdrawals.update', $withdrawal) }}" method="post">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="pending">
                    <button class="btn btn-sm btn-warning" type="pending">تعليق طلب السحب</button>
                </form>
                <form action="{{ route('admin.withdrawals.update', $withdrawal) }}" method="post">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="completed">
                    <button class="btn btn-sm btn-success" type="submit">تأكيد طلب السحب</button>
                </form>
                <form action="{{ route('admin.withdrawals.update', $withdrawal) }}" method="post">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="refused">
                    <div class="form-check form-switch d-flex">
                        <label for="">سبب الرفض</label>
                        <textarea name="refused_msg" id="" cols="30" rows="10"></textarea>
                    </div>
                    <button class="btn btn-sm btn-danger" type="submit">رفض طلب السحب</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection