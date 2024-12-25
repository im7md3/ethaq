@extends('admin.layouts.admin')
@section('title')
    اعدادات الطلبات
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">اعدادات الطلبات</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.updateOrders') }}" method="POST" class="row w-100"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group col-md-12 mb-2 ">
                            <label class="mb-1" for="phone_verification_status">
                                الطلبات
                            </label>
                            <select name="orders" id="consulting" class="form-control">
                                <option value="1" {{old('orders', setting('orders')) == 1 ? 'selected' : ''}}>مفعل</option>
                                <option value="0" {{old('orders', setting('orders')) == 0 ? 'selected' : ''}}>غير مفعل</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 mb-2 ">
                            <label class="mb-1" for="register_new_client_individual">ضريبة العقد <span
                                    class="text-danger">(%)</span></label>
                            <input type="number" name="contract_tax" class="form-control" id=""
                                value="{{ old('contract_tax', setting('contract_tax')) }}">
                        </div>
                        <div class="form-group col-md-12 mb-2 ">
                            <label class="mb-1" for="judger_cost">تكلفة المحكم <span
                                    class="text-danger">(%)</span></label>
                            <input type="number" name="judger_cost" class="form-control" id=""
                                value="{{ old('judger_cost', setting('judger_cost')) }}">
                        </div>
                        <div class="form-group col-md-12 mb-2 ">
                            <label class="mb-1" for="judger_cost_tax">ضريبة تكلفة المحكم <span
                                    class="text-danger">(%)</span></label>
                            <input type="number" name="judger_cost_tax" class="form-control" id=""
                                value="{{ old('judger_cost_tax', setting('judger_cost_tax')) }}">
                        </div>
                        <div class="form-group col-md-12 mb-2 ">
                            <label class="mb-1" for="admin_ratio">نسبة الإدارة من العقد <span
                                    class="text-danger">(%)</span></label>
                            <input type="number" name="admin_ratio_of_contract" class="form-control" id=""
                                value="{{ old('admin_ratio_of_contract', setting('admin_ratio_of_contract')) }}">
                        </div>
                        <div class="form-group col-md-12 mb-2 ">
                            <label class="mb-1" for="admin_ratio">نسبة الإدارة من مبلغ المحكم <span
                                    class="text-danger">(%)</span></label>
                            <input type="number" name="admin_ratio_of_judger" class="form-control" id=""
                                value="{{ old('admin_ratio_of_judger', setting('admin_ratio_of_judger')) }}">
                        </div>
                        <div class="form-group col-md-12 mb-2 ">
                            <label class="mb-1" for="admin_ratio">أقل مبلغ عرض</label>
                            <input type="number" name="lowest_offer_amount" class="form-control" id=""
                                value="{{ old('lowest_offer_amount', setting('lowest_offer_amount')) }}">
                        </div>
                        <div class="form-group col-md-12 mb-2 ">
                            <label class="mb-1" for="admin_ratio">نسبة استرجاع المبلغ <span
                                    class="text-danger">(%)</span></label>
                            <input step=".1" type="number" name="refund_ratio" class="form-control" id=""
                                value="{{ old('refund_ratio', setting('refund_ratio')) }}">
                        </div>
                        <div class="form-group col-md-12 mb-2 ">
                            <label class="mb-1" for="judger_cost">شروط إلغاء الطلب</label>
                            <textarea name="cancellation_terms" class="form-control">{{ old('cancellation_terms', setting('cancellation_terms')) }}</textarea>
                        </div>
                        <div class="form-group col-md-12 mb-2 ">
                            <label class="mb-1" for="judger_cost">شروط تسليم الطلب</label>
                            <textarea name="delivery_order_terms" class="form-control">{{ old('delivery_order_terms', setting('delivery_order_terms')) }}</textarea>
                        </div>
                        <div class="form-group col-md-12 mb-2 ">
                            <label class="mb-1" for="judger_cost">شروط استرجاع المبلغ</label>
                            <textarea name="terms_of_refund" class="form-control">{{ old('terms_of_refund', setting('terms_of_refund')) }}</textarea>
                        </div>
                        <div class="form-group col-md-12 mb-2 ">
                            <label class="mb-1" for="phone_verification_status">
                                ارسال رسائل SMS بحالة الطلب
                            </label>
                            <select name="order_status_sms" id="order_status_sms" class="form-control">
                                <option value="1"
                                    {{ old('order_status_sms', setting('order_status_sms')) == 1 ? 'selected' : '' }}>مفعل
                                </option>
                                <option value="0"
                                    {{ old('order_status_sms', setting('order_status_sms')) == 0 ? 'selected' : '' }}>غير
                                    مفعل</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 mb-2 ">
                            <label class="mb-1" for="judger_cost">مدة الحكم</label>
                            <input type="number" name="objection_duration" class="form-control" value="{{ old('objection_duration', setting('objection_duration')) }}">
                        </div>
                        <button type="submit" class="btn btn-primary col-md-4 mt-3 rounded">حفظ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop
