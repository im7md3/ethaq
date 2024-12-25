@extends('admin.layouts.admin')
@section('title', 'الفواتير')
@section('content')
    <section class="">
        <div class="main-title">
            <div class="small">
                الرئيسية
            </div>
            <div class="large">
                الفواتير
            </div>
        </div>
        <div class="section_content content_view">
            <form action="" method="get">
                <div class="row mb-3">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <input class="form-control" type="text" name="invoice_no"
                                value="{{ request('invoice_no') }}">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary btn-sm">بحث</button>
                    </div>
                </div>
            </form>
            <div class="buttons_holder d-flex align-items-center justify-content-start flex-wrap gap-1 mb-2">

                <a href="{{ route('admin.invoices.index') }}" class="btn btn-primary">الكل:
                    5</a>
                <a href="{{ route('admin.invoices.index', ['status' => 'pending']) }}"
                    class="btn btn-warning text-white">بالانتظار:
                    5</a>
                <a href="{{ route('admin.invoices.index', ['status' => 'ongoing']) }}" class="btn btn-green">تحت التنفيذ:
                    5</a>
                <a href="{{ route('admin.invoices.index', ['status' => 'done']) }}" class="btn btn-secondary">منتهية:
                    5</a>
                <a href="{{ route('admin.invoices.index', ['status' => 'close']) }}" class="btn btn-danger">ملغية:
                    5</a>
                <a href="{{ route('admin.invoices.index', ['status' => 'unpaid']) }}" class="btn btn-purple">غير مسددة:
                    5</a>
                <a href="" class="btn btn-purple">مدفوعة لاحقا: 5</a>
                <a href="" class="btn btn-info">تصدير<i class="fa-solid fa-file-export"></i></a>
            </div>
            <div class="table-responsive">
                <table class="main-table">
                    <thead>
                        <tr>
                            <th>رقم</th>
                            <th>القسم</th>
                            <th>العميل</th>
                            <th>المحامي</th>
                            <th>مدفوعة لاحقا</th>
                            <th>المبلغ</th>
                            <th>حالة الدفع</th>
                            <th>الوقت المستهلك</th>
                            <th>التاريخ</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->id }}</td>
                                <td>{{ $invoice->department?->name }}</td>
                                <td>{{ $invoice->fromUser?->name }}</td>
                                <td>{{ $invoice->toUser?->name }}</td>
                                <td>-</td>
                                <td>{{ $invoice->total }}</td>
                                <td> {{ __($invoice->status) }} </td>
                                <td>-</td>
                                <td>{{ $invoice->created_at }}</td>
                                <td class="d-flex gap-1">
                                    {{-- <a target="_blank" href="" class="btn btn-purple btn-sm"> معاينة</a>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button> --}}

                                    @can('update_invoices')
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#update{{ $invoice->id }}">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <div class="modal fade" id="update{{ $invoice->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">تعديل الفاتورة</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('admin.invoices.update', $invoice->id) }}"
                                                        method="POST">
                                                        <div class="modal-body">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="">حالة الفاتورة</label>
                                                                <select name="status" class="form-control">
                                                                    <option value="">اختر</option>
                                                                    <option {{ $invoice->status == 'paid' ? 'selected' : '' }}
                                                                        value="paid">مسددة</option>
                                                                    <option
                                                                        {{ $invoice->status == 'unpaid' ? 'selected' : '' }}
                                                                        value="unpaid">غير مسددة</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">إلغاء</button>
                                                            <button type="submit" class="btn btn-primary">حفظ</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="alert alert-info">
                                        لا يوجد بيانات
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
                {{ $invoices->withQueryString()->links() }}
            </div>
        </div>
    </section>
    {{-- <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">حذف استشارة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    @csrf
                    هل أنت متأكد من حذف الفاتورة
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">نعم</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}
@endsection

{{-- @extends('admin.layouts.admin')
@section('title', 'الفواتير')
@section('content')
    <section class="">
        <div class="main-title">
            <div class="small">
                الحسابات المالية
            </div>
            <div class="large">
                الفواتير
            </div>
        </div>
        <div class="section_content content_view">
            <div class="d-flex align-items-end justify-content-between flex-wrap gap-3 mb-2">
                <div class="d-flex align-items-center justify-content-start flex-wrap gap-1">
                    <a href="{{ route('admin.invoices.index', ['status']) }}" class="btn btn-primary">الكل
{{ $allInvoices->count() }}</a>
<a href="{{ route('admin.invoices.index', ['status' => 'paid']) }}" class="btn btn-success">مسددة
    {{ $allInvoices->where('status', 'paid')->count() }}</a>
<a href="{{ route('admin.invoices.index', ['status' => 'unpaid']) }}" class="btn btn-danger">غير مسددة
    {{ $allInvoices->where('status', 'unpaid')->count() }}</a>
</div>
<form action="{{ route('admin.invoices.index') }}" class="d-flex align-items-end flex-wrap gap-1">
    <div class="inp-holder">
        <label for="">العضو</label>
        <select name="member" class="form-control">
            <option value="">اختر</option>
            <option {{ request('member') == 'client' ? 'selected' : '' }} value="client">عميل
            </option>
            <option {{ request('member') == 'vendor' ? 'selected' : '' }} value="vendor">محامي</option>
        </select>
    </div>
    <div class="inp-holder">
        <label for="">نوع الفاتورة</label>
        <select name="type" class="form-control">
            <option value="">اختر</option>
            <option {{ request('type') == 'consulting' ? 'selected' : '' }} value="consulting">استشارة
            </option>
            <option {{ request('type') == 'order' ? 'selected' : '' }} value="order">طلب</option>
        </select>
    </div>
    <div class="inp-holder">
        <label for="">من</label>
        <input type="date" name="from" id="" class="form-control" value="{{ request('from') }}">
    </div>
    <div class="inp-holder">
        <label for="">الى</label>
        <input type="date" name="to" id="" class="form-control" value="{{ request('to') }}">
    </div>
    <button class="btn btn-sm btn-primary">بحث</button>
</form>
</div>
<div class="table-responsive">
    <table class="main-table mb-2">
        <thead>
            <tr>
                <th>#</th>
                <th>الطلب</th>
                <th>نوع الفاتورة</th>
                <th>من المستخدم</th>
                <th>الى المستخدم</th>
                <th>مبلغ الادارة</th>
                <th>المبلغ</th>
                <th>الضريبة</th>
                <th>الاجمالي</th>
                <th>حالة الفاتورة</th>
                <th>تحكم</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
            <tr>
                <td>{{ $invoice->id }}</td>
                <td>{{ $invoice->order_id }}</td>
                <td>{{ $invoice->typeName }}</td>
                <td>{{ $invoice->from_id }}</td>
                <td>{{ $invoice->to_id }}</td>
                <td>{{ $invoice->admin_ratio }}</td>
                <td>{{ $invoice->amount }}</td>
                <td>{{ $invoice->tax }}</td>
                <td>{{ $invoice->total }}</td>
                <td>{{ __($invoice->status) }}</td>
                <td class="text-center">
                    @can('view_invoices')
                    <a target="_blank" class="btn table_btn btn-sm" href="{{ route('admin.invoices.show', $invoice) }}"><i class="fa-solid fa-eye"></i></a>
                    @endcan
                </td>

            </tr>
            @endforeach

        </tbody>
    </table>
    {{ $invoices->links() }}
</div>
<h4>المجموع</h4>
<div class="d-flex align-items-center justify-content-between flex-wrap">
    <p>مبالغ الادارة: {{ $allInvoices->sum('admin_ratio') }}</p>
    <p>المبالغ قبل الضريبة: {{ $allInvoices->sum('amount') }}</p>
    <p>الضرائب: {{ $allInvoices->sum('tax') }}</p>
    <p>الاجمالي: {{ $allInvoices->sum('total') }}</p>
</div>
</div>
</section>
@endsection --}}
