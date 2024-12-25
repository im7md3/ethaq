@extends('admin.layouts.admin')
@section('title', 'الاستشارات')
@section('content')
    <section class="">
        <div class="main-title">
            <div class="small">
                الرئيسية
            </div>
            <div class="large">
                الاستشارات
            </div>
        </div>
        <div class="section_content content_view">
            <div class="buttons_holder d-flex align-items-center justify-content-start flex-wrap gap-1 mb-2">
                <a href="{{ route('admin.consulting.create') }}" class="main-btn btn-main-color">
                    إضافة
                    <i class="fa-solid fa-plus"></i>
                </a>
                <a href="{{ route('admin.consulting.index') }}" class="btn btn-primary">الكل:
                    {{ $allConsulting->count() }}</a>
                <a href="{{ route('admin.consulting.index', ['status' => 'pending']) }}"
                    class="btn btn-warning text-white">جديدة:
                    {{ $allConsulting->where('status', 'pending')->count() }}</a>
                <a href="{{ route('admin.consulting.index', ['status' => 'active']) }}" class="btn btn-green">تحت التنفيذ:
                    {{ $allConsulting->where('status', 'active')->count() }}</a>
                <a href="{{ route('admin.consulting.index', ['status' => 'done']) }}" class="btn btn-secondary">منتهية:
                    {{ $allConsulting->where('status', 'done')->count() }}</a>
                <a href="{{ route('admin.consulting.index', ['status' => 'cancel']) }}" class="btn btn-danger">ملغية:
                    {{ $allConsulting->where('status', 'cancel')->count() }}</a>
                <a href="{{ route('admin.consulting.index', ['invoices' => 'not_paid']) }}" class="btn btn-purple">غير
                    مدفوعة:
                    {{ $not_paid }}</a>
                {{-- <a href="{{ route('admin.consulting.index', ['later' => '1']) }}" class="btn btn-purple">مدفوعة لاحقا:
                    {{ $later }}</a> --}}
                <a href="{{ route('admin.consultings.exports', request()->query()) }}" class="btn btn-info">تصدير<i
                        class="fa-solid fa-file-export"></i></a>
            </div>
            <div class="">
                <form action="">
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}">
                    <button class="btn btn-sm btn-info">بحث</button>
                </form>
            </div>
            <div class="table-responsive">
                <table class="main-table">
                    <thead>
                        <tr>
                            <th>رقم</th>
                            <th>القسم</th>
                            <th>حالة الاستشارة</th>
                            <th>العميل</th>
                            <th>المحامي</th>
                            {{-- <th>مدفوعة لاحقا</th> --}}
                            <th>المبلغ</th>
                            <th>حالة الدفع</th>
                            <th>الوقت المستهلك</th>
                            <th>التاريخ</th>
                            @can('view_invoices')
                                <th>معاينة الفاتورة</th>
                            @endcan
                            @can('view_consulting')
                                <th>العمليات</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consulting as $con)
                            <tr>
                                <td>{{ $con->id }}</td>
                                <td>{{ $con->department?->name }}</td>
                                <td>{{ __($con->status) }}</td>
                                <td><a
                                        href="{{ $con->client ? route('admin.clients.show', $con->client) : '' }}">{{ $con->client?->name }}</a>
                                </td>
                                <td><a
                                        href="{{ $con->vendor ? route('admin.vendors.show', $con->vendor) : '' }}">{{ $con->vendor?->name ?? 'لم يحدد بعد' }}</a>
                                </td>
                                <td>{{ $con->amount ?? 'لم يحدد بعد' }}</td>
                                <td>{{ $con->invoices?->status == 'paid' ? 'مسددة' : 'غير مسددة' }}</td>
                                <td>{{ $con->min . ':' . $con->sec }} دقيقة</td>
                                <td>{{ $con->created_at }}</td>
                                @can('view_invoices')
                                    <td>
                                        @if ($con->invoices)
                                            <a target="_blank" class="btn table_btn btn-sm"
                                                href="{{ route('admin.invoices.show', ['invoice' => $con->invoices, 'type' => 'client']) }}">فاتورة
                                                العميل</a>
                                            <a target="_blank" class="btn table_btn btn-sm"
                                                href="{{ route('admin.invoices.show', ['invoice' => $con->invoices, 'type' => 'vendor']) }}">فاتورة
                                                المحامي</a>
                                        @else
                                            لا يوجد فاتورة بعد
                                        @endif
                                    </td>
                                @endcan

                                @can('view_consulting')
                                    <td class="d-flex gap-1">
                                        <a target="_blank" href="{{ route('admin.consulting.show', $con) }}"
                                            class="btn btn-purple btn-sm"> معاينة</a>

                                        @can('delete_consulting')
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#delete{{ $con->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endcan

                                        @include('admin.consulting.delete-modal', ['con' => $con])
                                    </td>
                                @endcan
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $consulting->appends(request()->query())->links() }}
            </div>
        </div>
    </section>
@endsection
