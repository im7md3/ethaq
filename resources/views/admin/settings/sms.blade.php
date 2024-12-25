@extends('admin.layouts.admin')
@section('title')
اعدادات الرسائل sms
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">اعدادات الرسائل sms</h3>
            </div>
            <div class="card-body">
                <form action="{{route('admin.settings.updateSMS')}}" method="POST" class="row w-100"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="phone_verification_status">
                            ارسال رسائل SMS
                        </label>
                        <select name="phone_verification_status" id="phone_verification_status" class="form-control">
                            <option value="1" {{old('phone_verification_status',
                                setting('phone_verification_status'))==1 ? 'selected' : '' }}>مفعل</option>
                            <option value="0" {{old('phone_verification_status',
                                setting('phone_verification_status'))==0 ? 'selected' : '' }}>غير مفعل</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12 mb-2 ">
                        <label class="mb-1" for="code_display_status">
                            إمكانية إظهار الكود
                        </label>
                        <select name="code_display_status" id="code_display_status" class="form-control">
                            <option value="1" {{old('code_display_status', setting('code_display_status'))==1
                                ? 'selected' : '' }}>مفعل</option>
                            <option value="0" {{old('code_display_status', setting('code_display_status'))==0
                                ? 'selected' : '' }}>غير مفعل</option>
                        </select>
                    </div>

                    <ul class="nav nav-tabs" id="myTab" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active" id="custom-content-below-home-tab" data-bs-toggle="pill"
                                href="#client" role="tab" aria-controls="custom-content-below-home"
                                aria-selected="true">عميل</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="custom-content-below-home-tab" data-bs-toggle="pill" href="#vendor"
                                role="tab" aria-controls="custom-content-below-home" aria-selected="true">محامي</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="custom-content-below-home-tab" data-bs-toggle="pill" href="#judger"
                                role="tab" aria-controls="custom-content-below-home" aria-selected="true">محكم</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-2" id="custom-content-below-tabContent">

                        <div class="tab-pane fade show active" id="client" role="tabpanel"
                            aria-labelledby="custom-content-below-home-tab">
                            <div class="row">
                                @foreach (config()->get('SMSpermissions.clients') as $key)
                                <div class="col-md-4">
                                    <label for="{{ 'client_'.$key }}"><input id="{{ 'client_'.$key }}" type="checkbox" class="checkbox" name="enableSMS[]" {{
                                            in_array('client_'.$key, $enableSMS) ? 'checked' : '' }}
                                            value="{{ 'client_'.$key }}"> {{__($key) }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="vendor" role="tabpanel"
                            aria-labelledby="custom-content-below-home-tab">
                            <div class="row">
                                @foreach (config()->get('SMSpermissions.vendors') as $key)
                                <div class="col-md-4">
                                    <label for="{{ 'vendor_'.$key }}"><input id="{{ 'vendor_'.$key }}" type="checkbox" class="checkbox" name="enableSMS[]" {{
                                            in_array('vendor_'.$key, $enableSMS) ? 'checked' : '' }}
                                            value="{{ 'vendor_'.$key }}"> {{__($key) }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="judger" role="tabpanel"
                            aria-labelledby="custom-content-below-home-tab">
                            <div class="row">
                                @foreach (config()->get('SMSpermissions.judgers') as $key)
                                <div class="col-md-4">
                                    <label for="{{ 'judger_'.$key }}"><input id="{{ 'judger_'.$key }}" type="checkbox" class="checkbox" name="enableSMS[]" {{
                                            in_array('judger_'.$key, $enableSMS) ? 'checked' : '' }}
                                            value="{{ 'judger_'.$key }}"> {{__($key) }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->

                    <button type="submit" class="btn btn-primary col-md-4 mt-3 rounded">حفظ</button>
                </form>
            </div>
        </div>
    </div>
</div>

@stop