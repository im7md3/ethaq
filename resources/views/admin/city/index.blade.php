@extends('admin.layouts.admin')
@section('title','المدن')
@section('content')
<section class="">
    <div class="main-title">
        <div class="small">
            خدمات الموقع
        </div>
        <div class="large">
            المدن
        </div>
    </div>
    <div class="section_content content_view">
        <div class="up_element mb-2">
            <button type="button" class="main-btn btn-main-color" data-bs-toggle="modal" data-bs-target="#create">
                إضافة
                <i class="fa-solid fa-plus"></i>
            </button>
            @include('admin.city.create-modal')
        </div>
        <div class="table-responsive">
            <table class="main-table mb-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الدولة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cities as $city)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $city->name }}</td>
                        <td>{{ $city->country->name }}</td>
                        <td class="d-flex gap-1">
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit{{ $city->id }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{ $city->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                            @include('admin.city.edit-modal',['city'=>$city])
                            @include('admin.city.delete-modal',['city'=>$city])
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $cities->links() }}
        </div>
    </div>
</section>
@endsection