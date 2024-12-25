@extends('admin.layouts.admin')
@section('title')
الاعدادات
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">الاعدادات</h3>
            </div>
            <div class="card-body">
                <form action="{{route('admin.settings.updateGeneral')}}" method="POST" class="row w-100" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-md-6 mb-2 ">
                        <label class="mb-1" for="website_name">اسم الموقع</label>
                        <input type="text" name="website_name" id="website_name" class="form-control" value="{{old('website_name', setting('website_name'))}}">
                    </div>
                    <div class="form-group col-md-6 mb-2 ">
                        <label class="mb-1" for="link">رابط الموقع</label>
                        <input type="text" name="link" id="link" class="form-control" value="{{old('link', setting('link'))}}">
                    </div>
                    <div class="form-group col-md-6 mb-2 ">
                        <label class="mb-1" for="tax_number">الرقم الضريبي</label>
                        <input type="text" name="tax_number" id="tax_number" class="form-control" value="{{old('tax_number', setting('tax_number'))}}">
                    </div>
                    <div class="form-group col-md-6 mb-2 ">
                        <label class="mb-1" for="address">العنوان</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{old('address', setting('address'))}}">
                    </div>
                    <div class="form-group col-md-6 mb-2 ">
                        <label class="mb-1" for="building_number">رقم المبنى</label>
                        <input type="text" name="building_number" id="building_number" class="form-control" value="{{old('building_number', setting('building_number'))}}">
                    </div>
                    <div class="form-group col-md-6 mb-2 ">
                        <label class="mb-1" for="street">الشارع</label>
                        <input type="text" name="street" id="street" class="form-control" value="{{old('street', setting('street'))}}">
                    </div>
                    <div class="form-group col-md-4 mb-2 ">
                        <label class="mb-1" for="phone">لجوال</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{old('phone', setting('phone'))}}">
                    </div>
                    <div class="form-group col-md-4 mb-2 ">
                        <label class="mb-1" for="iban">رقم الحساب ايبان</label>
                        <input type="text" name="iban" id="iban" class="form-control" value="{{old('iban', setting('iban'))}}">
                    </div>
                    <div class="form-group col-md-4 mb-2 ">
                        <label class="mb-1" for="activate_taxes">تفعيل الضريبة</label>
                        <select name="activate_taxes" id="activate_taxes" class="form-control">
                            <option value="1" {{old('activate_taxes', setting('activate_taxes')) == 1 ? 'selected' : ''}}>مفعل</option>
                            <option value="0" {{old('activate_taxes', setting('activate_taxes')) == 0 ? 'selected' : ''}}>غير مفعل</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4 mb-2 ">
                        <label class="mb-1" for="activate_email">تفعيل ارسال البريد الالكتروني</label>
                        <select name="activate_email" id="activate_email" class="form-control">
                            <option value="1" {{old('activate_email', setting('activate_email')) == 1 ? 'selected' : ''}}>مفعل</option>
                            <option value="0" {{old('activate_email', setting('activate_email')) == 0 ? 'selected' : ''}}>غير مفعل</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4 mb-2 ">
                        <label class="mb-1" for="website_active">حالة الموقع</label>
                        <select name="website_active" id="website_active" class="form-control">
                            <option value="1" {{old('website_active', setting('website_active')) == 1 ? 'selected' : ''}}>مفعل</option>
                            <option value="0" {{old('website_active', setting('website_active')) == 0 ? 'selected' : ''}}>غير مفعل</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4 mb-2 ">
                        <label class="mb-1" for="tamam_active">تمام</label>
                        <select name="tamam_active" id="tamam_active" class="form-control">
                            <option value="1" {{old('tamam_active', setting('tamam_active')) == 1 ? 'selected' : ''}}>مفعل</option>
                            <option value="0" {{old('tamam_active', setting('tamam_active')) == 0 ? 'selected' : ''}}>غير مفعل</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4 mb-2 ">
                        <label class="mb-1" for="tamara_active">تمارا</label>
                        <select name="tamara_active" id="tamara_active" class="form-control">
                            <option value="1" {{old('tamara_active', setting('tamara_active')) == 1 ? 'selected' : ''}}>مفعل</option>
                            <option value="0" {{old('tamara_active', setting('tamara_active')) == 0 ? 'selected' : ''}}>غير مفعل</option>
                        </select>
                    </div>
                    
                    <div class="form-group col-md-6 mb-2 ">
                        <label class="mb-1" for="logo_file">صورة الشعار</label>
                        <input type="file" name="logo_file" id="logo_file" class="form-control" value="{{old('logo_file', setting('logo_file'))}}">
                    </div>
                    <div class="form-group col-md-6 mb-2 ">
                        <label class="mb-1" for="fav_icon_file">صورة ايقونة المتصفح</label>
                        <input type="file" name="fav_icon_file" id="fav_icon_file" class="form-control" value="{{old('fav_icon_file', setting('fav_icon_file'))}}">
                    </div>
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="website_inactive_message">رسالة تعطيل الموقع</label>
                        <textarea name="website_inactive_message" rows="6" id="website_inactive_message" class="form-control">{{old('website_inactive_message', setting('website_inactive_message'))}}</textarea>
                    </div>
                    <div class="form-group col-md-4 mb-2 ">
                        <label class="mb-1" for="UI_phone">حالة UI في تطبيق الجوال</label>
                        <select name="UI_phone" id="UI_phone" class="form-control">
                            <option value="1" {{old('UI_phone', setting('UI_phone')) == 1 ? 'selected' : ''}}>إظهار</option>
                            <option value="0" {{old('UI_phone', setting('UI_phone')) == 0 ? 'selected' : ''}}>إخفاء</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary col-md-4 mt-3 rounded">حفظ</button>
                </form>
            </div>
        </div>
    </div>
</div>

@stop