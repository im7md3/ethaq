@extends('admin.layouts.admin')
@section('title','المؤهلات')
@section('content')
<section class="">
        <div class="main-title">
            <div class="small">
                خدمات الموقع
            </div>
            <div class="large">
            المؤهلات
        </div>
    </div>
    <div class="section_content content_view">
        <div class="up_element mb-2">
            <button type="button" class="main-btn btn-main-color" data-bs-toggle="modal" data-bs-target="#create">
                إضافة
                <i class="fa-solid fa-plus"></i>
            </button>
            @include('admin.qualification.create-modal')
        </div>
        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>نوع العضوية</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($qualifications as $qualification)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $qualification->name }}</td>
                        <td>{{ __($qualification->type) }}</td>
                        <td class="d-flex gap-1">
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit{{ $qualification->id }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{ $qualification->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                            @include('admin.qualification.edit-modal',['qualification'=>$qualification])
                            @include('admin.qualification.delete-modal',['qualification'=>$qualification])
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $qualifications->links() }}
        </div>
    </div>
</section>
@endsection