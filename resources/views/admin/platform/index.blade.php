@extends('admin.layouts.admin')
@section('title','المدن')
@section('content')
<section class="">
    <div class="main-title">
        <div class="small">
            الرئيسية
        </div>
        <div class="large">
            من أين تعرفت علينا
        </div>
    </div>
    <div class="section_content content_view">
        @can('create_platforms')
        <div class="up_element mb-2">
            <button type="button" class="main-btn btn-main-color" data-bs-toggle="modal" data-bs-target="#create">
                إضافة
                <i class="fa-solid fa-plus"></i>
            </button>
            @include('admin.platform.create-modal')
        </div>
        @endcan
        <div class="table-responsive">
            <table class="main-table mb-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>العدد</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($platforms as $platform)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $platform->name }}</td>
                        <td><a href="{{ route('admin.clients.index',['plat'=>$platform->id]) }}">{{
                                $platform->users_count }}<i class="fa fa-eye"></i></a></td>
                        <td class="d-flex gap-1">
                            @can('update_platforms')
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#edit{{ $platform->id }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            @include('admin.platform.edit-modal',['platform'=>$platform])
                            @endcan
                            @can('delete_platforms')
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#delete{{ $platform->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            @include('admin.platform.delete-modal',['platform'=>$platform])
                            @endcan
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $platforms->links() }}
        </div>
    </div>
</section>
@endsection