@extends('admin.layouts.admin')
@section('title', 'المشرفين')
@section('content')
    <div class="main-title">
        <div class="small">
            المشرفين
        </div>
        <div class="large">
            كل المشرفين
        </div>
    </div>
    <div class="section_content content_view">
        <div class="info_holder d-flex align-items-center gap-2 mb-2">
            <div class="up_element">
                <a href="{{ route('admin.admins.create') }}" class="main-btn btn-main-color">
                    إضافة
                    <i class="fa-solid fa-plus"></i>
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="main-table mb-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الجوال</th>
                        <th>الإيميل</th>
                        <th>المجموعة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->phone }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->role?->name }}</td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('admin.admins.edit',$admin) }}"
                                class="btn btn-info btn-sm"> <i class="fa-solid fa-pen"></i></a>
                            <a href="{{ route('admin.admins.show', $admin) }}"
                                class="btn btn-purple btn-sm"> <i class="fa-solid fa-eye"></i></a>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#delete{{ $admin->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                            @include('admin.admin.delete-modal', ['admin' => $admin])
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $admins->links() }}
        </div>
    </div>
@endsection
