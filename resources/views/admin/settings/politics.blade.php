@extends('admin.layouts.admin')
@section('title')
السياسات
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">السياسات</h3>
            </div>
            <div class="card-body">
                <form action="{{route('admin.settings.updatePolitics')}}" method="POST" class="row w-100" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="judger_cost">السياسات</label>
                        <textarea id="content" name="politics" class="form-control">{{ old('politics',setting('politics')) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary col-md-4 mt-3 rounded">حفظ</button>
                </form>
            </div>
        </div>
    </div>
</div>
@push('js')
<script src="//cdn.ckeditor.com/4.19.1/full/ckeditor.js"></script>
<script>
    // Replace the <textarea id="editor1"> with a CKEditor 4
    // instance, using default configuration.
    CKEDITOR.replace( 'content' );
</script>
@endpush
@endsection