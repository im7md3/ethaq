@extends('admin.layouts.admin')
@section('title','الاسئلة')
@section('content')
<section class="">
        <div class="main-title">
            <div class="small">
                خدمات الموقع
            </div>
            <div class="large">
                الأسئلة
        </div>
    </div>
    <div class="section_content content_view">
        <div class="up_element mb-2">
            <button type="button" class="main-btn btn-main-color" data-bs-toggle="modal" data-bs-target="#create">
                إضافة
                <i class="fa-solid fa-plus"></i>
            </button>
            @include('admin.question.create-modal')
        </div>
        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>عنوان السؤال</th>
                        <th>الجواب</th>
                        <th>العضوية</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $question)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $question->name }}</td>
                        <td>{{ $question->result }}</td>
                        <td>{{ __($question->type) }}</td>
                         <td class="d-flex gap-1">
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit{{ $question->id }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{ $question->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                            @include('admin.question.edit-modal',['question'=>$question])
                            @include('admin.question.delete-modal',['question'=>$question])
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $questions->links() }}
        </div>
    </div>
</section>
@endsection