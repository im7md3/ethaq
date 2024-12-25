@extends('vendor.layouts.vendor')
@section('title', 'اختيار محكم')
@push('css')
<link rel="stylesheet" href="{{ asset('front-assets/css/create-order.css') }}" />
@endpush
@section('content')
<div class="select-judgers" id="select_judger">
<h6 class="alert alert-info mb-0 mt-3 px-5 py-3 mx-auto fit-content " role="alert">
    @if(!$order->first_judger_id and $order->second_judger_id)
    يجب عليك اختيار محكم الأصيل
    @elseif(!$order->second_judger_id and $order->first_judger_id)
    يجب عليك اختيار محكم الاحتياطي
    @else
    يجب عليك اختيار محكم الأصيل أو الاحتياطي
    @endif
</h6>
    <div class="container-sm">
        <form action=" {{ route('vendor.selectJudgers.store') }}" method="POST">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}" id="">
            <input type="hidden" name="client_decision" value="pending" id="">
            <div class=" d-flex flex-column mt-2 gap-2 w-100" v-if="errors.length>0">
                <div class="alert alert-danger mb-0" v-for="(error,key) in errors" :key='key'>@{{
                    error }}</div>
            </div>
            <div class="pt-5 pb-3">
                <div class="row"
                    :class="[currentStep == 1 ? 'level-two' :'',currentStep == 2 ? 'level-three' :'',currentStep == 3 ? 'level-four' :'',currentStep == 4 ? 'level-five' :'']">
                    <div class="col-12">
                        <div class="d-flex d-flex flex-wrap flex-xxl-nowrap justify-content-center gap-0">
                            <div
                                class="d-flex flex-column-reverse flex-sm-row flex-fill align-items-end align-items-sm-start justify-content-sm-between gap-5">

                                <ul class="levels-bar align-items-baseline gap-4 text-center d-flex">
                                    <li class="active">
                                        <div class="icon">1</div>
                                        تحديد مدة التحكيم
                                    </li>
                                    <li :class="[currentStep >= 2 ? 'active' : '']">
                                        <div class="icon">2</div>
                                        اختيار المحكم الأصيل
                                    </li>
                                    <li :class="[currentStep >= 3 ? 'active' : '']">
                                        <div class="icon">2</div>
                                        اختيار المحكم الاحتياطي
                                    </li>
                                </ul>
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
                                        اختيار محكم
                                    </div>
                                    <!-- <div class="box-two">
                                        <div v-if="period" v-cloak>المدة: @{{period}}</div>
                                        <div v-if="" v-cloak>@{{currentStep}}</div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start Level 1 -->
                    <div class="col-lg-8 col-xl-9 p-0" v-show="currentStep == 1">
                        <main class="py-3">
                            <div class="container-sm py-0">
                                <div class="lable mb-0 fs-co1">يجب تحديد مدة التحكم لجميع المحكمين</div>
                                <div class="inp-text">
                                    عدد الأيام
                                    <input type="number" name="period" v-model="period" class="form-control w-100px d-inline-block h-36px" min="5">
                                    يوم
                                </div>
                                <div class="group-btn d-flex mt-5 pt-5 align-items-center justify-content-end gap-2">
                                    <a href="{{ route('vendor.orders.show', $order->hash_code) }}" class="back">الغاء
                                        <i class="fas fa-angle-right ic"></i>
                                    </a>

                                    <button type="button" class="sub d-block" @click.prevent="increaseStepOne()">
                                        متابعة وحفظ
                                        <i class="fas fa-angle-left ic"></i>
                                    </button>
                                </div>
                            </div>
                        </main>
                    </div>
                    <!-- End Level 1 -->
                    <!-- start Level 2 -->
                    <div class="col-lg-8 col-xl-9 p-0" v-show="currentStep == 2">
                        <main class="py-3">
                            <div class="container-sm py-0">
                                <div class="lable mb-3"> اختيار المحكم الأصيل</div>
                                <div class="row g-2" v-show="!first_judger_id">
                                    <div  class="col-md-6 col-lg-4 col-xl-3" v-for="(user,i) in mainJudgers" :key="user.id">

                                        <div class="exhibition_box">
                                            <div class="image_holder">
                                                    <img :src="display_file+user.photo" height="100" alt="" />
                                            </div>
                                            <div class="exhibition-name">
                                                <a href="#">@{{ user.name }}</a>
                                                <i class="fa-solid fa-circle state_online"></i>
                                            </div>
                                            <div class="visit_holder p-3 ">
                                                <a target="_blank" :href="url+'/judgers/'+user.id+'/profile'" class="btn visit_profile">
                                                    الملف الشخصي
                                                </a>
                                            </div>
                                            <div class="px-3">
                                                <input v-model="main_judger" class="inp-check" type="radio"
                                                    name="main_judger" :id="'encrypted'+user.id" :value="user.id">

                                                <input v-model="main_judger" class="inp-100" type="radio" :value="user.id">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class=""  v-show="first_judger_id">تم اختيار المحكم الأصلي بالفعل</div>

                                <div class="group-btn d-flex mt-5 pt-5 align-items-center justify-content-end gap-2">
                                    <a href="#" @click.prevent="currentStep--" class="back">العودة
                                        <i class="fas fa-angle-right ic"></i>
                                    </a>

                                    <button type="button" class="sub d-block" @click.prevent="increaseStepTwo()">
                                        متابعة وحفظ
                                        <i class="fas fa-angle-left ic"></i>
                                    </button>
                                </div>
                            </div>
                        </main>
                    </div>
                    <!-- End Level 2 -->
                    <!-- start Level 3 -->

                    <div class="col-lg-8 col-xl-9 p-0" v-show="currentStep == 3">
                        <main class="py-3">
                            <div class="container-sm py-0">
                                <div class="lable mb-3"> اختيار المحكم الاحتياطي</div>
                                <div class="row g-2" v-show="!second_judger_id">
                                    <div  class="col-md-6 col-lg-4 col-xl-3" v-for="(user,i) in subJudgers"
                                        :key="user.id+'sub'">

                                        <div class="exhibition_box">
                                            <div class="image_holder">
                                                    <img :src="display_file+user.photo" height="100" alt="" />
                                            </div>
                                            <div class="exhibition-name">
                                                <a href="#">@{{ user.name }}</a>
                                                <i class="fa-solid fa-circle state_online"></i>
                                            </div>
                                            <div class="visit_holder p-3 ">
                                                <a target="_blank" :href="url+'/judgers/'+user.id+'/profile'" class="btn visit_profile">
                                                    الملف الشخصي
                                                </a>
                                            </div>
                                            <div class="px-3">
                                                <input v-model="sub_judger" class="inp-check" type="radio"
                                                    name="sub_judger" :id="'encrypted'+user.id+'sub'" :value="user.id">
                                                <input v-model="sub_judger" class="inp-100" type="radio" :value="user.id">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="" v-show="second_judger_id">تم اختيار المحكم الاحتياطي بالفعل</div>

                                <div class="group-btn d-flex mt-5 pt-5 align-items-center justify-content-end gap-2">
                                    <a href="#" @click.prevent="currentStep--" class="back">العودة
                                        <i class="fas fa-angle-right ic"></i>
                                    </a>

                                    <button type="submit" class="sub d-block">
                                        ارسال
                                        <i class="fas fa-angle-left ic"></i>
                                    </button>
                                </div>
                            </div>
                        </main>
                    </div>
                    <!-- End Level 3 -->

                </div>
            </div>
        </form>
    </div>
