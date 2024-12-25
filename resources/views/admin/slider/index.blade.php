@extends('admin.layouts.admin')
@section('title', 'عارض الصور')
@section('content')
<section class="">
    <div class="main-title">
        <div class="small">
            خدمات الموقع
        </div>
        <div class="large">
            السليدر
        </div>
    </div>
    <div class="section_content content_view">
        <div class="up_element mb-2">
            <button type="button" class="main-btn btn-main-color" data-bs-toggle="modal" data-bs-target="#create">
                إضافة
                <i class="fa-solid fa-plus"></i>
            </button>
            @include('admin.slider.create-modal')
        </div>
        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الصورة</th>
                        <th>العضوية</th>
                        <th>خاص ب</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sliders as $slider)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><a target="_blank" href="{{ display_file($slider->image) }}"><img
                                    src="{{ display_file($slider->image) }}" width="100" alt=""></a></td>
                        <th>{{ __($slider->type) }}</th>
                        <th>@if ($slider->model_type=='orders')
                            الطلبات
                            @elseif($slider->model_type=='consulting')
                            استشارات
                            @elseif($slider->model_type=='services')
                            طلبات خاصة
                            @else
                            الكل
                            @endif</th>

                        <td class="d-flex gap-1">
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#edit{{ $slider->id }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            @can('read_sliders')
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#delete{{ $slider->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            @endcan

                            @include('admin.slider.edit-modal', ['slider' => $slider])
                            @include('admin.slider.delete-modal', ['slider' => $slider])
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $sliders->links() }}
        </div>
    </div>
</section>
@endsection