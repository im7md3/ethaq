@extends('vendor.order.layout')
@section('order-content')
<div class="boxes-order" id="events">
    <div class="container">
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
                            <th scope="col"> رسوم ادارية {{ setting('admin_ratio') }}%</th>
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
                            <td>{{ $invoice->admin_ratio }} ر.س</td>
                            <td>
                                @if($invoice->status!='paid')
                                <a class="btn-header btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    سداد
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <li>
                                        <form action="{{ route('clickpay.store',$invoice) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn table_btn btn-sm">ClickPay</button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('tamam',$invoice) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn table_btn btn-sm">تمام</button>
                                        </form>
                                    </li>
                                    @if(setting('tamara_active') and $invoice->total <= 5000) <li>
                                        <form action="{{ route('tamara',$invoice) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn table_btn btn-sm">تمارا</button>
                                        </form>
                                        </li>
                                        @endif
                                </ul>
                                @else
                                <button class="btn table_btn btn-sm">تم السداد</button>
                                @endif
                                <a target="_blank" class="btn table_btn btn-sm"
                                    href="{{ route('vendor.invoices.show',$invoice) }}"><i
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
                            <th scope="col">الاجمالي</th>
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
                                @if($invoice->user_id==$user->id)
                                <form class="d-flex align-items-center gap-1 justify-content-center"
                                    action="{{ route('client.invoices.update',$invoice) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="paid">
                                    <button type="submit" class="btn table_btn btn-sm">سداد</button>
                                    <a href="" class="btn table_btn btn-sm"><i class="fa-solid fa-eye"></i></a>
                                </form>
                                @endif
                                @else
                                <button class="btn table_btn btn-sm">تم السداد</button>
                                @endif
                                <a target="_blank" class="btn table_btn btn-sm"
                                    href="{{ route('vendor.invoices.show',$invoice) }}"><i
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