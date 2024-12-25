@extends('admin.layouts.admin')
@section('title', 'الطلبات')
@section('content')
    <section class="">
        <div class="main-title">
            <div class="small">
                الطلبات
            </div>
            <div class="large">
                كل الطلبات
            </div>
        </div>
        <div class="section_content content_view">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-1 mb-2">
                <div class="buttons_holder btn-holder d-flex align-items-center justify-content-start flex-wrap gap-1">
                    <a href="{{ route('admin.orders.create') }}" class="main-btn btn-main-color">
                        إضافة
                        <i class="fa-solid fa-plus"></i>
                    </a>
                    @php
                        $allOrders = App\Models\Order::get();
                    @endphp
                    <a href="" class="btn btn-primary">الكل: {{ $allOrders->count() }}</a>
                    <a href="?status=open" class="btn btn-green">جاهز لتلقي العروض: {{ $allOrders->where('status', 'open')->count() }}</a>
                    <a href="?status=close" class="btn btn-danger">مغلق: {{ $allOrders->where('status', 'close')->count() }}</a>
                    <a href="?unpaid=1" class="btn btn-purple">لم تكتمل:
                        {{App\Models\Order::whereHas('invoices',function($q){
                            $q->where('status','unpaid');
                        })->count() }}</a>
                    <a href="?paid=1" class="btn btn-purple">تحت التنفيذ:
                        {{App\Models\Order::whereHas('invoices',function($q){
                            $q->where('status','paid');
                        })->count() }}</a>
                    <a href="?status=judger Decision" class="btn btn-info">العرض على المحكم:
                        {{ $allOrders->where('status', 'judger Decision')->count() }}</a>
                    <a href="?status=done" class="btn btn-secondary">منتهي:
                        {{ $allOrders->where('status', 'done')->count() }}</a>
                </div>
                <a href="{{ route('admin.orders.exports', request()->query()) }}" class="btn btn-info">تصدير<i
                    class="fa-solid fa-file-export"></i></a>
            </div>
            <div class="">
                <form action="">
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}">
                    <button class="btn btn-sm btn-info">بحث</button>
                </form>
            </div>
            <div class="table-responsive">
                <table class="main-table mb-2">
                    <thead>
                        <tr>
                            <th>رقم</th>
                            <th>العنوان</th>
                            <th>القسم</th>
                            <th>حالة الطلب</th>
                            <th>العميل</th>
                            <th>المحامي</th>
                            <th>العروض</th>
                            <th>حالة الدفع</th>
                            <th>مبلغ العرض</th>
                            {{-- <th>المحكم</th> --}}
                            <th>برايفت</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</th>
                                <td>{{ $order->title }}</td>
                                <td>{{ $order->department?->name }}</td>
                                <td>{{ __($order->status) }}</td>
                                <td><a
                                        href="{{ $order->client ? route('admin.clients.show', $order->client) : '' }}">{{ $order->client?->name }}</a>
                                </td>
                                <td><a
                                        href="{{ $order->vendor ? route('admin.vendors.show', $order->vendor) : '' }}">{{ $order->vendor?->name ?? 'لم يحدد بعد' }}</a>
                                </td>
                                <td>{{ $order->offers_count }}</td>
                                <td>{{ $order->invoices()->where('order_type','App\Models\Order')->where('for_type','vendor')->first()?->status=='paid'?'نعم':'لا' }}</td>
                                <td>{{ $order->activeOffer?->amount }} ر.س</td>
                                {{-- <td><a
                                        href="{{ $order->firstJudger ? route('admin.judgers.show', $order->firstJudger) : '' }}">{{ $order->firstJudger?->name ?? 'لم يحدد بعد' }}</a>
                                </td> --}}
                                <td>
                                    @if ($order->vendors->count() > 0)
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#vendors{{ $order->id }}">
                                            عرض المحاميين
                                        </button>
                                        @include('admin.order.vendors', ['order' => $order])
                                    @else
                                        لا
                                    @endif
                                </td>
                                <td class="d-flex gap-1">
                                    @can('update_orders')
                                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-info btn-sm"> <i
                                                class="fa-solid fa-pen"></i></a>
                                    @endcan
                                    @can('read_orders')
                                        <a target="_blank" href="{{ route('admin.orders.show', $order->hash_code) }}"
                                            class="btn btn-purple btn-sm"> معاينة</a>
                                    @endcan
                                    @can('delete_orders')
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $order->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                        @include('admin.order.delete-modal', ['order' => $order])
                                    @endcan
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $orders->links() }}
            </div>
        </div>
    </section>
@endsection
