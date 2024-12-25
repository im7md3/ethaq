@extends('admin.layouts.admin')
@section('title')
اعدادات العضويات
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">اعدادات العضويات</h3>
            </div>
            <div class="card-body">
                <form action="{{route('admin.settings.updateMemberships')}}" method="POST" class="row w-100" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="register_by_nafath">تسجيل باستخدام نفاذ</label>
                        <select name="register_by_nafath" id="register_by_nafath" class="form-control">
                            <option value="1" {{old('register_by_nafath', setting('register_by_nafath')) == 1 ? 'selected' : ''}}>مفعل</option>
                            <option value="0" {{old('register_by_nafath', setting('register_by_nafath')) == 0 ? 'selected' : ''}}>غير مفعل</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="register_new_client_individual">تسجيل عضوية عميل افراد</label>
                        <select name="register_new_client_individual" id="register_new_client_individual" class="form-control">
                            <option value="1" {{old('register_new_client_individual', setting('register_new_client_individual')) == 1 ? 'selected' : ''}}>مفعل</option>
                            <option value="0" {{old('register_new_client_individual', setting('register_new_client_individual')) == 0 ? 'selected' : ''}}>غير مفعل</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="register_new_client_company">تسجيل عضوية عميل شركات</label>
                        <select name="register_new_client_company" id="register_new_client_company" class="form-control">
                            <option value="1" {{old('register_new_client_company', setting('register_new_client_company')) == 1 ? 'selected' : ''}}>مفعل</option>
                            <option value="0" {{old('register_new_client_company', setting('register_new_client_company')) == 0 ? 'selected' : ''}}>غير مفعل</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="register_new_judger_company_individual">تسجيل عضوية محامي افراد</label>
                        <select name="register_new_vendor_individual" id="register_new_vendor_individual" class="form-control">
                            <option value="1" {{old('register_new_vendor_individual', setting('register_new_vendor_individual')) == 1 ? 'selected' : ''}}>مفعل</option>
                            <option value="0" {{old('register_new_vendor_individual', setting('register_new_vendor_individual')) == 0 ? 'selected' : ''}}>غير مفعل</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="register_new_vendor_company">تسجيل عضوية محامي شركات</label>
                        <select name="register_new_vendor_company" id="register_new_vendor_company" class="form-control">
                            <option value="1" {{old('register_new_vendor_company', setting('register_new_vendor_company')) == 1 ? 'selected' : ''}}>مفعل</option>
                            <option value="0" {{old('register_new_vendor_company', setting('register_new_vendor_company')) == 0 ? 'selected' : ''}}>غير مفعل</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="edit_documents">تعديل الوثائق</label>
                        <select name="edit_documents" id="edit_documents" class="form-control">
                            <option value="1" {{old('edit_documents', setting('edit_documents')) == 1 ? 'selected' : ''}}>مفعل</option>
                            <option value="0" {{old('edit_documents', setting('edit_documents')) == 0 ? 'selected' : ''}}>غير مفعل</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary col-md-4 mt-3 rounded">حفظ</button>
                </form>
            </div>
        </div>
    </div>
</div>

@stop