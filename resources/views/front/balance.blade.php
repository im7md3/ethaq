@extends($user->type.'.layouts.'.$user->type)
@section('title','الرصيد')
@section('content')
<section class="height-section" id="balanc">
    <div class="container">
        <div class="row app">
            @include($user->type.'.layouts.sidebar')
            <div class="col-lg-9">
                <div class="app-content">
                    <div class="container">
                        <div class="group-btn  pt-4 pb-4 ">
                            @if(!$user->bank_account)
                            <a href="{{ route($user->type.'.settings') }}" class="alert alert-danger d-block">يرجى تسجيل
                                رقم الحساب البنكي من خلال الملف الشخصي من هنا</a>
                            @endif
                            
                        </div>
                        <div class="d-flex gap-4">
                            <div class="">
                                <p class="">
                                    الفواتير المدفوعة:
                                    <span class="main-color d-inline fw-bold fs-5"> {{ $paidInvoices->sum('net') }}ر.س
                                    </span>
                                </p>
                            </div>
                            <div class="">
                                <p class="">
                                    الفواتير المسحوبة:
                                    <span class="main-color d-inline fw-bold fs-5"> {{ $withdrawnInvoices->sum('net')
                                        }}ر.س
                                    </span>
                                </p>
                            </div>

                        </div>
                        @if($user->PendingWithdrawals->count()>0)
                        <div class="">
                            <h4>طلبات السحب التي في الانتظار</h4>
                            @foreach ($user->PendingWithdrawals->get() as $item)
                            <div class="card">
                                <div class="card-body ">
                                    <p>تاريخ السحب: {{ $item->created_at }}</p>
                                    <p>المبلغ: {{ $item->amount }}</p>
                                    <p>الحالة: {{ __($item->status) }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        <div class="">
                            <h3>الفواتير المسددة</h3>
                            <form method="POST" action="{{ route('withdrawals') }}" class="mrg--an" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <table class="table table-n-border sm table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">رقم الفاتورة</th>
                                            <th scope="col">رقم الطلب</th>
                                            <th scope="col">نوع الفاتورة</th>
                                            <th scope="col">قيمة الفاتورة</th>
                                            <th>سحب</th>
                                            <th>عرض</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($invoices as $invoice)
                                        <tr>
                                            <td>{{ $invoice->id }}</td>
                                            <td>{{ $invoice->order?->id }}</td>
                                            <td>فاتورة {{ $invoice->order_type=='App\Models\Order'?'طلب':'استشارة' }}
                                            </td>
                                            <td>{{ $invoice->net }}</td>
                                            <td>
                                                @if($user->id==$invoice->to_id)
                                                @if(!$invoice->withdrawn)
                                                <input type="checkbox" name="invoices[]" value="{{ $invoice->id }}"
                                                    id="">
                                                @else
                                                <input disabled type="checkbox" checked>
                                                @endif
                                                @else
                                                -
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
                                <button class="btn btn-primary btn-sm" type="submit">طلب سحب</button>
                            </form>
                            {{ $invoices->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('js')

@endpush
@endsection