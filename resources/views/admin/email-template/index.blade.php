@extends('admin.layouts.admin')
@section('title', 'قوالب الايميلات')
@section('content')
    <section class="">
        <div class="main-title">
            <div class="small">
                الرئيسية
            </div>
            <div class="large">
                قوالب الايميلات
            </div>
        </div>
        <div class="section_content content_view">
            <div class="info_holder mb-2">
                <a href="{{ route('admin.email_templates.create') }}" class="main-btn btn-main-color">
                    إضافة
                    <i class="fa-solid fa-plus"></i>
                </a>
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
                        @foreach ($email_templates as $template)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $template->title }}</td>

                                <td class="d-flex gap-1">
                                    <a href="{{ route('admin.email_templates.edit', $template->id) }}"
                                        class="btn btn-info btn-sm"> <i class="fa-solid fa-pen"></i></a>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#delete{{ $template->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                    @include('admin.email-template.delete-modal', [
                                        'template' => $template,
                                    ])
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $email_templates->links() }}
            </div>
        </div>
    </section>
@endsection
