@extends('client.layouts.client')
@section('title','إنشاء استشارة جديدة')
@push('css')
<link rel="stylesheet" href="{{ asset('front-assets/css/create-order.css') }}" />
@endpush
@section('content')
<div class="create-consulting bg-white" id="app">
    @include('components.attach')
    <div class="container-sm">
        <input type="text" name="" id="inp-op">
        <form action="{{ route('client.consulting.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="client_id" value="{{ auth()->id() }}" id="">
            <div class="py-5 height-section-footer">
                <div class="row g-4"
                    :class="[currentStep == 1 ? 'level-two' :'',currentStep == 2 ? 'level-three' :'',currentStep == 3 ? 'level-four' :'',currentStep == 4 ? 'level-five' :'']">
                    <div class="col-12">
                        <div class="page-def-bar">
                            <h6 class="home">
                                <a href="{{ url('/') }}">الرئيسية</a>
                            </h6>
                            <div class="icon">
                                <i class="fa-solid fa-chevron-left"></i>
                            </div>
                            <h5 class="cur">استشارة جديدة</h5>
                        </div>
                    </div>
                    {{-- <div class="col-lg-4 col-xl-3 p-0 d-none d-lg-block">
                        <div class="container-sm">
                            <div class="right text-center py-3 px-3 px-lg-0">
                                <div
                                    class="type mb-2 flex-wrap justify-content-sm-start justify-content-center mt-3 d-flex align-items-center gap-3">
                                    <div class="box-one">
                                        <i class="fa-solid fa-scale-balanced"></i>
                                        المحاماة
                                    </div>
                                    <div class="box-two">
                                        <div v-if="main_department_id" v-cloak>@{{mainDepartmentName}}</div>
                                        <div v-if="departmentId" v-cloak>@{{departmentName}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-12 col-lg-3">
                        <div class="app-content">
                            <!-- Start Consultation State Level One -->
                            <div class="consultation-state">
                                <div class="box-gray py-4">
                                    <div class="img-holder">
                                        <img src="{{asset('front-assets')}}/img/global/docs-cons.png" alt="file">
                                    </div>
                                    <p class="name">إنشاء استشارة</p>
                                </div>
                                <div class="bar-icon">
                                    <i class="fa-solid fa-angles-down"></i>
                                    <i class="fa-solid fa-angles-down"></i>
                                </div>
                                <div class="box-gray">
                                    <p class="name">التفاصيل</p>
                                </div>
                                <div class="consultation-state" v-if='currentStep == 2'>
                                    <div class="bar-icon">
                                        <i class="fa-solid fa-angles-down"></i>
                                        <i class="fa-solid fa-angles-down"></i>
                                    </div>
                                    <div class="box-gray">
                                        <p class="name">الدفع</p>
                                    </div>
                                </div>
                            </div>
                            <!-- End Consultation State Level One -->


                        </div>
                    </div>

                    <div class="col-12 col-lg-9">
                        <div class="app-content">
                            <div class="col-12">
                                <div class="consultation-info">
                                    <div class="number">
                                        <p>رقم الاستشارة</p>
                                        <span>{{ $consultation_id }}</span>
                                    </div>
                                    <ul class="consultation-levels-bar">
                                        <li class="confirm" v-if="currentStep == 2">
                                            <div class="circle"><i class="fa-solid fa-check"></i></div>
                                            إختيار نوع الخدمة
                                        </li>
                                        <li class="active" v-else>
                                            <div class="circle">1</div>
                                            إختيار نوع الخدمة
                                        </li>
                                        <li :class="[currentStep >= 2 ? 'active' : '']">
                                            <div class="circle">2</div>
                                            طريقة العرض
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Start Level 1 -->
                            <main class="py-3" v-show="currentStep == 1">
                                <div class="container-sm">
                                    <div class="my-4">
                                        <!-- <div>
                                                <button class="collapse-choices" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-choices1" aria-expanded="false"
                                                    aria-controls="collapseExample">
                                                    @{{departmentName || 'اختر القسم'}}
                                                </button>
                                                <div class="collapse  collapse-choices-card" id="collapse-choices1">
                                                    <div class="card card-body">
                                                        <label for="" v-for="dep in departments" :key="dep.id">
                                                            <input type="radio" name="department_id" :value="dep.id"
                                                                v-model="departmentId" @change="searchVendors"/>
                                                            @{{ dep.name }}
                                                        </label>
                                                        <label for="">
                                                            <input type="radio" name="" value="أخرى" v-model="departmentId" />
                                                            أخرى
                                                            <input maxlength="20" @input="inpArbi($event)"
                                                                v-if="departmentId==='أخرى'" type="text" name="other_department"
                                                                id="" class="form-control w-100 h-auto"
                                                                v-model.lazy="other_department">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div> -->
                                        <div class="row g-4">
                                            <div class="col-12 col-md-8">
                                                <div class="form-cons">
                                                    <label for="">القسم الفرعي</label>
                                                    <select name="department_id" class="form-select" id=""
                                                        v-model="departmentId">
                                                        <option value="">إختر القسم الفرعي</option>
                                                        <option v-for="dep in departments" :value="dep.id"
                                                            :key="dep.id">@{{ dep.name }}</option>
                                                    </select>
                                                    <small>قم باختيار القسم المناسب للاستشارة الخاصة بك</small>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-8">
                                                <div class="form-cons">
                                                    <label class="">تفاصيل الاستشارة</label>
                                                    <div class="inp-text">
                                                        <textarea @input="inpArbi($event)" v-model.lazy="orderDetails"
                                                            class="order-details" placeholder="أكتب هنا ..." id=""
                                                            maxlength="2000" name="details"></textarea>
                                                        <div class="count-area">
                                                            @{{orderDetails.length || 0}}/2000
                                                        </div>
                                                    </div>
                                                    <small>2000 حرف كحد أقصى</small>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-8">
                                                <attach-form v-if="showContent" name='content' id="0"></attach-form>
                                            </div>
                                        </div>
                                        {{-- <div v-for="dep in departments" :key="dep.id"
                                            class="col-6 col-md-4 col-xl-3">
                                            <div class="department-btn">
                                                <input type="radio" name="department_id" :value="dep.id"
                                                    v-model="departmentId" />
                                                <img class="icon" src="{{asset('front-assets')}}/img/global/dep2.svg"
                                                    alt="" />
                                                <div class="text">@{{ dep.name }}</div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4 col-xl-3">
                                            <div class="department-btn">
                                                <input type="radio" name="" value="أخرى" v-model="departmentId" />
                                                <img class="icon" src="{{asset('admin-assets')}}/img/logo.svg" alt="" />
                                                <div class="text">أخرى</div>
                                                <input maxlength="20" @input="inpArbi($event)"
                                                    v-if="departmentId==='أخرى'" type="text" name="other_department"
                                                    id="" class="form-control inp-other w-100 h-auto"
                                                    v-model.lazy="other_department">
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="group-btn d-flex mt-5 align-items-center justify-content-start">
                                        <button type="button" class="sub d-block px-5" @click.prevent="currentStep++">
                                            التالي
                                        </button>
                                    </div>
                                </div>
                            </main>
                            <!-- End Level 1 -->
                            <!-- start Level 2 -->
                            <main class="py-3" v-show="currentStep == 2">
                                <div class="container-sm">
                                    <div class="my-4">
                                        <div class="row g-4">
                                            <div class="col-12 col-md-12">
                                                <div class="form-cons">
                                                    <label for="">طريقة عرض الاستشارة</label>
                                                    <div class="lawyers-option">
                                                        <div class="box-lawyer"
                                                            :class="[isPrivate == 'all' ? 'active' : '']">
                                                            <div class="inp-holder">
                                                                <input type="radio" name="isPrivate" v-model="isPrivate"
                                                                    value="all" name="" id="">
                                                            </div>
                                                            <div class="img-holder">
                                                                <img src="{{ asset('front-assets') }}/img/global/lawyers.png"
                                                                    alt="lawyers">
                                                            </div>
                                                            <p class="name">العرض على كل المحامين</p>
                                                        </div>
                                                        <div class="box-lawyer"
                                                            :class="[isPrivate == 'notAll' ? 'active' : '']">
                                                            <div class="inp-holder">
                                                                <input type="radio" name="isPrivate" v-model="isPrivate"
                                                                    value="notAll" name="" id="">
                                                            </div>
                                                            <div class="img-holder">
                                                                <img src="{{ asset('front-assets') }}/img/global/lawyer.png"
                                                                    alt="lawyers">
                                                            </div>
                                                            <p class="name">إختيار محامي محدد</p>
                                                        </div>
                                                    </div>
                                                    <div class="" v-if="isPrivate == 'notAll'">
                                                        <section class="select overflow-hidden pt-4">
                                                            <div class="mt-3">
                                                                <input type="search" @input="inpArbi($event)"
                                                                    v-model.lazy='name' id=""
                                                                    placeholder="ابحث عن محامي او مستشار قانوني"
                                                                    @keyup="searchVendors" />
                                                                <div class="boxes-offers row">
                                                                    <div v-for="vendor in vendors" :key="vendor.id"
                                                                        class="col-12 col-md-6 ">
                                                                        <div class="box-offer consulting">
                                                                            <div class="box-child ">
                                                                                <input type="radio" class="check"
                                                                                    name="vendor_id" :value="vendor.id"
                                                                                    v-model="vendor_id">
                                                                                <input type="radio" v-model="vendor_id"
                                                                                    :value="vendor.id"
                                                                                    class="inp-100" />
                                                                                <div class="d-flex w-100 gap-2 mb-1">
                                                                                    <div class="img-cont">
                                                                                        <img class="img-fluid"
                                                                                            :src=" image_url+vendor.photo"
                                                                                            alt="" />
                                                                                    </div>
                                                                                    <div
                                                                                        class="info-holder d-flex flex-column align-items-start">
                                                                                        <h3 class="mb-0"> @{{
                                                                                            vendor.name }}</h3>
                                                                                        <div
                                                                                            class="rate-holder d-flex align-items-center gap-2">
                                                                                            {{-- التقييم --}}
                                                                                            {{--
                                                                                            <x-consultation.evaluation
                                                                                                value="@{{ vendor.VendorConsultingTotalEvaluate }}">
                                                                                            </x-consultation.evaluation>
                                                                                            <span class="mb-1">|</span>
                                                                                            <small
                                                                                                class="mb-0 me-1">تقييم</small>
                                                                                            --}}
                                                                                        </div>
                                                                                        <div
                                                                                            class="d-flex justify-content-center  align-items-center mt-2 gap-4 small-info">
                                                                                            محامي
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="d-flex mt-3">
                                                                                    <a style="cursor: pointer !important"
                                                                                        target="_blank"
                                                                                        :href="asset_url+'clients/vendor/'+vendor.id+'/profile'"
                                                                                        class="btn-more-ac btn">
                                                                                        الاتعاب المالية
                                                                                        <br>
                                                                                        <b>@{{vendor.consulting_price??'لم يحدد سعر بعد'
                                                                                            }}</b>
                                                                                        <span
                                                                                            v-if="vendor.consulting_price">ر.س</span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </div>
                                                    <small v-else>
                                                        <img src="{{ asset('front-assets') }}/img/global/wirn.svg"
                                                            alt="">
                                                        في حال عدم اختيارك لأي محامي سوف يظهر الاستشارة لجميع المحاميين
                                                    </small>
                                                </div>
                                            </div>
                                            {{-- @if(setting('free_consulting'))
                                            <div class="col-12 col-md-8">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input to-active" type="checkbox"
                                                        name="free" v-model='free' role="switch"
                                                        id="flexSwitchCheckDefault">
                                                    <label class="form-check-label"
                                                        for="flexSwitchCheckDefault">مجانية</label>
                                                </div>
                                            </div>
                                            @endif --}}
                                        </div>
                                    </div>
                                    <!-- @include('components.attach')
                                        <attach-form v-if="currentStep == 2" name='content' id="1"></attach-form> -->
                                    <!-- <div class=" d-flex flex-column gap-2 w-100" v-if="errors.length>0">
                                            <div class="alert alert-danger mb-0" v-for="(error,key) in errors" :key='key'>@{{ error }}</div>
                                        </div> -->
                                    <div
                                        class="group-btn mt-3 d-flex mt-0 me-auto ms-0 align-items-center justify-content-end gap-2">
                                        <button class="back ms-1" @click.prevent="currentStep--">
                                            العودة
                                            <i class="fas fa-angle-right ic"></i>
                                        </button>
                                        <button type="submit" class="sub">
                                            نشر الاستشارة الان
                                            <i class="fas fa-angle-left ic"></i>
                                        </button>

                                    </div>
                                </div>
                            </main>
                            <!-- End Level 2 -->
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

<script>
    let app = new Vue({
    el: "#app",
    data: {
        currentStep:1,
        errors:[],
        vendors:[],
        name:"",
        departments:[],
        main_department_id:"",
        departmentId:"",
        orderDetails:"",
        durationIsNegotiable:"",
        isPrivate:"notAll",
        cities:[],
        selected_cities:[],
        vendor_id:[],
        archive:"",
        encrypt:"",
        other_department:"",
        asset_url:"",
        image_url:"",
        showContent: false,
        free:false
    },
    computed:{
        departmentName(){
            if(this.departmentId && typeof(this.departmentId)=='number'){
                return this.departments.find(e=>e.id==this.departmentId).name
            }else{
                return this.other_department
            }
        }
    },
    watch:{
        free: function (val){
            axios.get(`/api/client/vendors-search`,{ params: { name: this.name,cons:true,free:this.free?true:false } }).then(r => {
                    this.vendors=r.data
                })
        }
    },
    methods: {
        searchVendors(){
                axios.get(`/api/client/vendors-search`,{ params: { name: this.name,cons:true,free:this.free?true:false,consulting_department_id:this.departmentId } }).then(r => {
                    this.vendors=r.data
                })
        },
        getCityName(id){
            return this.cities.find(e=>e.id==id).name
        },
        increaseStep(){
          this.errors=[]
          if(!this.orderDetails){
            this.errors.push('يجب   كتابة تفاصيل الاستشارة ')
          }
          if(this.errors.length==0){
            this.currentStep++
          }
        },
        inpArbi($event) {
                        var formControl =$event.target;
                        var valueBeforeChange = formControl.value;
                        var allowedValue = ' ';
                        allowedValue += "ياىآبپتثجچهخدذرزژسشصضطظعغفقکگلمنوحكةؤءئأإ"; //or any collection in any language you want
                        allowedValue += "0123456789"; // normal digits
                    allowedValue += "۰۱۲۳۴۵۶۷۸۹"; // arabic digits
                    allowedValue += "،.=+-)(*&%$#@!/_.|"; // allowed symbols
                    allowedValue += "\n";
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
        request_vendor_id="{{ $vendor_id }}"
        if(request_vendor_id){
            this.isPrivate=true
            this.vendor_id=request_vendor_id
        }
        this.vendors={!! $vendors !!}
        this.asset_url="{{ asset('/') }}"
        this.image_url="{{ display_file('/') }}"
        this.departments={!! $departments !!}
    //     this.$nextTick(() => {
    //   setTimeout(() => {
    //     this.showContent = true;
    //   }, 4000); // 4 seconds
    // });
    window.addEventListener("load", ()=> {
        this.showContent = true;
    });
    },
});

</script>
@endsection