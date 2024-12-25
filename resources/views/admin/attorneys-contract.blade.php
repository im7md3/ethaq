@extends('admin.layouts.admin')
@section('title','الرئيسية')
@section('content')
<div class="main-title">
    <div class="small">
        الرئيسية
    </div>
    <div class="large">
        عقد المحاماة
    </div>
</div>
<label for="content" class="small-label">المحتوي  <span class="text-danger">*</span></label>
                    <textarea type="text" required name="content" id="content" class="form-control"></textarea>
@push('js')
<script src="//cdn.ckeditor.com/4.19.1/full/ckeditor.js"></script>
<script>
    // Replace the <textarea id="editor1"> with a CKEditor 4
    // instance, using default configuration.
    CKEDITOR.replace( 'content' );
</script>
@endpush
@stop
