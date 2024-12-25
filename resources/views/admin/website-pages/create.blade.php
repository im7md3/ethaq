@extends('admin.layouts.admin')
@section('title','إضافة صفحة')
@section('content')
<section class="" id="app">
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb bg-light p-3">
            <li href="" class="breadcrumb-item" aria-current="page">
                اضافة صفحة
            </li>
        </ol>
    </nav>
    <div class="content_view">
        <form action="{{ route('admin.website-pages.store') }}" method="POST" enctype="multipart/form-data">
            <div class="row row-gap-24">
                @csrf
                <div class="col-sm-6 col-md-4 col-lg-12">
                    <label for="" class="small-label">عنوان الصفحة <span class="text-danger">*</span></label>
                    <input type="text" required name="title" class="form-control" value="{{ old('title') }}">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-12">
                    <label for="content" class="small-label">محتوى الصفحة <span class="text-danger">*</span></label>
                    <textarea type="text" required name="content" id="content" class="form-control">{!! old('content') !!}</textarea>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-12">
                    <label for="" class="small-label"> حالة الطلب </label>
                    <select name="status" class="form-control" v-model='status'>
                        <option value="">أختر حالة الطلب</option>
                        <option value="1">مفعله</option>
                        <option value="0">غير مفعله</option>
                    </select>
                </div>
                <div class="col-12 d-flex align-items-center justify-content-center mt-3">
                    <button type="submit" class="btn btn-success">حفظ</button>
                </div>
            </div>
        </form>
    </div>
</section>
@push('js')
<script src="//cdn.ckeditor.com/4.19.1/full/ckeditor.js"></script>
<script>
    // Replace the <textarea id="editor1"> with a CKEditor 4
    // instance, using default configuration.
    CKEDITOR.replace( 'content' );
</script>
@endpush
@endsection
