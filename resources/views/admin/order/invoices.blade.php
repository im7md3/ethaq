@extends('admin.order.layout')
@section('order-content')
<div class="boxes-order" id="events">
    <div class="container">
        <div class=" ">
            <p class="text-666 fw-bold mb-3 fs-6">فواتير الطلب</p>
            <div class="parent-table mb-4">
                <table class="table table-n-border sm table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">رقم</th>
                            <th scope="col">قيمة العقد</th>
                            <th scope="col">ضريبة العقد {{ setting('contract_amount') }}%</th>
                            <th scope="col">تكلفة المحكم</th>
                            <th scope="col">ضريبة المحكم</th>
                            <th scope="col">نسبة الادارة {{ setting('admin_ratio') }}%</th>
                            <th scope="col">الاجمالي</th>
                            <th>تسديد</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->id }}</td>
                            <td>{{ $invoice->contract_amount }}</td>
                            <td>{{ $invoice->contract_tax }}</td>
                            <td>{{ $invoice->judger_cost }}</td>
                            <td>{{ $invoice->judger_cost_tax }}</td>
                            <td>{{ $invoice->admin_ratio }}</td>
                            <td>{{ $invoice->total }}</td>
                            <td>
                                @if($invoice->status!='paid')
                                <form class="d-flex align-items-center gap-1 justify-content-center"
                                    action="{{ route('client.invoices.update',$invoice) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="paid">
                                    <button type="submit" class="btn table_btn btn-sm">سداد</button>
                                    <a href="" class="btn table_btn btn-sm"><i class="fa-solid fa-eye"></i></a>
                                </form>
                                @else
                                <button class="btn table_btn btn-sm">تم السداد</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            </div>

        </div>
    </div>

    @endsection
