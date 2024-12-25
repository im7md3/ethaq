@extends(auth()->user()->type . '.layouts.' . auth()->user()->type)
@section('title', 'الفواتير')
@section('content')
<section class="">
    <div class="container">
        <div class="row app">
            @include($user->type.'.layouts.sidebar')
            <div class="col-lg-9">
                <div class="app-content mt-5">
                    <div class="container">
                        <h5 class="mb-4">الفاتورة</h5>
                        <div class="table-responsive">
                            <table class="table table-n-border sm table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">رقم الفاتورة</th>
                                        <th scope="col">رقم الطلب</th>
                                        <th scope="col">نوع الفاتورة</th>
                                        <th scope="col">قيمة الفاتورة</th>
                                        <th scope="col"> قيمة الضريبة المضافة {{ setting('contract_amount') }}%</th>
                                        <!-- <th scope="col">رسوم ادارية{{ setting('admin_ratio') }}%</th> -->
                                        <!-- <th scope="col">تكلفة المحكم</th> -->
                                        <!-- <th scope="col">ضريبة المحكم</th> -->
                                        <th scope="col">الاجمالي</th>
                                        <th>الحالة</th>
                                        <th>عرض</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->id }}</td>
                                        <td>{{ $invoice->order?->id }}</td>
                                        <td>فاتورة {{ $invoice->order_type=='App\Models\Order'?'طلب':'استشارة' }}</td>
                                        <td>{{ $invoice->amount }}</td>
                                        <td>{{ $invoice->tax }}</td>
                                        <!-- <td>{{ $invoice->admin_ratio }}</td> -->
                                        <td>{{ $invoice->total }}</td>
                                        <td class="text-center">
                                            @if($invoice->status=='cancel')
                                            <button class="btn table_btn btn-sm">غير مسددة</button>

                                            @elseif($invoice->status!='paid')
                                            <x-payment-buttons :invoice="$invoice"></x-payment-buttons>
                                            @else
                                            <button class="btn table_btn btn-sm">مسددة</button>
                                            @endif
                                        </td>
                                        <td>
                                            <a target="_blank" class="btn btn-sm btn-info"
                                                href="{{ route($user->type.'.invoices.show',$invoice) }}">عرض</a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        {{ $invoices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection