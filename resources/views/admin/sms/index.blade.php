@extends('admin.layouts.admin')
@section('title','رسائل الجوال')
@section('content')
<section class="">
    <div class="main-title">
        <div class="large">
            رسائل الجوال
        </div>
    </div>
    <div class="section_content content_view">
        @can('create_SMS')
        <div class="up_element mb-2">
            <a href="{{ route('admin.sms.departments') }}" class="main-btn btn-main-color">
                ارسال رسالة حسب القسم
                <i class="fa-solid fa-plus"></i>
            </a>
            <a href="{{ route('admin.sms.users') }}" class="main-btn btn-main-color">
                ارسال رسالة حسب المجموعة
                <i class="fa-solid fa-plus"></i>
            </a>
        </div>
        @endcan
        <div class="table-responsive">
            <table class="main-table mb-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المرسل</th>
                        <th>الرسالة</th>
                        <th>الوقت</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sms as $s)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $s->user?->name }}</td>
                        <td>{{ $s->msg }}</td>
                        <td>{{ $s->created_at->format('Y-m-d') }}</td>
                        <td class="d-flex gap-1">
                            @can('delete_SMS')
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{ $s->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                            @include('admin.sms.delete-modal',['sms'=>$s])
                            @endcan
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $sms->links() }}
        </div>
    </div>
</section>
@endsection