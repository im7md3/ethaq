@extends('admin.layouts.admin')
@section('title', 'التذاكر')
@section('content')
<section class="">
    <div class="main-title">
        <div class="small">
            الدعم الفني
        </div>
        <div class="large">
            التذاكر
        </div>
    </div>
    <div class="section_content content_view">
        <div class="up_element mb-2">
            <button type="button" class="main-btn btn-main-color" data-bs-toggle="modal" data-bs-target="#create">
                إضافة
                <i class="fa-solid fa-plus"></i>
            </button>
            @include('admin.ticket.create-modal')
        </div>
        <div class="">
            <a href="?status=" class="btn btn-info btn-sm">الكل: {{ $all }}</a>
            <a href="?status=open" class="btn btn-warning btn-sm">مفتوحة: {{ $open }}</a>
            <a href="?status=closed" class="btn btn-danger btn-sm">مغلقة: {{ $closed }}</a>
            <a href="?status=finished" class="btn btn-success btn-sm">تم الرد: {{ $finished }}</a>
        </div>
        <div class="table-responsive">
            <table class="main-table mb-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>العميل</th>
                        <th>العنوان</th>
                        <th>القسم</th>
                        <th>المحتوى</th>
                        <th>الحالة</th>
                        <th>التعليقات</th>
                        <th>واتسآب</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><a href="{{ $ticket->user?route('admin.'.$ticket->user->type.'s.show',$ticket->user->id):'' }}">{{ $ticket->user?->name??'مستخدم محذوف' }} - {{ __($ticket->user?->type) }} </a></td>
                        <td>{{ $ticket->title }}</td>
                        <td>
                            @if ($ticket->type == 'orders')
                            الطلبات
                            @elseif($ticket->type == 'activate_mempership')
                            تفعيل العضوية
                            @else
                            آخرى
                            @endif
                        </td>
                        <td>
                            {{ Str::limit($ticket->description, 50, $end = '....') }}
                        </td>

                        <td>
                            @if ($ticket->status == 'open')
                            <span class="badge bg-warning">مفتوحة</span>
                            @elseif($ticket->status == 'finished')
                            <span class="badge bg-success">تم الرد</span>
                            @else
                            <span class="badge bg-danger">مغلقة</span>
                            @endif
                        </td>
                        <td>

                            <a class="btn btn-secondary btn-sm" href="{{ route('admin.tickets.show', $ticket->id) }}">
                                التعليقات
                                ({{ $ticket->comments->count() }})
                            </a>


                        </td>
                        <td><a href="https://wa.me/00966{{ substr($ticket->user?->phone, 1) }}" target="_blank" class="btn-whatsapp">
                                <i class="fab fa-whatsapp"></i>
                            </a></td>
                        <td class="d-flex gap-1">
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#edit{{ $ticket->id }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#delete{{ $ticket->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#add_comment">
                                أضف تعليق
                            </button>


                            @include('admin.ticket.edit-modal', ['ticket' => $ticket])
                            @include('admin.ticket.delete-modal', ['ticket' => $ticket])
                            @include('admin.ticket.comments-modal', ['ticket' => $ticket])
                            @include('admin.ticket.add_comment', ['ticket' => $ticket])
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $tickets->links() }}
        </div>
    </div>
</section>
@endsection