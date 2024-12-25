@extends('admin.layouts.admin')
@section('title','الدول')
@section('content')
<section class="">
    <div class="main-title">
        <div class="small">
            خدمات الموقع
        </div>
        <div class="large">
            الدول
        </div>
    </div>
    <div class="section_content content_view">
        <div class="up_element mb-2">
            <button type="button" class="main-btn btn-main-color" data-bs-toggle="modal" data-bs-target="#create">
                إضافة
                <i class="fa-solid fa-plus"></i>
            </button>
            @include('admin.country.create-modal')
        </div>
        <div class="table-responsive">
            <table class="main-table mb-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($countries as $country)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $country->name }}</td>
                        <td class="d-flex gap-1">
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit{{ $country->id }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{ $country->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                            @include('admin.country.edit-modal',['country'=>$country])
                            @include('admin.country.delete-modal',['country'=>$country])
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $countries->links() }}
        </div>
    </div>
</section>
@endsection