@extends('judger.order.layout')
@section('order-content')
<div class="boxes-order" id="objection">
<input type="text" name="" id="inp-op">
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
                                    <span>طالب التحكيم</span>
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
                    </div>
                    {{-- ------------------------- Client Decision -------------------------- --}}
                    <div class="client_decision">
                        @if($objection->client_decision)
                        @if($objection->client_decision=='refused')
                            <div class="alert alert-danger">
                                رد العميل بالرفض
                                <p>سبب الرفض: {{ $objection->client_refused_msg }}</p>
                            </div>
                            @else
                            <div class="alert alert-success">رد العميل بالقبول</div>
                        @endif
                        @else
                        <div class="alert alert-primary">بانتظار رد العميل</div>
                        @endif
                    </div>
                    {{-- ------------------------- Vendor Decision -------------------------- --}}
                    <div class="vendor_decision">
                        @if($objection->vendor_decision)
                        @if($objection->vendor_decision=='refused')
                            <div class="alert alert-danger">رد المحامي بالرفض
                                <p>سبب الرفض: {{ $objection->vendor_refused_msg }}</p>
                            </div>
                            @else
                            <div class="alert alert-success">
                                رد المحامي بالقبول
                            </div>
                        @endif
                        @else
                        <div class="alert alert-primary">بانتظار رد المحامي</div>
                        @endif
                    </div>
                    {{-- ------------------------- Form Time -------------------------- --}}
                    @else
                    @if(!$objection->judger_judgment and $order->ActiveJudger!=$order->second_judger_id)
                    <div class="about_implementation">
                        <form action="{{ route('judger.objection.time',$objection) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="period" value="{{ $period }}" id="">
                            <div class="inp_holder mb-2 d-flex align-items-center gap-2">
                                <label for="" class="small-label">مدة التحكيم {{ $period }} أيام</label>
                                <div class="form-group">
                                    <input type="radio" name="type_time" value="new" id="new" v-model='type_time'>
                                    <label for="new">اضافة مدة جديدة</label>
                                </div>

                            </div>
                            <div v-if='type_time=="new"' class="inp_holder mb-2">
                                <label for="" class="small-label">مدة التحكيم الجديدة</label>
                                <input type="number" name="time" id="new" class="form-control" min="1"
                                    max="{{ $period }}">
                            </div>
                            <button type="submit" class="btn btn-primary">ارسال</button>
                        </form>

                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tap-2" role="tabpanel">
           {{-- محادثة الاعتراض بين جميع الاطراف --}}
            <div class="container">
                <div class="tab-content" id="myTabContent">
                    @include('components.objections.objection-talk')
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tap-3" role="tabpanel">
            @if(!$objection->judger_judgment)
            <div class="a">
                <p class="text-center mb-4">بسم الله الرحمن الرحيم</p>
                <h6 class="text-center fw-bold ">
                    <span class="d-block mb-2">
                        قرار رقم({{ $objection->id }})
                    </span>
                    الصادر للفصل في عقد المحاماة رقم({{ $order->id }})
                </h6>
                <h6 class=" mb-4 fw-bold">
                    <span class="d-block mb-2">
                        المقامة من {{ $order->client->name }} هوية رقم <span>({{ $order->client->id_number
                            }})</span>العنوان الوطني <span> {{ $order->client->address }}</span>الهاتف <span>{{
                            $order->client->phone }}</span>البريد الالكتروني <span>{{ $order->client->email }}</span>
                    </span>
                    ضد {{ $order->vendor->name }} رقم الترخيص <span>{{ $order->vendor->license->name }}</span>
                    <span>/</span>هوية رقم <span>({{ $order->vendor->id_number }})</span>وعنوانه <span>{{
                        $order->vendor->address }}</span> الهاتف <span>{{ $order->vendor->phone }}</span> البريد
                    الالكتروني <span>{{ $order->vendor->email }}</span>
                </h6>
                <p class="lh-lg">
                    الحمد لله والصلاة والسلام على رسول الله وعلى آله وصحبه اجمعين، وبعد:
                    <br>
                    بناءاً على نظام التحكيم الصادر في ٢٤/٠٥/١٤٣٣هـ الموافق ٢٠١٢/٠٤/١٦م مرسوم ملكي رقم م / ٣٤ بتاريخ ٢٤ /
                    ٥/
                    ١٤٣٣هـ
                    قرار مجلس الوزراء رقم ١٥٦ بتاريخ ١٧/ ٥/ ١٤٣٣هـ وبما تضمنه المادة الرابعة والخامسة من النظام بموافقة
                    الطرفين
                    لإخضاع العلاقة والإجراءات للائحة التحكيمية لمنصة الموثوق وجميع ما جاء بها يطابق الأنظمة المرعية في
                    المملكة
                    العربية السعودية.
                    <br>
                    ففي يوم ({{ today()->translatedFormat('D') }}) {{ today()->format('Y-m-d') }} الموافق {{
                    today()->format('Y-m-d') }}
                    بعد النظر في النزاع رقم ({{ $order->id }}) صدر قرار من
                    المحكم ({{ $order->firstJudger->name }} / الهوية: {{ $order->firstJudger->id_number }} / العنوان: {{
                    $order->firstJudger->address }} / المؤهل: {{ $order->firstJudger->qualification?->name }} / الهاتف:
                    {{ $order->firstJudger->phone }} / البريد: {{ $order->firstJudger->email }}) المحال ﺇﻟﻴﻪ التحكيم
                    وذلك
                    ﺇﻟﻜﺘﺮﻭﻧﻴﺎ في
                    منصة ووفق
                    ما ذكر في شرط
                    التحكيم في المادة () الواردة في عقد المحاماة المؤرخ بتاريخ {{ $order->created_at->format('Y-m-d') }}
                    المبرم بين اطراف النزاع اعلاه
                    و
                    الذي نص عليه ان :"........." والمرفق طيه في الحكم وفي منصة ايثاق, وحيث ان موضوغ النزاع في ({{
                    $order->title }})
                    وتتلخص
                    و قائعها كالاتي:
                </p>
                <br>
                <p class="mb-1">الوقائع</p>
                <div class="mb-2 d-flex align-items-center gap-1">
                    <textarea @input="inpArbi($event)" v-model.lazy="summary" name="" id="" class="form-control d-inline-block"
                        rows="3"></textarea>

                </div>

                <p class="mb-1">الأسباب</p>
                <div class="mb-2 d-flex align-items-center gap-1">
                    <textarea @input="inpArbi($event)" v-model.lazy="reasons" name="" id="" class="form-control d-inline-block"
                        rows="3"></textarea>
                </div>

                <br>
                <h6>منطوق الحكم</h6>
                <textarea @input="inpArbi($event)" v-model.lazy="judgment" id="" class="form-control"
                    style="min-height: 150px;"></textarea>
                <br>
                <p class="text-center"> وﺍﻟﻠﻪ الموفق والهادي الي سواء السبيل, وصلي ﺍﻟﻠﻪ علي نبينا محمد وعلي اله وصحبه
                    وسلم
                </p>
                <br>
                <p class="text-start">توقيع المحكم </p>
                <form action="{{ route('judger.objection.arbitration_store',$order) }}" method="POST">
                    @csrf @method('PUT')
                    <textarea v-show='false' name="judger_judgment" id="" cols="30"
                        rows="10"><x-objections.judgment :order="$order"></x-objections.judgment></textarea>
                    <button type="submit" class="btn btn-primary">إرسال</button>
                </form>
            </div>
            @else
            <button class="btn btn-sm btn-primary" @click='toPdf()'>تصدير الحكم ك pdf</button>
            <div dir="rtl" lang="ar" id="printContract">{!! $objection->judger_judgment !!}</div>
            @endif
        </div>
    </div>
</div>

@endif



@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    let objection = new Vue({
        el: "#objection",
        data:{
            show_form:false,
            type_time:'contract',
            reasons:'',
            summary:'',
            judgment:''

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
        }
    });

</script>
@endpush
@endsection
