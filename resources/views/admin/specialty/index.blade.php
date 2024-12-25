@extends('admin.layouts.admin')
@section('title','التخصصات')
@section('content')
<section class="">
    <div class="main-title">
        <div class="small">
            خدمات الموقع
        </div>
        <div class="large">
            التخصصات
        </div>
    </div>
    <div class="section_content content_view">
        <div class="up_element mb-2">
            <button type="button" class="main-btn btn-main-color" data-bs-toggle="modal" data-bs-target="#create">
                إضافة
                <i class="fa-solid fa-plus"></i>
            </button>
            @include('admin.specialty.create-modal')
        </div>
        <div class="table-responsive">
            <table class="main-table mb-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>نوع العضوية</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($specialties as $specialty)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $specialty->name }}</td>
                        <td>{{ __($specialty->type) }}</td>
                        <td class="d-flex gap-1">
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit{{ $specialty->id }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{ $specialty->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                            @include('admin.specialty.edit-modal',['specialty'=>$specialty])
                            @include('admin.specialty.delete-modal',['specialty'=>$specialty])
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $specialties->links() }}
        </div>
    </div>
</section>
@endsection