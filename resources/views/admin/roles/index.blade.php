@extends('admin.layouts.admin')
@section('title')
المجموعات
@endsection
@section('content')
<section class="">
    <div class="main-title">
        <div class="small">
            المشرفين
        </div>
        <div class="large">
            صلاحيات المشرفين
        </div>
    </div>
    <div class="">
        <a href="{{ route('admin.roles.create') }}" class="main-btn btn-main-color mb-2">
            إضافة
            <i class="fa-solid fa-plus"></i>
        </a>
        <table class="main-table mb-2">
            <thead >
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">الاسم</th>
                    <th scope="col">تحكم</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('admin.roles.edit',$role) }}">تعديل</a>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#delete_agent{{ $role->id }}"><i></i>
                            حذف
                        </button>
                        @include('admin.roles.delete')
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $roles->links() }}

    </div>
</section>
@endsection