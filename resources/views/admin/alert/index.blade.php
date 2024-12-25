@extends('admin.layouts.admin')
@section('title', 'التنبيهات')
@section('content')
    <section class="">
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb bg-light p-3">
                <li href="" class="breadcrumb-item" aria-current="page">
                    التنبيهات
                </li>
            </ol>
        </nav>
        <div class="section_content content_view">
            <div class="up_element">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create">
                    إضافة
                </button>
                @include('admin.alert.create-modal')
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>العنوان</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alerts as $alert)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{!! $alert->title !!}</td>
                                <td class="d-flex gap-2">
                                    <button type="button" class="btn btn-info btn-sm text-white mx-1"
                                        data-bs-toggle="modal" data-bs-target="#edit{{ $alert->id }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#delete{{ $alert->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                    @include('admin.alert.edit-modal', ['alert' => $alert])
                                    @include('admin.alert.delete-modal', ['alert' => $alert])
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $alerts->links() }}
            </div>
        </div>
    </section>
@endsection
