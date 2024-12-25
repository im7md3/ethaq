@extends('admin.layouts.admin')
@section('title', 'الطلبات الخاصة')
@section('content')
    <section class="">
        <div class="main-title">
            <div class="small">
                الرئيسية
            </div>
            <div class="large">
            الطلبات الخاصة
            </div>
        </div>
        <div class="section_content content_view">
            <div class="table-responsive">
                <table class="main-table">
                    <thead>
                        <tr>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>العنوان</th>
                            <th>الوقت</th>
                            <th>آخر تعليق</th>
                            <th>تحكم</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a
                                        href="{{ route('admin.clients.show', $service->client) }}">{{ $service->client->name }}</a>
                                </td>
                                <td>{{ $service->title }}</td>
                                <td>{{ $service->created_at->diffForHumans() }}</td>
                                <td>{{ $service->LastMsg?->user?->type=='admin'?'الإدارة':"العميل" }}</td>
                                <td class="d-flex gap-1">
                                    <a class="btn btn-sm  btn-purple"
                                        href="{{ route('admin.specialServices.show', $service) }}">معاينة</a>
                                    <button data-bs-toggle="modal" data-bs-target="#delete{{ $service->id }}"
                                        type="button" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                    @include('admin.special_services.delete-modal', [
                                        'service' => $service,
                                    ])

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $services->links() }}
            </div>
        </div>
    </section>
@endsection
