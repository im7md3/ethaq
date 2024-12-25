@extends('client.layouts.client')
@section('title','إنشاء طلب جديد')
@push('css')
<link rel="stylesheet" href="{{ asset('front-assets/css/create-order.css') }}" />
@endpush
@section('content')
<div class="" id="app">
    <div class="container-sm">
        <input type="text" name="" id="inp-op">
        <form action="{{ route('client.orders.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="client_id" value="{{ auth()->id() }}" id="">
            <div class="py-5 height-section-footer">
                <div class="row"
                    :class="[currentStep == 1 ? 'level-two' :'',currentStep == 2 ? 'level-three' :'',currentStep == 3 ? 'level-three' :'',currentStep == 4 ? 'level-five' :'']">
                    <div class="col-12">
                        <div class="d-flex d-flex flex-wrap flex-xxl-nowrap justify-content-center gap-0">
                            <div
                                class="d-flex flex-column-reverse flex-sm-row flex-fill align-items-end align-items-sm-start justify-content-sm-between gap-5">
                                <div class="num-order text-center fs-6">
                                    رقم الطلب
                                    <div class="btn-i">{{ $order_id }}</div>
                                </div>
                                <ul class="levels-bar align-items-baseline gap-4 text-center d-flex">
                                    <li class="active">
                                        <div class="icon">1</div>
                                        طريقة العرض
                                    </li>
                                    <li :class="[currentStep >= 2 ? 'active' : '']">
                                        <div class="icon">2</div>
                                        تفاصيل الطلب
                                    </li>
                                    <li :class="[currentStep >= 3 ? 'active' : '']">
                                        <div class="icon">3</div>
                                        نشر الطلب
                                    </li>
                                </ul>
                                <a href="/" class="d-flex align-items-center gap-3">
                                    <div class="btn-i">
                                        <img class="" src="{{ asset('front-assets') }}/img/global/i-home.png" alt="" />
                                    </div>
                                    <div class="title-grrey-lg">الرئيسية</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xl-3 p-0 d-none d-lg-block">
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
                    </div>

                    <!-- Start Level 1 -->
                    <div class="col-lg-8 col-xl-9 p-0" v-show="currentStep == 1">
                        <main class="py-3">
                            <div class="container-sm py-0">
                                <div class=" d-flex flex-column gap-2 w-100" v-if="errors.length>0">
                                    <div class="alert alert-danger mb-0" v-for="(error,key) in errors" :key='key'>@{{
                                        error }}</div>
                                </div>
                                <ul class="list-btn">
                                    <li :class="[main_department_id == sub.id ? 'active' : '']"
                                        v-for="sub in sub_departments" :key="sub.id">
                                        <input type="radio" @keypress.enter.prevent name="main_department_id"
                                            :value="sub.id" v-model="main_department_id"
                                            @click="activeDepartment($event)" class="second_department_id" />
                                        <div class="inp-name">@{{ sub.name }}</div>
                                    </li>

                                </ul>

                                <div v-if="main_department_id">
                                    <!-- <button class="collapse-choices" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-choices1" aria-expanded="false"
                                        aria-controls="collapseExample">
                                        @{{departmentName || 'اختر القسم'}}

                                    </button>
                                    <div class="collapse  collapse-choices-card" id="collapse-choices1">
                                        <div class="card card-body">
                                            <label for="" v-for="third in third_departments" :key="third.id">
                                                <input type="radio" @keypress.enter.prevent name="department_id"
                                                    :value="third.id" v-model="departmentId" @change="searchVendors" />
                                                @{{ third.name }}
                                            </label>
                                            <label for="">
                                                <input type="radio" @keypress.enter.prevent name="" value="أخرى"
                                                    v-model="departmentId" />
                                                أخرى
                                                <input maxlength="20" @keypress.enter.prevent @input="inpArbi($event)"
                                                    v-if="departmentId==='أخرى'" type="text" name="other_department"
                                                    id="" class="form-control w-100 h-auto"
                                                    v-model.lazy="other_department">
                                            </label>
                                        </div>
                                    </div> -->

                                    <div class="row g-4">
                                    <div v-for="third in third_departments" :key="third.id" class="col-6 col-md-4 col-xl-3">
                                        <div class="department-btn">
                                        <input type="radio" @keypress.enter.prevent name="department_id"
                                                    :value="third.id" v-model="departmentId" @change="searchVendors" />
                                                    <img class="icon" v-if="third.photo" :src="'{{asset('uploads')}}/' + third.photo" alt="" />
                                                    <img class="icon" v-else src="{{asset('admin-assets')}}/img/logo.svg" alt="" />
                                            <div class="text">@{{ third.name }}</div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4 col-xl-3">
                                        <div class="department-btn">
                                        <input type="radio" @keypress.enter.prevent name="" value="أخرى"
                                                    v-model="departmentId" />
                                            <img class="icon" src="{{asset('admin-assets')}}/img/logo.svg"
                                                alt="" />
                                            <div class="text">أخرى</div>
                                            <input maxlength="20" @keypress.enter.prevent @input="inpArbi($event)"
                                                    v-if="departmentId==='أخرى'" type="text" name="other_department"
                                                    id="" class="form-control w-100 h-auto inp-other"
                                                    v-model.lazy="other_department">
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-4">
                                    <div class="d-flex align-items-center justify-content-center gap-5">
                                        {{-- <div class="d-flex align-items-center flex-column">
                                            <button @click.prevent="isPrivate = false" class="btn-selectot selectot-one"
                                                :class="[isPrivate == false ? 'active' : '']">
                                                <img src="{{ asset('front-assets') }}/img/global/all-vendor.svg" alt=""
                                                    width="55">
                                            </button>
                                            <div class="lable mb-0">العرض على كل المحامين</div>
                                        </div> --}}
                                        <div class="d-flex align-items-center flex-column">
                                            <button @click.prevent="isPrivate = true" class="btn-selectot selectot-two"
                                                :class="[isPrivate == true ? 'active' : '']">
                                                <img src="{{ asset('front-assets') }}/img/global/select-vendor.webp"
                                                    alt="" width="100">
                                            </button>
                                            <div class="lable mb-0">اختيار محامي محدد</div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="green" />
                                <div class="" v-if="isPrivate">
                                    <section class="select overflow-hidden pt-4">
                                        <div class="">
                                            <input type="search" @input="inpArbi($event)" @keypress.enter.prevent
                                                v-model.lazy='name' id="" placeholder="بحث بالأسم"
                                                @keyup="searchVendors" />
                                            <div class="boxes-offers row">
                                                <div v-for="vendor in vendors" :key="vendor.id"
                                                    class="col-12 col-md-6 col-xl-4 col-xxl-3">
                                                    <div class="box-offer">
                                                        <div class="box-child">
                                                            <div
                                                                class="d-flex w-100 align-items-center flex-column justify-content-between  mb-1">
                                                                <div class="img-cont">
                                                                    <img class="img-fluid"
                                                                        :src=" image_url+vendor.photo" alt="" />
                                                                </div>
                                                                <input type="radio" @keypress.enter.prevent
                                                                    v-model="checkVendor" name="vendor_id"
                                                                    :value="vendor.id " class="check" />
                                                                <input type="radio" @keypress.enter.prevent
                                                                    v-model="checkVendor" :value="vendor.id"
                                                                    class="inp-100" />
                                                            </div>
                                                            <p class="mt-2 mb-1">@{{ vendor.name }}</p>
                                                            <div
                                                                class="d-flex justify-content-center  align-items-center gap-2 small-info">
                                                                <span v-if="vendor.city">
                                                                    <i class="fas fa-map-marker-alt "></i>
                                                                    @{{ vendor.city.name }}
                                                                </span>
                                                            </div>
                                                            <div
                                                                class="d-flex align-items-center justify-content-between gap-3 mt-2">
                                                                <a :href="asset_url+'clients/vendor/'+vendor.id+'/profile'"
                                                                    target="_blank" class="btn-more-ac btn">
                                                                    الملف الشخصي
                                                                    <i class="fas fa-arrow-left-long"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="btn-holder mt-3 d-flex align-items-center justify-content-end">
                                                <button @click="getMoreVendors" type="button"
                                                    class="more btn btn-sm px-5">المزيد</button>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <small v-else class="text-danger mb-2 d-block">
                                    عدم اختيار محامي محدد يظهر الطلب لجميع المحامين في المنصة
                                </small>

                                <div class="group-btn d-flex mt-4 align-items-center justify-content-end gap-2">
                                    <button class="sub" @click.prevent="increaseStepOne()">
                                        التالي
                                        <i class="fas fa-angle-left ic"></i>
                                    </button>
                                </div>
                            </div>
                        </main>
                    </div>
                    <!--  End Level 1 -->
                    <!-- Start Level 2 -->

                    <div class="col-lg-8 col-xl-9 p-0" v-show="currentStep == 2">

                        <main class="py-3">
                            <div class="container-sm">
                                <!-- Start Level Three -->
                                <div class=" d-flex flex-column gap-2 w-100" v-if="errors.length>0">
                                    <div class="alert alert-danger mb-0" v-for="(error,key) in errors" :key='key'>@{{
                                        error }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <span>
                                            <div class="lable mt-4">عنوان الطلب</div>

                                            <div class="inp-text">
                                                <input type="text" @keypress.enter.prevent @input="inpArbi($event)"
                                                    id="txtArabic" v-model.lazy="titleOrder"
                                                    placeholder="عنوان الطلب..." id="" maxlength="100" name="title" />
                                                <div class="count">
                                                    @{{titleOrder.length || 0}}/100
                                                </div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="lable">تفاصيل الطلب</div>
                                <div class="inp-text">
                                    <textarea @input="inpArbi($event)" v-model.lazy="orderDetails" class="order-details"
                                        placeholder="تفاصيل الطلب..." id="" maxlength="2000" name="details">
                                    </textarea>
                                    <div class="count-area">
                                        @{{orderDetails.length || 0}}/2000
                                    </div>
                                </div>
                                @include('components.attach')
                                <attach-form v-if="currentStep != 1" name='content' id="1"></attach-form>
                                <div class="group-btn mt-4 d-flex align-items-center justify-content-end gap-2">
                                    <button @click.prevent="currentStep--" class="back">
                                        الرجوع
                                        <i class="fas fa-angle-right ic"></i>
                                    </button>
                                    <button class="sub" @click.prevent="increaseStep()">
                                        التالي
                                        <i class="fas fa-angle-left ic"></i>
                                    </button>
                                </div>
                                <!-- End LEvel Three -->
                            </div>
                        </main>
                    </div>
                    <!-- End Level 2 -->

                    <!-- start Level 3 -->
                    <div class="col-lg-8 col-xl-9 p-0" v-show="currentStep == 3">
                        <div class="py-3" style="font-size: 14px">
                            <div class="container-sm">
                                <!-- Start Level Five -->
                                <div class="mt-3">
                                    <div class="group-btn mt-5 flex-column pt-5 d-flex  justify-content-between gap-5">
                                        <div class="d-flex flex-column mb-5 pb-5">
                                            <div class="d-flex flex-wrap justify-content-start align-items-center">
                                                <label class="btn save text-nowrap ms-2 d-flex" for="archive">
                                                    @{{archive == true ? "تم الحفظ كمسودة" : " حفظ الطلب كمسودة"}}
                                                    <i class="fa-solid fa-bookmark mx-1"></i>
                                                    <input type="checkbox" @keypress.enter.prevent class="inp-hidden"
                                                        name="status" value="archive" id="archive" v-model="archive">
                                                </label>
                                                <!-- <div class="d-flex align-items-center gap-1">
                                                    <label for="encrypted" class="text-nowrap btn"
                                                        :class="[encrypt == true ? 'btn-success' : 'btn-danger']">
                                                        @{{encrypt ==true ? "الغاء التشفير" : "تفعيل التشفير"}}
                                                        <input v-model="encrypt" @keypress.enter.prevent
                                                            class="inp-hidden" type="checkbox" name="encrypted"
                                                            id="encrypted">
                                                    </label>
                                                    <button type="button" class="order-dis " data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        data-bs-title="يمكنك تشفير طلبك بحيث لا يظهر للمحامين سوى الاسم ونوع الخدمة ولا يمكن للمحامين قراءة التفاصيل إلا بعد إرسالك الكود للمحامي لرفع التشفير عنه">
                                                        <i class="fa-solid fa-exclamation fa-shake"></i></button>
                                                </div> -->
                                            </div>
                                        </div>
                                        <div
                                            class="mt-5 group-btn d-flex flex-grow-1 mt-0 me-auto ms-0 align-items-center justify-content-end gap-2">
                                            <button class="back ms-1" @click.prevent="currentStep--">
                                                الرجوع
                                                <i class="fas fa-angle-right ic"></i>
                                            </button>
                                            <button type="submit" class="sub">
                                                نشر الطلب
                                                <i class="fas fa-angle-left ic"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Level Five -->
                            </div>
                        </div>
                    </div>
                    <!-- End Level 3 -->
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
        departments:[],
        vendors:[],
        vendors_id:[],
        name:"",
        image_url:"",
        asset_url:"",
        main_department_id:"",
        departmentId:"",
        titleOrder:"",
        orderDetails:"",
        durationIsNegotiable:"",
        isPrivate:true,
        cities:[],
        selected_cities:[],
        vendor:"",
        archive:"",
        encrypt:"",
        other_department:'',
        checkVendor:null,
    },
    computed:{
        sub_departments(){
            return this.departments.filter(e=>e.parent=='1')
        },
        third_departments(){
            return this.departments.filter(e=>e.parent==this.main_department_id)
        },
        mainDepartmentName(){
            return this.sub_departments.find(e=>e.id==this.main_department_id).name
        },
        departmentName(){
            if(this.departmentId && typeof(this.departmentId)=='number'){
                return this.third_departments.find(e=>e.id==this.departmentId).name
            }else{
                return this.other_department
            }
        }
    },

    methods: {
        setVendorsId(){
            this.vendors_id=[]
            this.vendors.forEach(v=>{
                this.vendors_id.push(v.id)
            })
        },
        searchVendors(){
                axios.get(`/api/client/vendors-search`,{ params: { name: this.name,department_id:this.departmentId } }).then(r => {
                    this.vendors=r.data
                    this.setVendorsId()
                })
        },
        getMoreVendors(){
                axios.get(`/api/client/vendors-more`,{ params: { ids: this.vendors_id } }).then(r => {
                    r.data.forEach(v=>{
                        this.vendors.push(v)
                    })
                    this.setVendorsId()
                })
        },
        activeDepartment($event) {
            document.querySelectorAll(".second_department_id").forEach(inp => {
                inp.closest("li").classList.remove("active")
            });
            $event.target.closest("li").classList.add("active")
        },
        increaseStepOne(){
          this.errors=[]
          if(!this.main_department_id){
            this.errors.push('يجب اختيار نوع الطلب')
          }
          if(!this.departmentId){
            this.errors.push('يجب اختيار قسم الطلب')
          }
          if(this.errors.length==0){
            this.currentStep++
            this.errors=[]
          }
        },
        increaseStep(){
          this.errors=[]
          if(!this.titleOrder){
            this.errors.push('يجب   كتابة عنوان الطلب ')
          }
          if(!this.orderDetails){
            this.errors.push('يجب   كتابة تفاصيل الطلب ')
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
            enter($event) {
                console.log(5);
            },
    },

    mounted(){
        this.departments={!! $departments !!}
        this.vendors={!! $vendors !!}
        this.setVendorsId()
        this.asset_url="{{ asset('/') }}"
        this.image_url="{{ display_file('/') }}"
        this.main_department_id="{{ $dep_id }}"
        this.cities={!! $cities !!}
        request_vendor_id="{{ $vendor_id }}"
        if(request_vendor_id){
            this.isPrivate=true
            this.checkVendor=request_vendor_id
        }
    }

});

</script>
@endsection
