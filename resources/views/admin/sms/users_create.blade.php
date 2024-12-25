@extends('admin.layouts.admin')
@section('title','ارسال رسالة حسب القسم')
@section('content')
<section class="" id="app">
    <div class="main-title">
        <div class="large">
            ارسال رسالة حسب المجموعة
        </div>
    </div>
    <div class="section_content content_view">
        <form action="{{ route('admin.sms.users.store') }}" method="POST">
            <div class="modal-body">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->id() }}" id="">
                <div class="form-group">
                    <label for="">العضوية</label>
                    <select name="membership" id="" class="form-control" v-model="membership">
                        <option value="">اختر العضوية</option>
                        <option value="clients">العملاء</option>
                        <option value="vendors">المحاميين</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">المجموعة</label>
                    <select name="group" id="" class="form-control" v-model="group">
                        <option value="all" selected>الكل</option>
                        <option value="active">مفعلين</option>
                        <option value="not-active">غير مفعلين</option>
                        <option value="consulting" v-if="membership=='vendors'">مشتركون في خدمة الاستشارات</option>
                        <option value="free" v-if="membership=='vendors'">مشتركون في خدمة الاستشارات المجانية</option>
                        <option value="pending_licens" v-if="membership=='vendors'">بانتظار التحقق من الرخصة</option>
                        <option value="active_licens" v-if="membership=='vendors'">الرخصة مفعلة</option>
                        <option value="no_licens" v-if="membership=='vendors'">بدون رخصة</option>
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
@push('js')
<script>
    let app = new Vue({
    el: "#app",
    data: {
        membership:'',
        group:'all'
    },
});
</script>
@endpush
@endsection