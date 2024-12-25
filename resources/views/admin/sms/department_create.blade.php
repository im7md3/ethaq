@extends('admin.layouts.admin')
@section('title','ارسال رسالة حسب القسم')
@section('content')
<section class="">
    <div class="main-title">
        <div class="large">
            ارسال رسالة حسب القسم
        </div>
    </div>
    <div class="section_content content_view">
        <form action="{{ route('admin.sms.departments.store') }}" method="POST">
            <div class="modal-body">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->id() }}" id="">
                <div class="form-group">
                    <label for="">القسم</label>
                    <select name="department_id" id="" class="form-control">
                        <option value="">اختر القسم</option>
                        @foreach ($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">الرسالة</label>
                    <textarea name="msg" id="" class="form-control"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">حفظ</button>
        </form>

    </div>
</section>
@endsection