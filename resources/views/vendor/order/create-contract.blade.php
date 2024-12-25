@extends('vendor.layouts.vendor')
@section('title','إنشاء عقد جديد')
@push('css')
<link rel="stylesheet" href="{{ asset('front-assets/css/create-contract.css') }}" />
@endpush
@section('content')

<section class="height-section py-5" id="create-contract-app">
    <div class="container">
        <p class="text-secondary mb-3">
            إدارة العقود &#62; إنشاء عقد جديد
        </p>
        <div class="bg-white create p-4">
            <div class="row align-items-center">
                <div class="col-md-3 text-center mb-5 mb-md-0 text-md-end">
                    <h4 class="text-black-50">إنشاء عقد جديد للطلب رقم (
                        {{ $order->id }}
                        )</h4>
                </div>
                <div class="col md-9 text-center ">
                    <ul :class="[step == 2 ? 'level-2' : '' , step == 3 ? 'level-3' : '']">
                        <li>1</li>
                        <li>2</li>
                        <li>3</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="type bg-white p-4">
            <div class="" v-if="errors.length>0">
                <div class="alert alert-danger" v-for="(error,key) in errors" :key='key'>@{{ error }}</div>
            </div>
            <div class="" v-if="errors2.length>0">
                <div class="alert alert-danger" v-for="(error,key) in errors2" :key='key'>@{{ error }}</div>
            </div>
            <form action="{{ route('vendor.contracts.store') }}" method="post">
                @csrf
                @if(request('parent'))
                <input type="hidden" name="parent" value="{{ request('parent') }}" id="">
                @endif
                <input type="hidden" name="order_id" value="{{ $order->id }}" id="">
                <input type="hidden" name="vendor_id" value="{{ $order->vendor->id }}" id="">
                <div class="stage-one" v-show="step === 1">
                    <h4 class="text-center text-md-end mt-3 mb-4">
                        حدد نوع العقد
                    </h4>

                    <div class="lang">
                        <div class="box">
                            <div class="d-flex flex-column">
                                <h6 class="mb-3">
                                    أختر لغة العقد
                                    <span class="text-danger">*</span>
                                </h6>
                                <div class="d-flex flex-row flex-wrap flex-sm-nowrap">
                                    <div>
                                        <input type="radio" require name="lang" v-model="lang" value="ar-en"
                                            id="ar-en" />
                                        <label for="ar-en"><i class="fas check fa-circle-check"></i>عربية و
                                            إنجليزية</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="lang" v-model="lang" value="ar" id="ar" />
                                        <label for="ar"><i class="fas check fa-circle-check"></i>العربية فقط</label>
                                    </div>
                                </div>
                            </div>
                            <div class="box mb-0 flex-column">
                                <h6 class="mb-0">
                                    أختار نوع التقويم الرائيسي
                                    <span class="text-danger">*</span>
                                </h6>
                                <div>
                                    <input type="radio" name="calender" v-model="calender" value="meladi" id="ad" />
                                    <label for="ad" style="padding: 2.3px;"><i
                                            class="fas check fa-circle-check"></i>ميلادي
                                        <br>
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" name="calender" v-model="calender" value="hijri" id="ad" />
                                    <label for="ad" style="padding: 2.3px;"><i
                                            class="fas check fa-circle-check"></i>هجري
                                        <br>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" buttons mt-5 flex-column flex-md-row d-flex justify-content-center gap-3">
                        <button @click.prevent="increaseStep()" class="next submit">التالي
                        </button>
                    </div>
                </div>
                <div class="stage-two mb-4" v-show="step === 2">
                    <h4 class="text-center text-md-end mt-3 mb-4">أدخل تفاصيل العقد</h4>
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="box-one box row">
                                <div class="card-box col-md-6">
                                    <h6><span @click.prevent="closeCard($event)" class="char">-</span>بيانات العميل
                                        (الطرف
                                        الأول) </h6>
                                    <div class="box-form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="label">أسم العميل</p>
                                                <input type="text" class="form-control info" disabled
                                                    value="{{ $order->client->name }}" id="">
                                            </div>
                                            <div class="col-md-6">
                                                <p class="label">رقم الجوال</p>
                                                <input type="text" class="form-control info" disabled
                                                    value="{{ $order->client->phone }}" id="">
                                            </div>
                                            <div class="col-md-6">
                                                <p class="label">رقم الهوية</p>
                                                <input type="text" class="form-control info" disabled
                                                    value="{{ $order->client->id_number }}" id="">
                                            </div>
                                            <div class="col-md-6">
                                                <p class="label">الجنسية</p>
                                                <input type="text" class="form-control info" disabled
                                                    value="{{ $order->client->country?->name }}" id="">
                                            </div>
                                            <span class="col-md-6">
                                                <p class="label">عنوان العميل</p>
                                                <input type="text" class="form-control info" disabled value="كل المدن"
                                                    value="{{ $order->client->address }}" id="">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-box col-md-6">
                                    <h6><span class="char" @click.prevent="closeCard($event)">-</span>بيانات مقدم الخدمة
                                        (الطرف الثاني) </h6>
                                    <div class="box-form d-flex flex-column flex-lg-row gap-3">
                                        <div class="w-100 w-lg-50">
                                            <span class="d-inline-block ">
                                                <p class="label">أسم مقدم الخدمة</p>
                                                <input type="text" class="form-control info" disabled
                                                    value="{{ $order->vendor->name }}" id="">
                                            </span>
                                            <div class="col-md-6">
                                                <p class="label">الجنسية</p>
                                                <input type="text" class="form-control info" disabled
                                                    value="{{ $order->vendor->country?->name }}" id="">
                                            </div>
                                            @if( $order->vendor->membership=='company' )
                                            <span class="d-inline-block">
                                                <p class="label">رقم السجل التجاري</p>
                                                <input type="text" class="form-control info" disabled
                                                    value="{{ $order->vendor->commercial?->name }}" id="">
                                            </span>
                                            @endif
                                            <span class="d-inline-block ">
                                                <p class="label"> الترخيص</p>
                                                <input type="text" class="form-control info" disabled
                                                    value="{{ $order->vendor->license?->name }}" id="">
                                            </span>
                                            {{-- <span class="d-inline-block ">
                                                <p class="label"> القسم الرئيسي / الفرعي</p>
                                                <p class="info presenter-section">
                                                    <input type="text" class="form-control info" disabled
                                                        value="{{ $order->vendor->maindepartment?->name }}" id=""> --}}

                                                </p>
                                            </span>
                                            <p class="label">عنوان مقدم الخدمة</p>
                                            <input type="text" class="form-control info" disabled
                                                value="{{ $order->vendor->address }}" id="">
                                        </div>
                                        <div class="w-100 w-lg-50">
                                            <span class="d-inline-block ">
                                                <p class="label">رقم الجوال</p>
                                                <input type="text" class="form-control info" disabled
                                                    value="{{ $order->vendor->phone }}" id="">
                                            </span>

                                            <span class="d-inline-block ">
                                                <p class="label">رقم الهوية</p>
                                                <input type="text" class="form-control info" disabled
                                                    value="{{ $order->vendor->id_number }}" id="">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @if ($order->first_judger_id or $order->secone_judger_id)
                                <div class="card-box col-md-6">
                                    <h6><span class="char" @click.prevent="closeCard($event)">-</span>بيانات المحكم
                                        (الطرف
                                        الثالث) </h6>
                                    @if ($order->first_judger_id)
                                    <div class="box-form d-flex flex-column flex-lg-row">
                                        <div>
                                            <span class="d-inline-block ms-3">
                                                <p class="label">أسم المحكم</p>
                                                <input type="text" class="form-control info" disabled
                                                    value="{{ $order->firstJudger->name }}" id="">
                                            </span>
                                            <span class="d-inline-block ms-3">
                                                <p class="label">رقم الجوال</p>
                                                <input type="text" class="form-control info" disabled
                                                    value="{{ $order->firstJudger->phone }}" id="">
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="label">الجنسية</p>
                                            <input type="text" class="form-control info" disabled
                                                value="{{ $order->firstJudger->country?->name }}" id="">
                                        </div>
                                        <div class="">
                                            <span class="d-inline-block ">
                                                <p class="label">رقم الهوية</p>
                                                <input type="text" class="form-control info" disabled
                                                    value="{{ $order->firstJudger->id_number }}" id="">
                                            </span>

                                            <span class="d-inline-block ">
                                                <p class="label">عنوان المحكم</p>
                                                <input type="text" class="form-control info" disabled
                                                    value="{{ $order->firstJudger->address }}" id="">
                                            </span>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($order->secone_judger_id)
                                    <div class="box-form d-flex flex-column flex-lg-row">
                                        <div>
                                            <span class="d-inline-block ms-3">
                                                <p class="label">أسم المحكم</p>
                                                <input type="text" class="form-control info" disabled
                                                    value="{{ $order->secondJudger->name }}" id="">
                                            </span>
                                            <span class="d-inline-block ms-3">
                                                <p class="label">رقم الجوال</p>
                                                <input type="text" class="form-control info" disabled
                                                    value="{{ $order->secondJudger->phone }}" id="">
                                            </span>
                                            <div class="col-md-6">
                                                <p class="label">الجنسية</p>
                                                <input type="text" class="form-control info" disabled
                                                    value="{{ $order->secondJudger->country?->name }}" id="">
                                            </div>
                                        </div>
                                        <div class="">
                                            <span class="d-inline-block ">
                                                <p class="label">رقم الهوية</p>
                                                <input type="text" class="form-control info" disabled
                                                    value="{{ $order->secondJudger->id_number }}" id="">
                                            </span>

                                            <span class="d-inline-block ">
                                                <p class="label">عنوان المحكم</p>
                                                <input type="text" class="form-control info" disabled
                                                    value="{{ $order->secondJudger->address }}" id="">
                                            </span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @endif
                                <div class="card-box col-md-6">
                                    <h6><span class="char" @click.prevent="closeCard($event)">-</span>بيانات العقد </h6>
                                    <div class="box-form">
                                        <p class="label">مدة العقد </p>
                                        <input class="form-control" type="number" name="days"
                                            value="{{ $order->activeOffer->days }}" readonly>
                                        <hr>
                                        <p class="label text-black-50">المزايا المالية</p>
                                        <p class="label">المبلغ الاساسي</p>
                                        <input type="text" readonly class="mb-2 form-control" name="amount"
                                            value="{{ $order->activeOffer->amount }}" placeholder="المبلغ الاساسي ">
                                        <div class="">
                                            <p class="label">
                                                مدة الاجابة والرد من قبل العميل
                                                <span class="text-danger">*</span>
                                            </p>

                                            <input type="text" class="mb-2 form-control" name="client_period"
                                                v-model="client_period" placeholder="">
                                        </div>
                                        <div class="">
                                            <p class="label">
                                                مدة الاجابة والرد من قبل المحامي
                                                <span class="text-danger">*</span>
                                            </p>
                                            <input type="text" class="mb-2 form-control" name="vendor_period"
                                                v-model="vendor_period" placeholder="">
                                        </div>
                                        <div class="">
                                            <p class="label">
                                                مدة الاجابة والرد من قبل المحكم
                                                <span class="text-danger">*</span>
                                            </p>
                                            <input type="text" class="mb-2 form-control" name="judger_period"
                                                v-model="judger_period" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-box col-md-6">
                                    <h6><span class="char" @click.prevent="closeCard($event)">-</span>بيانات اضافية
                                    </h6>
                                    <div class="box-form">
                                        <h6 class="bg-success text-white p-2 rounded w-100 mb-1 text-center"> الأعمال
                                            المطلوب تنفيذها
                                            <span class="">*</span>
                                        </h6>
                                        <div class="parent-form-add  ">
                                            <div class="d-flex">
                                                <div class="position-relative w-100 par-texarea">
                                                    <textarea class="form-control" oninput="countText()"
                                                        placeholder="اكتب تعليقك هنا " maxlength="2000" name="actions"
                                                        v-model='actions'></textarea>
                                                    <div class="count-area position-absolute" id="Inquiry-count">2000 /0
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <hr>

                                        <h6 class="bg-success text-white p-2 rounded w-100 mb-1 text-center">
                                            المستندات المطلوب تقديمها
                                            <span class="">*</span>
                                        </h6>
                                        <div class="parent-form-add  ">
                                            <div class="d-flex">
                                                <div class="position-relative w-100 par-texarea">
                                                    <textarea class="form-control" oninput="countText()"
                                                        placeholder="اكتب تعليقك هنا " maxlength="2000"
                                                        v-model='documents' name="documents"></textarea>
                                                    <div class="count-area position-absolute" id="Inquiry-count">2000 /0
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <hr>

                                        <h6 class="bg-success text-white p-2 rounded w-100 mb-1 text-center">
                                            طريقة تنفيذ الأعمال
                                            <span class="">*</span>
                                        </h6>
                                        <div class="parent-form-add  ">
                                            <div class="d-flex">
                                                <div class="position-relative w-100 par-texarea">
                                                    <textarea class="form-control" oninput="countText()"
                                                        placeholder="اكتب تعليقك هنا " maxlength="2000"
                                                        v-model='business_execution'
                                                        name="business_execution"></textarea>
                                                    <div class="count-area position-absolute" id="Inquiry-count">2000 /0
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" buttons flex-column flex-md-row d-flex justify-content-center gap-3">
                        <button @click.prevent="step--" type="button" class="back">السابق</button>
                        <button @click.prevent="increaseStep2()" type="button" class="next submit">التالي</button>
                    </div>
                </div>
                <div class="stage-three" v-show="step === 3">
                    <div class="container">
                        <div class="col-12">
                            <div class="box-two box">
                                <div class="card-box">
                                    <h6 class="d-flex justify-content-between align-items-center">
                                        <div><span class="char" @click.prevent="closeCard($event)">-</span>
                                            مراجعة العقد </div>
                                    </h6>
                                    <div class="box-form">
                                        <textarea v-show='false' name="content"
                                            class="form-control"> <x-contracts.stage3></x-contracts.stage3></textarea>
                                        <x-contracts.stage3></x-contracts.stage3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" buttons flex-column flex-md-row d-flex justify-content-center gap-3">
                        <button @click.prevent="step--" type="button" class="back">السابق</button>
                        <button type="submit" class="next submit">حفظ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</section>
