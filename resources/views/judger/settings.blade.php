@extends('judger.layouts.judger')
@section('title', 'الاعدادات')
@section('content')

    <section class="" id="app">
    <input type="text" name="" id="inp-op">
        <div class="container-fluid ">
            <div class="row app">
                <div class="col-lg-2 d-none d-lg-block ">
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
                            <!-- <div>
                                @if ($user->email)
                                    {{ $user->email }}
                                    <div class="icon-done mx-auto">
                                        <i class="fas fa-check"></i>
                                    </div>
                                @else
                                    <div class=" mx-auto">
                                        <i class="fas fa-times-circle text-danger" style="font-size: 17px"></i>
                                    </div>
                                @endif
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
                <div class="col-lg-10 ">
                    <div class="app-content">
                        <div class="header-content-box">
                            <div class="container">
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
                        <form action="{{ route('judger.settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $user->id }}" id="">
                            <div class="container pb-5">
                                <div class="row row-gap-24">
                                    <div class="col-xl-3">
                                        <div class="mb-1"> رقم الجوال <span class="text-danger">*</span></div>
                                        <input type="text" name="phone" class="main-inp"
                                            value="{{ old('phone', $user->phone) }}" readonly>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="mb-1">الأسم (باللغة العربية فقط)<span class="text-danger">*</span></div>
                                        <input type="text" id="txtArabic" @input="inpNameArbi($event)" name="name" class="main-inp"
                                            value="{{ old('name', $user->name) }}">
                                    </div>


                                    <div class="col-xl-3">
                                        <div class="mb-1"> البريد الالكتروني <span class="text-danger">*</span></div>
                                        <input type="text" @input="inpEnglish($event)" id="txtEnglish" name="email" class="main-inp"
                                            value="{{ old('email', $user->email) }}">
                                    </div>
                                    <!-- <div class="col-xl-3">
                                        <div class="mb-1"> الجنس <span class="text-danger">*</span></div>
                                        <select name="gender" class="form-control">
                                            <option value="">أختر الجنس</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}
                                                {{ $user->gender == 'male' ? 'selected' : '' }}>ذكر</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}
                                                {{ $user->gender == 'female' ? 'selected' : '' }}>انثى</option>
                                        </select>
                                    </div> -->

                                    <div class="col-xl-3">
                                        <div class="mb-1"> رقم الهوية <span class="text-danger">*</span></div>
                                        <input type="number" name="id_number"
                                            onKeyPress="if(this.value.length==10) return false;" class="main-inp"
                                            value="{{ old('id_number', $user->id_number) }}">
                                    </div>
                                    <!-- <div class="col-xl-3">
                                        <div class="mb-1"> تاريخ الميلاد <span class="text-danger">*</span></div>
                                        <input type="date" name="birthdate" class="main-inp" value="{{ $user->birthdate }}">
                                    </div>-->
                                    <div class="col-xl-3">
                                        <div class="mb-1"> المدينة الحالية <span class="text-danger">*</span></div>
                                        <div class="box-inp">
                                            <select name="city_id" class="inp">
                                                <option value="">أختر المدينة</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}"
                                                        {{ old('city_id') == $city->id ? 'selected' : '' }}
                                                        {{ $city->id == $user->city_id ? 'selected' : '' }}>
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
                                        <div class="mb-1"> الصورة الشخصية </div>
                                        <div class="box-inp">
                                                    <span v-if="imgUser.length >= 1">
                                                        تم رفع الصورة
                                                    </span>
                                                    <span v-else>
                                                        رفع الصورة
                                                    </span>
                                        <input type="file" v-model="imgUser" name="image" id="" class="inp">
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
                                                    <option value="{{ $occupation->id }}"
                                                        {{ old('occupation_id') == $occupation->id ? 'selected' : '' }}
                                                        {{ $occupation->id == $user->occupation_id ? 'selected' : '' }}>
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
                                        <input type="number"  max="99" onKeyPress="if(this.value.length==2) return false;" placeholder="سنوات الخبرة" name="years_of_experience"
                                            class="main-inp"
                                            value="{{ old('years_of_experience', $user->years_of_experience) }}">
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="mb-1"> المؤهل <span class="text-danger">*</span></div>
                                        <div class="box-inp">
                                            <select name="qualification_id" class="inp">
                                                <option value="">أختر المؤهل</option>
                                                @foreach ($qualifications as $qualification)
                                                    <option value="{{ $qualification->id }}"
                                                        {{ old('qualification_id') == $qualification->id ? 'selected' : '' }}
                                                        {{ $qualification->id == $user->qualification_id ? 'selected' : '' }}>
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
                                                    <option value="{{ $specialty->id }}"
                                                        {{ old('specialty_id') == $specialty->id ? 'selected' : '' }}
                                                        {{ $specialty->id == $user->specialty_id ? 'selected' : '' }}>
                                                        {{ $specialty->name }}</option>
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
                                            <input type="number" max="999999999999999" onKeyPress="if(this.value.length==15) return false;"
                                                placeholder="الحساب البنكي" name="bank_account" class="main-inp "
                                                value="{{ old('bank_account', $user->bank_account) }}">

                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="mb-1"> القسم الرئيسي <span class="text-danger">*</span></div>
                                        <div class="box-inp">
                                            <select name="" class="inp">
                                                <option value="">أختر القسم</option>
                                                <option v-for="main in main_departments" :key="main.id"
                                                    :value="main.id" selected>@{{ main.name }}</option>
                                            </select>
                                            <div class="icon">
                                                <i class="fas fa-angle-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="mb-1">نوع الخدمات المقدمة<span class="text-danger">*</span></div>
                                        <div class="box-inp">

                                            <a href="#collapse-choices1" class="w-100 h-100 collapse-choices inp"
                                                type="button" data-bs-toggle="collapse" data-bs-target="#collapse-choices1"
                                                aria-expanded="false" aria-controls="collapseExample">
                                                <span v-if="my_departments.length <= 0">اختر قسم</span>
                                                <span v-for="(e,i) in my_departments" :key="i">
                                                    @{{ getDepartName(e) }}
                                                </span>
                                            </a>
                                            <div class="collapse  collapse-choices-card" id="collapse-choices1">
                                                <div class="card card-body">
                                                    <label for="" v-for="sub in sub_departments"
                                                        :key="sub.id">
                                                        <input type="checkbox" name="departments[]" :value="sub.id"
                                                            v-model="my_departments" />
                                                        @{{ sub.name }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-angle-down"></i>
                                            </div>
                                        </div>
                                        <!-- <div class="box-inp">
                                            <select name="" class="inp" v-model='main_department_id'>
                                                <option value="">أختر القسم</option>
                                                <option v-for="sub in sub_departments" :key="sub.id"
                                                    :value="sub.id">@{{ sub.name }}</option>
                                            </select>
                                            <div class="icon">
                                                <i class="fas fa-angle-down"></i>
                                            </div>
                                        </div> -->
                                    </div>
                                    {{-- <div class="col-xl-3">
                                <div class="mb-1"> التخصصات القانونية <span class="text-danger">*</span></div>
                                    <label for="" v-for="third in third_departments" :key="third.id">
                                    <input type="checkbox" v-model="my_departments" name="departments[]" :value="third.id">
                                        @{{ third.name }}
                                </label>
                            </div> --}}
                            <div class="col-12 px-0">
                            </div>
                                    <div class="col-xl-12">
                                        <div class="mb-1"> النبذة الشخصية <span class="text-danger">*</span></div>
                                        <textarea placeholder="النبذة الشخصية" name="bio" class="main-inp h-100"   maxlength="1000">{{ $user->bio }}</textarea>
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

            },
            methods: {
                getDepartName(id) {
                    return this.sub_departments.find(e => e.id == id).name
                },
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
                main_departments() {
                    return this.departments.filter(e => e.id == '1')
                },
                sub_departments() {
                    return this.departments.filter(e => e.parent == '1')
                },
                /* third_departments(){
                    return this.departments.filter(e=>e.parent==this.main_department_id)
                }, */
            },

            mounted() {
                this.departments = {!! $departments !!}
                this.main_department_id = {{ $mainDepartmentId }}
                this.my_departments = {!! $my_departments !!}

            }

        });
    </script>
@endsection
