@extends('admin.layouts.admin')
@section('title', 'الأقسام')
@section('content')
    <section class="">
        <div class="main-title">
            <div class="small">
                الرئيسية
            </div>
            <div class="large">
                الأقسام
            </div>
        </div>
        <div class="section_content content_view">
            <div class="up_element mb-2">
                <button type="button" class="main-btn btn-main-color" data-bs-toggle="modal" data-bs-target="#create">
                    إضافة
                    <i class="fa-solid fa-plus"></i>
                </button>
                @include('admin.department.create-modal')
            </div>
            <div class="table-responsive">
                <table class="main-table mb-2">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>القسم الأب</th>
                            <th>الصورة</th>
                            <th>عدد المحاميين</th>
                            <th>الأقسام الفرعية</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $department)
                            <tr>
                                <td>{{ $loop->iteration }}</th>
                                <td>{{ $department->name }}</td>
                                <td>{{ $department->main?->name ?? '-' }}</td>
                                <td><img src="{{ $department->photo }}" width="50" alt=""></td>
                                <td><a href="{{ route('admin.departments.users', $department) }}">{{ $department->users_count }}
                                        <i class="fa fa-eye"></i></a></td>
                                <td><a class="btn btn-sm btn-primary"
                                        href="{{ route('admin.departments.sub_departments', ['parent' => $department->id]) }}">
                                        الأقسام الفرعية ({{ $department->kids->count() }})</a></td>
                                <td class="d-flex gap-1">
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#edit{{ $department->id }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#delete{{ $department->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                    @include('admin.department.edit-modal', ['department' => $department])
                                    @include('admin.department.delete-modal', [
                                        'department' => $department,
                                    ])
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $departments->links() }}
            </div>
        </div>
    </section>
@endsection