<script>
    var contract_app = new Vue({
            el: '#create-contract-app',
            data: {
                step: 1,
                errors:[],
                errors2:[],
                lang:'',
                calender:'',
                client_period:'',
                judger_period:'',
                vendor_period:'',
                actions:'',
                documents:'',
                business_execution:'',
                today:'',
                date:'',
                client:'',
                vendor:'',
                judger:'',
                days:'',
                amount:'',
            },
            methods: {
                closeCard($event) {
                    $event.target.closest(".card-box").classList.toggle("open");
                    if ( $event.target.closest(".card-box").classList.contains("open")) {
                        $event.target.textContent = "+";
                    } else {
                        $event.target.textContent = "-";
                    }
                },
                increaseStep(){
          this.errors=[]
          if(!this.lang){
            this.errors.push('يجب اختيار لغة العقد')
          }
          if(!this.calender){
            this.errors.push('يجب اختيار نوع التقويم الرائيسي')
          }
          if(this.errors.length==0){
            this.step++
          }
        },
                increaseStep2(){
          this.errors2=[]

          if(!this.client_period){
            this.errors2.push('يجب كتابة مدة الاجابة والرد من قبل العميل')
          }
          if(!this.vendor_period){
            this.errors2.push('يجب كتابة مدة الاجابة والرد من قبل المحامي')
          }
          if(!this.judger_period){
            this.errors2.push('يجب كتابة مدة الاجابة والرد من قبل المحكم')
          }
          if(!this.actions){
            this.errors2.push('يجب كتابة الاىعمال المطلوب تنفيذها')
          }
          if(!this.documents){
            this.errors2.push('يجب كتابة المستندات المطلوب تقديمها ')
          }
          if(!this.business_execution){
            this.errors2.push('يجب كتابة طريقة تنفيذ الأعمال ')
          }
          if(this.errors2.length==0){
            this.step++
          }
        }
            },
            mounted() {
                this.today="{{ today()->translatedFormat('D') }}"
                this.date="{{ today()->format('Y-m-d') }}"
                this.client="{{ $order->client->name }}"
                this.vendor="{{ $order->vendor->name }}"
                this.judger="{{ $order->firstJudger?->name }}"
                this.days="{{ $order->activeOffer->days }}"
                this.amount="{{ $order->activeOffer->amount }}"
                this.documents="{{ $order->activeOffer->documents }}"
                this.actions="{{ $order->activeOffer->works }}"
                this.business_execution="{{ $order->activeOffer->ExecutionMethodEncoded }}"
            }
        })
</script>
@endsection