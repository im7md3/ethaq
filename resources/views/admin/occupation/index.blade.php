@extends('admin.layouts.admin')
@section('title','الوظائف')
@section('content')
<section class="">
    <div class="main-title">
        <div class="small">
            خدمات الموقع
        </div>
        <div class="large">
            الوظائف
        </div>
    </div>
    <div class="section_content content_view">
        <div class="up_element mb-2">
            <button type="button" class="main-btn btn-main-color" data-bs-toggle="modal" data-bs-target="#create">
                إضافة
                <i class="fa-solid fa-plus"></i>
            </button>
            @include('admin.occupation.create-modal')
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
                    @foreach ($occupations as $occupation)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $occupation->name }}</td>
                        <td>{{ __($occupation->type) }}</td>
                        <td class="d-flex gap-1">
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit{{ $occupation->id }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{ $occupation->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            @include('admin.occupation.edit-modal',['occupation'=>$occupation])
                            @include('admin.occupation.delete-modal',['occupation'=>$occupation])
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $occupations->links() }}
        </div>
    </div>
</section>
@endsection