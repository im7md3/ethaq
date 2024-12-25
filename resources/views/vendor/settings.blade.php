@extends('vendor.layouts.vendor')
@section('title', 'الاعدادات')
@section('content')


<section class="padding-mobile" id="app">
    <input type="text" name="" id="inp-op">
    <div class="container-fluid">
        <div class="row app">
            <div class="col-lg-2 d-none d-lg-block">
                <div class="slide-user">
                    <div class="card-slide">
                        <img class="img-user" src="{{ display_file($user->photo) }}" alt="" />
                        <h6 class="">
                            {{ $user->name }}
                        </h6>
                        <div class="badge-info">{{ $user->occupation?->name ?? 'لا يوجد' }}</div>
                    </div>
                    <div class="card-slide">
                        <div class="fs-6 main-color">
                            بريد الالكتروني:
                        </div>
                        <!-- <div>{{ $user->email }}
                            {{-- <div class="icon-done mx-auto">
                                <i class="fas fa-check"></i>
                            </div> --}}
                        </div> -->
                    </div>
                    <div class="card-slide">
                        <div class="fs-6 main-color">
                            الهاتف:
                        </div>
                        <!-- <div>
                            {{ $user->phone }}
                            <div class="icon-done mx-auto">
                                <i class="fas fa-check"></i>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="app-content">
                    <div class="header-content-box">
                        <div class="container ">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <a href="/" class="btn-icon justify-content-between">
                                        <div class="icon">
                                            <img src="{{ asset('front-assets') }}/img/global/i-home.png" alt="">
                                        </div>
                                    </a>
                                    <div class="title">
                                        <i class="fa-solid fa-angles-left"></i>
                                    </div>
                                    <div class="title"> الملف الشخصي</div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <form action="{{ route('vendor.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $user->id }}" id="">
                        <div class="container pb-5">
                            <div class="row row-gap-24">
                                <div class="col-xl-3">
                                    <div class="mb-1"> رقم الجوال <span class="text-danger">*</span></div>
                                    <input type="text" name="phone" class="main-inp" value="{{ $user->phone }}" readonly>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-1">الأسم (باللغة العربية فقط)<span class="text-danger">*</span></div>
                                    <input type="text" @input="inpNameArbi($event)" id="txtArabic" name="name"
                                        class="main-inp" value="{{ $user->name ? $user->name : old('name') }}">
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-1"> البريد الالكتروني <span class="text-danger">*</span></div>
                                    <input type="text" @input="inpEnglish($event)" id="txtEnglish" name="email"
                                        class="main-inp" value="{{ $user->email ? $user->email : old('email') }}">
                                </div>
                                <!-- <div class="col-xl-3">
                                    <div class="mb-1"> الجنس <span class="text-danger">*</span></div>
                                    <select name="gender" class="form-control">
                                        <option value="">أختر الجنس</option>
                                        <option value="male" {{ old('gender')=='male' ?'selected':'' }} {{ $user->
                                            gender=='male'?'selected':'' }}>
                                            ذكر</option>
                                        <option value="female" {{ old('gender')=='female' ?'selected':'' }} {{ $user->
                                            gender=='female'?'selected':'' }}>
                                            انثى
                                        </option>
                                    </select>
                                </div> -->

                                <div class="col-xl-3">
                                    <div class="mb-1"> رقم الهوية <span class="text-danger">*</span></div>
                                    <input type="number" name="id_number"
                                        onKeyPress="if(this.value.length==10) return false;" class="main-inp"
                                        value="{{ $user->id_number ? $user->id_number : old('id_number') }}">
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-1"> تاريخ انتهاء الهوية <span class="text-danger">*</span></div>
                                    <input readonly type="date" name="id_end" class="main-inp"
                                        value="{{ old('id_end',$user->id_end)}}">
                                </div>
                                {{-- <div class="col-xl-3">
                                    <div class="mb-1"> المدينة <span class="text-danger">*</span></div>
                                    <input type="text" name="city_name" class="main-inp"
                                        value="{{ old('city_name',$user->city_name)}}">
                                </div> --}}
                                <div class="col-xl-3">
                                    <div class="mb-1"> تاريخ الميلاد <span class="text-danger">*</span></div>
                                    <input readonly type="date" name="birthdate" class="main-inp"
                                        value="{{ old('birthdate',$user->birthdate)}}">
                                </div>
                                <!-- <div class="col-xl-3">
                                    <div class="mb-1"> تاريخ الميلاد <span class="text-danger">*</span></div>
                                    <input type="date" name="birthdate" class="main-inp"
                                        value="{{ $user->birthdate ? $user->birthdate : old('birthdate') }}">
                                </div> -->
                                {{-- <div class="col-xl-3">
                                    <div class="mb-1"> الدولة <span class="text-danger">*</span></div>
                                    <div class="box-inp">
                                        <select name="country_id" class="inp">
                                            <option value="">أختر الدولة</option>
                                            @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ $country->
                                                id==$user->country_id?'selected':''
                                                }}>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="icon">
                                            <i class="fas fa-angle-down"></i>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-xl-3">
                                    <div class="mb-1"> المدينة الحالية <span class="text-danger">*</span></div>
                                    <div class="box-inp">
                                        <select name="city_id" class="inp">
                                            <option value="">أختر المدينة</option>
                                            @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" {{ $city->id == ($user->city_id ? $user->city_id
                                                : old('city_id')) ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="icon">
                                            <i class="fas fa-angle-down"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3">
                                    <div class="mb-1"> الصورة الشخصية</div>
                                    <div class="box-inp">
                                        <span v-if="imgUser.length >= 1">
                                            تم رفع الصورة
                                        </span>
                                        <span v-else>
                                            رفع الصورة
                                        </span>
                                        <input type="file"  name="image" id="" class="inp">
                                        <div class="icon" :class="[imgUser.length >= 1 ? 'icon-success' : '']">
                                            <i class="fas fa-check" v-if="imgUser.length >= 1"></i>
                                            <i class="fa-solid fa-upload" v-else></i>
                                        </div>
                                    </div>
                                    <span class="icon-done mt-2" v-if="imgUser.length >= 1">
                                        <i class="fas fa-check"></i>
                                    </span>
                                </div>

                                <div class="col-xl-3">
                                    <div class="mb-1"> المهنة <span class="text-danger">*</span></div>
                                    <div class="box-inp">
                                        <select name="occupation_id" class="inp">
                                            <option value="">أختر المهنة</option>
                                            @foreach ($occupations as $occupation)
                                            <option value="{{ $occupation->id }}" {{ $occupation->id ==
                                                ($user->occupation_id ? $user->occupation_id : old('occupation_id')) ?
                                                'selected' : '' }}>
                                                {{ $occupation->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="icon">
                                            <i class="fas fa-angle-down"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-1"> سنوات الخبرة <span class="text-danger">*</span></div>
                                    <input type="number" max="99" onKeyPress="if(this.value.length==2) return false;"
                                        placeholder="سنوات الخبرة" name="years_of_experience" class="main-inp"
                                        value="{{ $user->years_of_experience ? $user->years_of_experience : old('years_of_experience') }}">
                                </div>

                                <div class="col-xl-3">
                                    <div class="mb-1"> المؤهل <span class="text-danger">*</span></div>
                                    <div class="box-inp">
                                        <select name="qualification_id" class="inp">
                                            <option value="">أختر المؤهل</option>
                                            @foreach ($qualifications as $qualification)
                                            <option value="{{ $qualification->id }}" {{ $qualification->id ==
                                                ($user->qualification_id ? $user->qualification_id :
                                                old('qualification_id')) ? 'selected' : '' }}>
                                                {{ $qualification->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="icon">
                                            <i class="fas fa-angle-down"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-1"> التخصص <span class="text-danger">*</span></div>
                                    <div class="box-inp">
                                        <select name="specialty_id" class="inp">
                                            <option value="">أختر التخصص</option>
                                            @foreach ($specialties as $specialty)
                                            <option value="{{ $specialty->id }}" {{ $specialty->id == ($user->specialty_id ?
                                                $user->specialty_id : old('specialty_id')) ? 'selected' : '' }}>
                                                {{ $specialty->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="icon">
                                            <i class="fas fa-angle-down"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-1"> البنك <span class="text-danger">*</span></div>
                                    <div class="box-inp">
                                        <select name="bank_id" class="inp">
                                            <option value="">أختر البنك</option>
                                            @foreach ($banks as $bank)
                                            <option value="{{ $bank->id }}" {{ $bank->id == ($user->bank_id ?
                                                $user->bank_id : old('bank_id')) ? 'selected' : '' }}>
                                                {{ $bank->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="icon">
                                            <i class="fas fa-angle-down"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-1"> الحساب البنكي </div>
                                    <div class="inp-bank">
                                        <input type="number" placeholder="الحساب البنكي" name="bank_account"
                                            class="main-inp "
                                            value="{{ $user->bank_account ? $user->bank_account : old('bank_account') }}">

                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-1"> مبلغ الاستشارة  <span class="text-danger">*</span></div>
                                    <div class="inp-bank">
                                        <input type="number" placeholder="مبلغ الاستشارة" name="consulting_price"
                                            class="main-inp "
                                            value="{{  $user->consulting_price }}" min="{{ setting('minimum_amount_for_consultation') }}">

                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-1"> الأقسام<span class="text-danger">*</span></div>
                                    @foreach ($departments as $dep)
                                    <label for="">
                                        <input type="checkbox" name="departments[]" value="{{ $dep->name }}" {{
                                            in_array($dep->name,$my_departments->toArray())?'checked':''
                                        }}>
                                        {{ $dep->name }}
                                    </label>
                                    @endforeach
                                </div>
                                <div class="col-xl-12">
                                    <div class="mb-1"> النبذة الشخصية <span class="text-danger">*</span></div>
                                    <textarea placeholder="النبذة الشخصية" name="bio" maxlength="1000"
                                        class="main-inp h-100">{{ $user->bio ? $user->bio : old('bio') }}</textarea>
                                </div>
                                <div class="col-12 mt-4">
                                </div>
                                <div class="col-12 mt-3 d-flex justify-content-end">
                                    <button class="inp-sub ms-0" type="submit">
                                        حفظ
                                        <i class="fas fa-angle-left"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>
                    @include('front.documents')

                    {{-- <div class="col-12 col-xl-2 d-flex align-items-end">
                        <div class="alert alert-warning d-flex align-items-center gap-2 mb-0 p-2" role="alert">
                            <i class="fa-solid fa-file fa-flip" style="--fa-animation-duration: 3s;"></i>
                            <div>
                                اكمال رفع المستندات
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <label for="" class="small-label">رقم الرخصة</label>
                        <input type="number" class="main-inp" name="name" id="">
                    </div>
                    <div class="col-xl-3">
                        <label for="" class="small-label">الرخصة</label>
                        <input type="file" class="main-inp" name="license" id="">
                    </div>
                    <div class="col-xl-3">
                        <label for="" class="small-label">تاريخ الانتهاء</label>
                        <input type="date" class="main-inp" name="end_at" id=""
                            min="{{ now()->addDay()->format('Y-m-d') }}">
                    </div>
                    <div class="col-xl-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">ارسال</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    let app = new Vue({
            el: "#app",
            data: {
                departments: [],
                imgUser:'',
                main_department_id: "",
                departmentId: "",
                my_departments: "",
                subDepartmentName: []
            },
            methods: {
        inpArbi($event) {
                        var formControl =$event.target;
                        var valueBeforeChange = formControl.value;
                        var allowedValue = ' ';
                        allowedValue += "ياىآبپتثجچهخدذرزژسشصضطظعغفقکگلمنوحكةؤءئأإ"; //or any collection in any language you want
                        allowedValue += "0123456789"; // normal digits
                    allowedValue += "۰۱۲۳۴۵۶۷۸۹"; // arabic digits
                    allowedValue += "،.=+-)(*&%$#@!/_.|"; // allowed symbols

                var valueAfterChange = '';
                for (var i = 0; i < valueBeforeChange.length; i++) {
                    var tmpChar = valueBeforeChange.charAt(i);
                    if (allowedValue.indexOf(tmpChar) > -1) valueAfterChange = valueAfterChange + tmpChar;
                }
                formControl.value = valueAfterChange;
                if (document.querySelector('#inp-op')) {
                    document.querySelector('#inp-op').focus();
                    formControl.focus();
                }
            },
        inpNameArbi($event) {
                        var formControl =$event.target;
                        var valueBeforeChange = formControl.value;
                        var allowedValue = ' ';
                        allowedValue += "ياىآبپتثجچهخدذرزژسشصضطظعغفقکگلمنوحكةؤءئأإ"; //or any collection in any language you want

                var valueAfterChange = '';
                for (var i = 0; i < valueBeforeChange.length; i++) {
                    var tmpChar = valueBeforeChange.charAt(i);
                    if (allowedValue.indexOf(tmpChar) > -1) valueAfterChange = valueAfterChange + tmpChar;
                }
                formControl.value = valueAfterChange;
                if (document.querySelector('#inp-op')) {
                    document.querySelector('#inp-op').focus();
                    formControl.focus();
                }
            },
        inpEnglish($event) {
                        var formControl =$event.target;
                        var valueBeforeChange = formControl.value;
                        var allowedValue = ' ';
                        allowedValue += "qwertyuiopasdfghjklzxcvbnm"; //or any collection in any language you want
                        allowedValue += "0123456789"; // normal digits
                    allowedValue += "۰۱۲۳۴۵۶۷۸۹"; // arabic digits
                    allowedValue += "،.=+-)(*&%$#@!/_.|"; // allowed symbols

                var valueAfterChange = '';
                for (var i = 0; i < valueBeforeChange.length; i++) {
                    var tmpChar = valueBeforeChange.charAt(i);
                    if (allowedValue.indexOf(tmpChar) > -1) valueAfterChange = valueAfterChange + tmpChar;
                }
                formControl.value = valueAfterChange;
                if (document.querySelector('#inp-op')) {
                    document.querySelector('#inp-op').focus();
                    formControl.focus();
                }
            },
    },
            computed: {

            },

            mounted() {
                this.departments = {!! $departments !!}
                this.main_department_id = {{ $mainDepartmentId }}
                this.my_departments = {!! $my_departments !!}

            }

        });
</script>
@endsection
