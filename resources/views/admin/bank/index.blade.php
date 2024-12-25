@extends('admin.layouts.admin')
@section('title','البنوك')
@section('content')
<section class="">
    <div class="main-title">
        <div class="small">
            الرئيسية
        </div>
        <div class="large">
            البنوك
        </div>
    </div>
    <div class="section_content content_view">
        @can('create_banks')
        <div class="up_element mb-2">
            <button type="button" class="main-btn btn-main-color" data-bs-toggle="modal" data-bs-target="#create">
                إضافة
                <i class="fa-solid fa-plus"></i>
            </button>
            @include('admin.bank.create-modal')
        </div>
        @endcan
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
                    @foreach ($banks as $bank)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $bank->name }}</td>
                        <td class="d-flex gap-1">
                            @can('update_banks')
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#edit{{ $bank->id }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            @include('admin.bank.edit-modal',['bank'=>$bank])
                            @endcan
                            @can('delete_banks')
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#delete{{ $bank->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            @include('admin.bank.delete-modal',['bank'=>$bank])
                            @endcan
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $banks->links() }}
        </div>
    </div>
</section>
@endsection