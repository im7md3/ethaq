@extends('admin.layouts.admin')
@section('title')
اعدادات حسابات التواصل
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">اعدادات حسابات التواصل</h3>
            </div>
            <div class="card-body">
                <form action="{{route('admin.settings.updateSocialMedia')}}" method="POST" class="row w-100" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="register_new_client_individual">فيسبوك</label>
                        <input type="url" name="facebook" class="form-control" id="" value="{{ setting('facebook') }}">
                    </div>
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="judger_cost">انستغرام</label>
                        <input type="url" name="instagram" class="form-control" id="" value="{{ setting('instagram') }}">
                    </div>
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="judger_cost_tax">تويتر</label>
                        <input type="url" name="twitter" class="form-control" id="" value="{{ setting('twitter') }}">
                    </div>
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="admin_ratio">سناب شات</label>
                        <input type="url" name="snapchat" class="form-control" id="" value="{{ setting('snapchat') }}">
                    </div>
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="admin_ratio">لينكد ان</label>
                        <input type="url" name="linkedin" class="form-control" id="" value="{{ setting('linkedin') }}">
                    </div>
                    <button type="submit" class="btn btn-primary col-md-4 mt-3 rounded">حفظ</button>
                </form>
            </div>
        </div>
    </div>
</div>

@stop