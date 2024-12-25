@extends('admin.layouts.admin')
@section('title')
اعدادات الاستشارات
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">إعدادات الاستشارات</h3>
            </div>
            <div class="card-body">
                <form action="{{route('admin.settings.updateConsulting')}}" method="POST" class="row w-100" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="phone_verification_status">
							الاستشارات
						</label>
                        <select name="consulting" id="consulting" class="form-control">
                            <option value="1" {{old('consulting', setting('consulting')) == 1 ? 'selected' : ''}}>مفعل</option>
                            <option value="0" {{old('consulting', setting('consulting')) == 0 ? 'selected' : ''}}>غير مفعل</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="free_consulting">
							الاستشارات المجانية
						</label>
                        <select name="free_consulting" id="consulting" class="form-control">
                            <option value="1" {{old('free_consulting', setting('free_consulting')) == 1 ? 'selected' : ''}}>مفعل</option>
                            <option value="0" {{old('free_consulting', setting('free_consulting')) == 0 ? 'selected' : ''}}>غير مفعل</option>
                        </select>
                    </div>
                    {{-- <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="phone_verification_status">
							عدد الاستشارات المجانية للمحامي
						</label>
                        <input type="number" name="number_free_consultations_for_vendor" class="form-control" value="{{ setting('number_free_consultations_for_vendor') }}">
                    </div> --}}
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="phone_verification_status">
							أقل مبلغ للاستشارة
						</label>
                        <input type="number" name="minimum_amount_for_consultation" class="form-control" value="{{ setting('minimum_amount_for_consultation') }}">
                    </div>
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="phone_verification_status">
							ضريبة الاستشارة
						</label>
                        <input type="number" name="tax_for_consultation" class="form-control" value="{{ setting('tax_for_consultation') }}">
                    </div>
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="phone_verification_status">
							نسبة الإدارة من مبلغ الاستشارة
						</label>
                        <input type="number" name="admin_ratio_from_consultation" class="form-control" value="{{ setting('admin_ratio_from_consultation') }}">
                    </div>
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="phone_verification_status">
							وقت الاستشارة
						</label>
                        <input type="number" name="consultation_time" class="form-control" value="{{ setting('consultation_time') }}">
                    </div>
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="phone_verification_status">
							أكبر مبلغ للاستشارة المدفوعة لاحقا
						</label>
                        <input type="number" name="pay_later_max" class="form-control" value="{{ setting('pay_later_max') }}">
                    </div>
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="judger_cost">شروط الاشتراك بخدمة الاستشارات</label>
                        <textarea  id="content" name="terms_of_consulting" class="form-control">{{ setting('terms_of_consulting') }}</textarea>
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
@stop