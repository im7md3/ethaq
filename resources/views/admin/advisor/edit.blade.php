@extends('admin.layouts.admin')
@section('title','تعديل عضو')
@section('content')
<section class="" id="app">
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb bg-light p-3">
            <li href="" class="breadcrumb-item" aria-current="page">
                تعديل عضو
            </li>
        </ol>
    </nav>
    <div class="content_view">
        <form action="{{ route('admin.advisors.update',$advisor->id) }}" method="POST" enctype="multipart/form-data">
            <div class="row row-gap-24">
                @csrf
                @method('PUT')
                <input type="hidden" name="type" value="vendor" id="">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> نوع العضوية </label>
                    <select name="membership" class="form-control" v-model="membership">
                        <option value="">أختر نوع العضوية</option>
                        <option value="individual" {{ $advisor->membership=='individual'?'selected':'' }}>فردي</option>
                        <option value="company" {{ $advisor->membership=='company'?'selected':'' }}>شركة</option>
                    </select>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label">الاسم </label>
                    <input type="text" name="name" value="{{ $advisor->name }}" class="form-control">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> الجنس </label>
                    <select name="gender" class="form-control">
                        <option value="">أختر الجنس</option>
                        <option value="male" {{ $advisor->gender=='male'?'selected':'' }}>ذكر</option>
                        <option value="female" {{ $advisor->gender=='female'?'selected':'' }}>انثى</option>
                    </select>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label">تاريخ الميلاد </label>
                    <input type="date" name="birthdate" class="form-control"
                        value="{{ old('birthdate',$advisor->birthdate) }}">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label">البريد الالكتروني </label>
                    <input type="email" name="email" value="{{ $advisor->email }}" class="form-control">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> رقم الجوال </label>
                    <input type="number" name="phone" value="{{ $advisor->phone }}" class="form-control rmv-arw-inp">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> رقم الهوية </label>
                    <input type="number" name="id_number" class="form-control rmv-arw-inp"
                        value="{{ old('id_number',$advisor->id_number) }}">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> نهاية الهوية </label>
                    <input type="date" name="id_end" class="form-control rmv-arw-inp"
                        value="{{ old('id_end',$advisor->id_end) }}">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> الباسورد </label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> الصورة الشخصية </label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> الدولة </label>
                    <select name="country_id" class="form-control">
                        <option value="">أختر الدولة</option>
                        @foreach (App\Models\Country::all() as $country)
                        <option value="{{ $country->id }}" {{ $country->id==$advisor->country_id?'selected':'' }}>{{
                            $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3" v-if="type=='vendor' || type=='judger'">
                    <label for="" class="small-label"> سنوات الخبرة </label>
                    <input type="number" name="years_of_experience" max="99" class="form-control"
                        onkeypress="if(this.value.length==2) return false;" value="{{ $advisor->years_of_experience }}">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3" v-if="type=='vendor' || type=='judger'">
                    <label for="" class="small-label"> التخصص </label>
                    <select name="specialty_id" class="form-control">
                        <option value="">أختر التخصص </option>
                        @foreach (App\Models\Specialty::where('type',$advisor->type)->get() as $specialty)
                        <option value="{{ $specialty->id }}" {{ $specialty->id==$advisor->specialty_id?'selected':''
                            }}>{{
                            $specialty->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3" v-if="type=='vendor' || type=='judger'">
                    <label for="" class="small-label"> المؤهل </label>
                    <select name="qualification_id" class="form-control">
                        <option value="">أختر المؤهل</option>
                        @foreach (App\Models\Qualification::where('type',$advisor->type)->get() as $qualification)
                        <option value="{{ $qualification->id }}" {{ $qualification->
                            id==$advisor->qualification_id?'selected':'' }}>{{ $qualification->name }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> المدينة </label>
                    <select name="city_id" class="form-control">
                        <option value="">أختر المدينة</option>
                        @foreach (App\Models\City::all() as $city)
                        <option value="{{ $city->id }}" {{ $city->id==$advisor->city_id?'selected':'' }}>{{ $city->name
                            }}
                        </option>
                        @endforeach
                    </select>
                </div> --}}

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label d-block"> التخصصات القانونية <span
                            class="text-danger">*</span></label>
                    @foreach ($departments as $department)
                    <label for="">
                        <input type="checkbox" name="departments[]" value="{{ $department->name }}" {{
                            in_array($department->name,$my_departments->toArray())?'checked':''
                        }}>
                        {{ $department->name }}
                    </label>
                    @endforeach
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> إيقاف العضوية </label>
                    <select name="is_block" class="form-control">
                        <option value="">اختر حالة المستخدم</option>
                        <option value="0" {{ $advisor->is_block == 0 ?'selected':'' }}>فعال</option>
                        <option value="1" {{ $advisor->is_block == 1 ?'selected':'' }}>غير فعال</option>
                    </select>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> استقبال الرسائل </label>
                    <select name="enable_sms" class="form-control">
                        <option value="">اختر حالة استقبال الرسائل</option>
                        <option value="1" {{ $advisor->enable_sms == 1 ?'selected':'' }}>نعم</option>
                        <option value="0" {{ $advisor->enable_sms == 0 ?'selected':'' }}>لا</option>
                    </select>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> هل هو استشاري </label>
                    <select name="is_advisor" class="form-control">
                        <option value="">هل هو استشاري</option>
                        <option value="1" {{ $advisor->is_advisor == 1 ?'selected':'' }}>نعم</option>
                        <option value="0" {{ $advisor->is_advisor == 0 ?'selected':'' }}>لا</option>
                    </select>
                </div>
                {{-- <div class="col-sm-6 col-md-4 col-lg-3" v-if="membership=='company' && type=='client'">
                    <label for="" class="small-label"> اسم المسؤول </label>
                    <input type="text" name="company_name" class="form-control"
                        value="{{ old('company_name',$advisor->company_name) }}">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3" v-if="membership=='company' && type=='client'">
                    <label for="" class="small-label"> رقم المسؤول </label>
                    <input type="number" name="company_number" class="form-control"
                        value="{{ old('company_number',$advisor->company_number) }}">
                </div> --}}
                <div class="col-12">
                    <div class="mb-1"> النبذة الشخصية <span class="text-danger">*</span></div> <textarea
                        placeholder="النبذة الشخصية" name="bio" maxlength="1000"
                        class="form-control">{{ $advisor->bio }}</textarea>
                </div>
                <div class="col-12 d-flex align-items-center justify-content-center mt-3">
                    <button type="submit" class="btn btn-success">حفظ</button>
                </div>
            </div>
        </form>
        @include('admin.advisor.upload')

    </div>
</section>
@push('js')
<script>
    let app = new Vue({
    el: "#app",
    data: {
        type:'',
        membership:''
    },
    methods: {

    },
    mounted(){
        this.type='{{ $advisor->type }}'
        this.membership='{{ $advisor->membership }}'
    }

});
</script>
@endpush
@endsection