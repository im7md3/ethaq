@extends('client.layouts.client')
@section('title','الاعدادات')
@section('content')

<section id="settings" class="">
<input type="text" name="" id="inp-op">
    <div class="container-fluid ">
        <div class="row app">
            <div class="col-lg-2 d-none d-lg-block">
                <div class="slide-user">
                    <div class="card-slide">
                            <img class="img-user" src="{{ display_file($user->photo) }}" alt="" />
                        <h6 class="">
                            {{ $user->name }}
                        </h6>
                        <div class="badge-info"> عميل</div>
                    </div>
                    <div class="card-slide">
                        <div class="fs-6 main-color">
                            بريد الالكتروني:
                        </div>
                        <div>
                        @if($user->email)
                            {{ $user->email }}
                            @endif
                        </div>
                        <!-- <div>
                            @if($user->email)
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
                            <div>
                            @if($user->phone )
                            {{ $user->phone }}
                            @endif
                            </div>
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
                    <form action="{{ route('client.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $user->id }}" id="">
                        <div class="container pb-5">
                            <div class="row row-gap-24">
                                <div class="col-xl-3">
                                    <div class="mb-1"> رقم الجوال <span class="text-danger">*</span></div>
                                    <input type="text" readonly name="phone" class="main-inp"
                                        value="{{ old('phone',$user->phone) }}">
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-1">الأسم الثلاثي (باللغة العربية فقط)<span class="text-danger">*</span></div>
                                    <input type="text" @input="inpNameArbi($event)" name="name" class="main-inp" value="{{ old('name',$user->name) }}">
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-1">الاسم المستعار (باللغة العربية فقط)<span class="text-danger">*</span></div>
                                    <input type="text" @input="inpNameArbi($event)" name="username" class="main-inp" value="{{ old('username',$user->username) }}">
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-1"> البريد الالكتروني </div>
                                    <input type="text" @input="inpEnglish($event)" name="email" class="main-inp"
                                        value="{{ old('email',$user->email) }}">
                                </div>
                                <!-- <div class="col-xl-3">
                                    <div class="mb-1"> الجنس <span class="text-danger">*</span></div>
                                    <select name="gender" class="form-control">
                                        <option value="">أختر الجنس</option>
                                        <option value="male" {{ old('gender')=='male' ?'selected':'' }} {{ $user->
                                            gender=='male'?'selected':'' }}>ذكر</option>
                                        <option value="female" {{ old('gender')=='female' ?'selected':'' }} {{ $user->
                                            gender=='female'?'selected':'' }}>انثى</option>
                                    </select>
                                </div> -->

                                <div class="col-xl-3">
                                    <div class="mb-1"> رقم الهوية <span class="text-danger">*</span></div>
                                    <input type="number"  onKeyPress="if(this.value.length==10) return false;" name="id_number" class="main-inp"
                                        value="{{ old('id_number',$user->id_number) }}">
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-1"> تاريخ انتهاء الهوية <span class="text-danger">*</span></div>
                                    <input readonly type="date" name="id_end" class="main-inp"
                                        value="{{ old('id_end',$user->id_end)}}">
                                </div>

                                <div class="col-xl-3">
                                    <div class="mb-1"> تاريخ الميلاد <span class="text-danger">*</span></div>
                                    <input  type="date" name="birthdate" class="main-inp"
                                        value="{{ old('birthdate',$user->birthdate)}}">
                                </div>
                                <!-- <div class="col-xl-3">
                                    <div class="mb-1"> تاريخ الميلاد <span class="text-danger">*</span></div>
                                    <input type="date" name="birthdate" class="main-inp"
                                        value="{{ old('birthdate',$user->birthdate) }}">
                                </div>-->
                                <div class="col-xl-3">
                                    <div class="mb-1"> المدينة الحالية </div>
                                    <div class="box-inp">
                                        <select name="city_id" class="inp">
                                            <option value="">أختر المدينة</option>
                                            @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('city_id')==$city->id?'selected':'' }} {{
                                                $city->id==$user->city_id?'selected':'' }}>{{
                                                $city->name }}</option>
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
                                        <input type="number"  max="999999999999999" onKeyPress="if(this.value.length==15) return false;"
                                            placeholder="الحساب البنكي" name="bank_account" class="main-inp "
                                            value="{{ old('bank_account',$user->bank_account) }}">

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
                                <div class="col-12 mt-3 d-flex justify-content-end">
                                    <button class="inp-sub ms-0" type="submit">
                                        حفظ
                                        <i class="fas fa-angle-left"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @clientCompany
                    @include('front.documents')
                    @endclientCompany
                </div>


            </div>
        </div>
    </div>
</section>
@endsection
@push('js')
<script>
    let app = new Vue({
    el: "#settings",
    data: {
        imgUser:'',
    },
    computed:{

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

    mounted(){

    }

});
</script>
@endpush