</div>

@endsection
@push('js')
<script>
    let app = new Vue({
        el: "#select_judger",
        data:{
            currentStep:1,
            period:'',
            judgers:[],
            main_judger:'',
            sub_judger:[],
            errors:[],
            display_file:'',
            url:'',
            first_judger_id:'',
            second_judger_id:'',
            ClientAcceptedSelectedJudgers:[]
        },
        methods:{
            increaseStepOne(){
          this.errors=[]
          if(!this.period){
            this.errors.push('يجب تحديد مدة التحكيم')
          }
          if(+this.period <= 4 && this.period ){
            this.errors.push('يجب ان يكون عدد الأيام لا يقل عن {5} خمسة أيام')
          } else if(this.errors.length==0) {
              this.currentStep++
              this.errors=[]
          }
    },
        increaseStepTwo(){
          this.errors=[]
          if(!this.main_judger){
              this.errors.push('يجب  تحديد المحكم الأصيل ')
            }
            if(this.errors.length==0){
                this.currentStep++
                this.errors=[]
            }
        },
        },
        computed:{
            mainJudgers(){
                return this.judgers.filter(e=>e.id!=this.sub_judger)
            },
            subJudgers(){
                return this.judgers.filter(e=>e.id!=this.main_judger)
            },


        },
        mounted(){
            this.display_file="{{ display_file('/') }}"
            this.url="{{ url('/') }}"
            this.judgers={!! $judgers !!}
            this.first_judger_id="{{ $order->first_judger_id }}"
            this.second_judger_id="{{ $order->second_judger_id }}"
            this.ClientAcceptedSelectedJudgers={!! $order->ClientAcceptedSelectedJudgers !!};
            if(this.first_judger_id){
                this.currentStep=3
                this.main_judger=this.first_judger_id
                this.period=this.ClientAcceptedSelectedJudgers[0].pivot.period
            }
            if(this.second_judger_id){
                this.currentStep=2
                this.sub_judger=this.second_judger_id
                this.period=this.ClientAcceptedSelectedJudgers[0].pivot.period
            }
        }
    });

</script>
@endpush
