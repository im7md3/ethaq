@extends('client.order.layout')
@section('order-content')
<div class="boxes-order" id="events">
    <div class="container px-0 px-sm-3">
        <div class=" ">
            <p class="text-666 fw-bold mb-3 caption-title fs-6">فواتير العقد</p>
            <div class="parent-table mb-4">
                <table class="table file-table table-n-border sm table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">رقم</th>
                            <th scope="col">قيمة العقد</th>
                            <th scope="col">ضريبة القيمة المضافة {{ setting('contract_tax') }}%</th>
                            <th scope="col">الاجمالي</th>
                            <th>تسديد</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($invoices->where('for_type','vendor') as $invoice)
                        <tr>
                            <td>{{ $invoice->id }}</td>
                            <td>{{ $invoice->amount }} ر.س</td>
                            <td>{{ $invoice->tax }} ر.س</td>
                            <td>{{ $invoice->total }} ر.س</td>
                            <td>
                                @if($invoice->status!='paid')
                                <x-payment-buttons :invoice="$invoice"></x-payment-buttons>
                                @else
                                <button class="btn table_btn btn-sm">تم السداد</button>
                                @endif
                                <a target="_blank" class="btn table_btn btn-sm"
                                    href="{{ route('client.invoices.show',$invoice) }}"><i
                                        class="fa-solid fa-eye"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">لا يوجد فواتير</td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <p class="text-666 fw-bold mb-3 caption-title fs-6">فواتير المحكم</p>
            <div class="parent-table mb-4">
                <table class="table file-table table-n-border sm table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">رقم</th>
                            <th scope="col">أتعاب المحكم</th>
                            <th scope="col">ضريبة القيمة المضافة</th>
                            <th scope="col">الإجمالي</th>
                            <th>تسديد</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($invoices->where('for_type','judger')->where('from_id',$user->id) as $invoice)
                        <tr>
                            <td>{{ $invoice->id }}</td>
                            <td>{{ $invoice->amount }} ر.س</td>
                            <td>{{ $invoice->tax }} ر.س</td>
                            <td>{{ $invoice->total }} ر.س</td>
                            <td>
                                @if($invoice->status!='paid')
                                <x-payment-buttons :invoice="$invoice"></x-payment-buttons>
                                @else
                                <button class="btn table_btn btn-sm">تم السداد</button>
                                @endif
                                <a target="_blank" class="btn table_btn btn-sm"
                                    href="{{ route('client.invoices.show',$invoice) }}"><i
                                        class="fa-solid fa-eye"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">لا يوجد فواتير</td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@endsection