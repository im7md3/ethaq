@extends('admin.order.layout')
@section('order-content')
<div class="boxes-order" id="objection">
    {{-- ------------------------------ Display Objection ------------------------- --}}
    @if($objection)
    <div class="external_content">
        <div class="container">
            {{-- ------------------------- Objection Info -------------------------- --}}
            <p class="state mb-1">
                حالة الاعتراض تحت الدراسة من قبل المحكم
            </p>
            <div class="works_box flex-column">
                <div class="client d-flex gap-3">
                    <div class="image_holder">
                        <a href="">
                            <h6 class="name">{{ $objection->user->name }}</h6>
                        </a>
                    </div>
                    <div class="info_text">
                        <p class="date mb-1">
                            <span>{{ $objection->created_at }}</span>
                        </p>
                        <div class="alert alert-primary mb-0" role="alert">
                            {{ $objection->content }}
                            <div class="">
                                @foreach ($objection->files as $file)
                                <a class="btn-border btn-sm" target="_blank" href="{{ display_file($file->path) }}">
                                    مرفق{{ $loop->iteration }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @if($objection->other_side_is_seen)
                <div class="replays d-flex gap-3">
                    <h6 class="mb-0">{{ $other->name }}</h6>
                    <div class="alert alert-primary flex-grow-1 mb-0" role="alert">
                        <span class="mb-2 d-block">تم الاطلاع</span>
                        @if($objection->other_side_message)
                        <p class="mb-2">استفسار {{ $other->type=='client'?'العميل':'المحامي' }}</p>
                        <p class="mb-2">{{ $objection->other_side_message }}</p>
                        @endif
                    </div>
                </div>
                @endif
                @if(!$objection->judger_judgment)
                <div class="area_holder">
                    <a class="btn btn-primary btn-sm"
                        href="{{ route('judger.objection.sentencing',$order->hash_code) }}">اصدار الحكم</a>
                </div>
                @else
                <div class="alert alert-info">تم إصدار الحكم</div>
                <button class="btn btn-sm btn-primary" @click='toPdf()'>تصدير الحكم ك pdf</button>
                <div  dir="rtl" lang="ar" id="printContract">{!! $objection->judger_judgment !!}</div>
                @endif
            </div>
            {{-- ------------------------- Time -------------------------- --}}
            @if($objection->time)
            <div class="alert alert-info">
                <p>مدة التنفيذ: {{ $objection->time }}</p>
                @if($objection->note_time)
                <p>ملاحظات على مدة التنفيذ: {{ $objection->note_time }}</p>
                @endif
            </div>
            {{-- ------------------------- Client Decision -------------------------- --}}
            @if($objection->client_decision)
            <div class="client_decision">
                @if($objection->client_decision=='refused')
                <div class="alert alert-danger">رد العميل بالرفض
                    <p>سبب الرفض: {{ $objection->client_refused_msg }}</p>
                </div>
                @else
                <div class="alert alert-success">رد العميل بالقبول</div>
                @endif
                @else
                <div class="alert alert-primary">بانتظار رد العميل</div>
            </div>
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
                @else
                <div class="alert alert-primary">بانتظار رد المحامي</div>
            </div>
            @endif
            {{-- ------------------------- Form Time -------------------------- --}}

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
        data:{
            show_form:false,
            type_time:'contract'
        },
        methods:{
            toPdf() {
        var element = document.getElementById('printContract');
        var opt = {
            margin: 0.1,
            pagebreak: { mode: ['avoid-all', 'css', 'legacy'] },
            filename: 'myfile.pdf',
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
    }
        }
    });

</script>
@endpush
@endsection
