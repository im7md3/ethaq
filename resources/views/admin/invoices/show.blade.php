@extends('admin.layouts.admin')
@section('title', 'عرض فاتورة')
@section('content')
<section class="">
    <div class="container">
        <div class="app-content mt-5">
            <div class="container">
                <div class="invoice-content bg-white rounded-2 p-3 shadow-sm" id="prt-content">
                    <div class="status-invoice">@if($invoice->status!='paid')
                        غير مسددة
                        @else
                        مسددة
                        @endif</div>
                    <div class="row gap-3 invoice-header">
                        <div class="col-lg-5">
                            <div class="image-holder text-center text-lg-start">
                                <img src="{{ asset('front-assets/img/global/ethaq-logo.png') }}" alt="invoice-logo"
                                    width="250" />
                            </div>
                        </div>
                        <div class="col-lg-2 d-flex align-items-center justify-content-center">
                            @if ($invoice->order_type == 'App\Models\Order')
                            @if ($invoice->for_type == 'vendor')
                            <h6> رقم العقد: {{ $invoice->order_id }}</h6>
                            @else
                            <h6>فاتورة التحكيم للعقد رقم: {{ $invoice->order_id }}</h6>
                            @endif
                            @else
                            <h6>رقم الاستشارة: {{ $invoice->order_id }}</h6>
                            @endif
                        </div>
                    </div>
                    <div class="row gap-3 invoice-bottom-header">
                        <div class="col-12 col-md-12 d-flex align-items-center">
                            <div
                                class="invoice-th-info flex-wrap d-flex align-items-center justify-content-evenly gap-2 grey-background p-3 w-100">
                                <span class="d-block text-fs-13">رقم الفاتورة: {{ $invoice->id }}</span>
                                <span class="d-block text-fs-13">تاريخ الفاتورة:
                                    {{ $invoice->created_at->format('Y-m-d') }}</span>
                                    @if(request('type')=='vendor')
                                <span class="d-block text-fs-13">الرقم الضريبي:
                                    {{ $invoice->toUser->tax_number }}</span>
                                    @endif
                            </div>
                        </div>
                        <div class="col-12 col-md-12 d-flex align-items-center">
                            <div class="invoice-th-info w-100">
                                <h6 class="text-fs-15 mb-2 fw-500">صادرة من: إيثاق / منصة قانونية</h6>
                                <span class="d-block text-fs-12">الرياض - حي الصحافة</span>
                                <span class="d-block">الرقم الضريبي: {{ setting('tax_number') }}</span>
                                <span class="d-block">المرسلة إلى: {{ $invoice->fromUser->name }}
                                    - {{ __($invoice->fromUser->type) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="table-responsive">
                                <table class="table invoice-table table-n-border table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="20%">التفاصيل</th>
                                            <th width="80%">الاجمالي</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @if ($invoice->order_type == 'App\Models\Order')
                                            @if ($invoice->for_type == 'vendor' )
                                            <td width="20%" class="bg-white">قيمة العقد</td>
                                            @else
                                            <td width="20%" class="bg-white">قيمة أتعاب التحكيم</td>
                                            @endif
                                            @else
                                            <td width="20%" class="bg-white">قيمة الاستشارة</td>
                                            @endif
                                            <td width="80%" class="text-center bg-white">{{ $invoice->amount }}</td>
                                        </tr>
                                        <tr>
                                            <td width="20%">قيمة الضريبة المضافة %</td>
                                            <td width="80%" class="text-center"> {{ $invoice->tax }}</td>
                                        </tr>
                                        <tr>
                                            <td width="20%">حالة الفاتورة </td>
                                            <td width="80%" class="text-center">{{ __($invoice->status) }}</td>
                                        </tr>
                                        @if ($invoice->status == 'paid')
                                        <tr>
                                            <td width="20%">وسيلة الدفع </td>
                                            <td width="80%" class="text-center">شبكة</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td width="20%">الاجمالي</td>
                                            <td width="80%" class="text-center">{{ $invoice->total }}</td>
                                        </tr>
                                        @if ($invoice->toUser->type == request('type'))
                                        <tr>
                                            <td width="20%">نسبة الإدارة</td>
                                            <td width="80%" class="text-center">{{ $invoice->admin_ratio }}</td>
                                        </tr>
                                        <tr>
                                            <td width="20%">الصافي</td>
                                            <td width="80%" class="text-center">
                                                {{ $invoice->net }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if ($invoice->order_type == 'App\Models\Consulting' and request('type') == 'client')
                        <div class="">
                            <p>شروط الفواتير</p>
                            {!! setting('invoices_terms') !!}
                        </div>
                        @endif
                        <div class="col-12 col-md-12 d-flex align-items-center justify-content-end">
                            <div class="qr-holder">
                                {!! $qrCode !!}
                            </div>
                        </div>
                    </div>
                    <div class="btn-holder">
                        <button class="btn sec-btn btn-sm px-4 not-print" id="btn-prt-content">
                            <i class="fa-solid fa-print"></i>
                            طباعة
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
