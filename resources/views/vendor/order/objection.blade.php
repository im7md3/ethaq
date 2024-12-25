@extends('vendor.order.layout')
@section('order-content')
<div class="boxes-order" id="objection">
    <!-- انبوت مخفي لحل المشكله الي تسببها خاصية lazy -->
<input type="text" name="" id="inp-op">
    {{-- -------------------------- Include Attachment Form ---------------- --}}
    @include('components.attach')
    {{-- --------------------------------- Form Add Objection ---------------------}}
    @if(!$objection and $order->ShowForms)
    <button @click="show_form=!show_form" type="button" class="btn btn-danger w-25">
        إحالة إلى التحكيم
    </button>
    <form v-if='show_form' action="{{ route('vendor.objection.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        <p class="mb-0">
            أطلب أنا
            ({{ $user->name }})
             إحالة العقد
            رقم
            ({{ $order->id }})
            الى المحكم وفق ماتم
            الاتفاق عليه في العقد للفصل في محل النزاع مع
            ({{ $other->username }})
                بسبب:
        <div class="row ">
            <div class="col-12  mb-1">
                <label for="">
                    <input type="checkbox" @input="sendContent" value="عدم تسليم الأعمال وفق ماتم الاتفاق عليه" id=""
                        v-model="reasons">
                    عدم تسليم الأعمال وفق ماتم الاتفاق عليه
                </label>
            </div>
            <div class="col-12  mb-1">
                <label for="">
                    <input type="checkbox" @input="sendContent" value="عدم تسليم الأعمال في المدة المحددة المتفق عليها"
                        id="" v-model="reasons">
                    عدم تسليم الأعمال في المدة المحددة المتفق عليها
                </label>
            </div>
            <div class="col-12  mb-1">
                <label for="">
                    <input type="checkbox" @input="sendContent" value="عدم تسليم المتبقي من الأعمال المتفق عليها" id=""
                        v-model="reasons">
                    عدم تسليم المتبقي من الأعمال المتفق عليها
                </label>
            </div>

            <div class="col-12  mb-1">
                <label for="">
                    <input type="checkbox" @input="sendContent"
                        value="عدم الرد والاستجابة خلال المدة المحددة المتفق عليها" id="" v-model="reasons">
                    عدم الرد والاستجابة خلال المدة المحددة المتفق عليها
                </label>
            </div>
            <div class="col-12  mb-1">
                <label for="">
                    <input v-model="other" @input="sendContent" type="checkbox" name="" id="">
                    أخرى
                </label>
                <input type="text" v-if="other"  maxlength="200" @input="sendContent($event)"  v-model.lazy="other_text" id="" placeholder="السبب"
            class="form-control w-auto d-inline-block">
            </div>
        </div>
        </p>
        <div class="" v-if="reasons.length>0 || other_text.length>0">
        <div class="send-content inp-op">
          <x-objections.create-objection :order="$order" :other="$other" :user="$user"></x-objections.create-objection>
        </div>
        <textarea class="inp-op" name="content" id="" cols="30" rows="10">
          @{{contentTextarea}}
        </textarea>
        <button type="submit" class="btn btn-primary">إرسال</button>
      </div>
    </form>

    @endif
    {{-- ------------------------------ Display Objection ------------------------- --}}
    @if($objection)
    <ul class="nav nav-tabs main-tabs mb-3" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tap-1" type="button" role="tab"
                aria-selected="true">
                <div class="d-flex align-items-center justify-content-center gap-2">
                    طلبات الاحالة للتحكيم
                    <div class="small-badge">
                        @if($order->objection_id)
                        1
                        @else
                        0
                        @endif
                    </div>

                </div>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tap-2" type="button" role="tab"
                aria-selected="false">
                <div class="d-flex align-items-center justify-content-center gap-2">
                    طلبات المحكم
                    <div class="small-badge">
                        {{ $order->objection_talks_count }}
                    </div>
                </div>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tap-3" type="button" role="tab"
                aria-selected="false">
                <div class="d-flex align-items-center justify-content-center gap-2">
                    حكم المحكم
                    <div class="small-badge">
                        @if($objection->judger_judgment)
                        1
                        @else
                        0
                        @endif
                    </div>
                </div>
            </button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="tap-1" role="tabpanel">
            <div class="external_content">
                <div class="container">
                    {{-- ------------------------- Objection Info -------------------------- --}}
                    <p class="state mb-1">
                        حالة الاعتراض تحت الدراسة من قبل المحكم
                    </p>
                    <div class="works_box flex-column">
                        <div class="client d-flex gap-2 gap-sm-3">
                            <div class="image_holder">
                                <a href="">
                                    <h6 class="name">{{ $objection->user->type=='client'?$objection->user->username:$objection->user->name }}</h6>
                                </a>
                            </div>
                            <div class="info_text">
                                <p class="date mb-1">
                                    <span>{{ $objection->created_at }}</span>
                                </p>
                                <div class="alert alert-primary mb-0 " role="alert">
                                    <div class="line-text mb-2">
                                        {!! $objection->content !!}
                                    </div>
                                    <div class="">
                                        <x-attachments :files="$objection->files" :voices="$objection->voices"></x-attachments>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @if($objection->other_side_is_seen)
                        <div class="replays d-flex gap-3">
                            <h6 class="mb-0">{{ $other->type=='client'?$other->username:$other->name }}</h6>
                            <div class="alert alert-primary flex-grow-1 mb-0" role="alert">
                                <span class="mb-2 d-block">تم الاطلاع</span>
                                @if($objection->other_side_message)
                                <p class="mb-2">استفسار {{ $other->type=='client'?'العميل':'المحامي' }}</p>
                                <p class="mb-2">{{ $objection->other_side_message }}</p>
                                @endif
                            </div>
                        </div>
                        @endif

                    </div>
                    {{-- ------------------------- Time -------------------------- --}}
                    @if($objection->time)
                    <div class="alert alert-info">
                        <p>مدة التحكيم: {{ $objection->time }} يوم</p>
                        @if($objection->note_time)
                        <p>ملاحظات على مدة التحكيم: {{ $objection->note_time }}</p>
                        @endif
                    </div>
                    {{-- ------------------------- Client Decision -------------------------- --}}
                    @if($objection->client_decision)
                    <div class="client_decision">
                        @if($objection->client_decision=='refused')
                        <div class="alert alert-danger">رد العميل بالرفض</div>
                        <p>سبب الرفض: {{ $objection->client_refused_msg }}</p>
                        @else
                        <div class="alert alert-success">رد العميل بالقبول</div>
                        @endif
                    </div>
                    @else
                    <div class="alert alert-primary">بانتظار رد العميل</div>
                    @endif
                    {{-- ------------------------- Vendor Decision -------------------------- --}}
                    @if($objection->vendor_decision)
                    <div class="vendor_decision">
                        @if($objection->vendor_decision=='refused')
                        <div class="alert alert-danger">رد المحامي بالرفض
                            <p>سبب الرفض: {{ $objection->vendor_refused_msg }}</p>
                        </div>
                        @else
                        <div class="alert alert-success">رد المحامي بالقبول</div>
                        @endif
                    </div>
                    @else
                    <p>الرد على المدة المقترحة من قبل المحكم</p>
                    <form action="{{ route('vendor.objection.decision',$objection) }}" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="vendor_decision" value="accepted">
                        <button type="submit" class="btn btn-success">قبول</button>
                    </form>
                    <button @click='refused=!refused' class="btn btn-danger">رفض</button>
                    <form v-if="refused" action="{{ route('vendor.objection.decision',$objection) }}" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="vendor_decision" value="refused">
                        <textarea @input="inpArbi($event)" name="vendor_refused_msg" class="form-control"></textarea>
                        <button type="submit" class="btn btn-success">رفض</button>
                    </form>
                    @endif
                    @endif

                </div>

            </div>
        </div>
        <div class="tab-pane fade" id="tap-2" role="tabpanel">
            {{-- محادثة الاعتراض بين جميع الاطراف --}}
            <div class="container">
                <div class="tab-content" id="myTabContent">
                    @if($order->objection_talks_count>0 )
                    @include('components.objections.objection-talk')
                    @else
                    لم يقم المحكم بتقديم أي طلب يتعلق بالتحكيم
                    @endif
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tap-3" role="tabpanel">
            @if(!$objection->judger_judgment)
            لم يتم اصدار الحكم بعد
            @else
            <button class="btn btn-sm btn-primary" @click='toPdf()'>تصدير الحكم ك pdf</button>
            <div dir="rtl" lang="ar" id="printContract">{!! $objection->judger_judgment !!}</div>
            @if($objection->vendor_objection)
            <div class="alert alert-info">قمت بالاعتراض على الحكم</div>
            @else
            @if(now()->diffInDays($objection->judger_judgment_time) < setting('objection_duration')) <form
                action="{{ route('vendor.objection.judgment') }}" method="POST">
                @csrf
                <input type="hidden" name="objection_id" value="{{ $objection->id }}" id="">
                <textarea name="vendor_objection_reason" id="" cols="30" rows="10"></textarea>
                <button class="btn btn-sm btn-danger" type="submit">اعتراض عى الحكم</button>
                </form>
                @endif
                @endif
                @endif
        </div>
    </div>

    @endif
</div>
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    let app = new Vue({
        el: "#objection",
        data: {
    show_form: false,
    refused: false,
    other:false,
    reasons:[],
    other_text:'',
    contentTextarea:''

  },
        methods:{
            toPdf() {
        var element = document.getElementById('printContract');
        var opt = {
            margin: 0.1,
            pagebreak: { mode: ['avoid-all', 'css', 'legacy'] },
            filename: 'حكم المحكم رقم {{ $order->id }}',
            image: {
            type: 'jpeg',
            quality: 0.98
            },
            html2canvas: { scale: 2, scrollY: 0 },
            jsPDF: {
            unit: 'in',
            format: 'letter',
            orientation: 'portrait'
            }
        };
        html2pdf().set(opt).from(element).save();
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
            sendContent($event) {
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
        setTimeout(()=> {
            this.contentTextarea = document.querySelector(".send-content").innerHTML;
        }, 100);
    },
        }
    });

</script>
@endpush
@endsection

