@client
<div class="col-xl-3">
    <div class="slide-order">
        <a href="{{ route('client.orders.show', $order->hash_code) }}" class="btn-slide">
            الصفحة الرئيسية للطلب
        </a>
        @if ($order->encrypted)
        <a href="{{ route('client.decryption_request.index', $order->hash_code) }}" class="btn-slide">
            طلبات فتح التشفير
            @if($order->DecryptionRequests()->where('status','pending')->count() >0)
            <div class="lg-badge ">{{ $order->DecryptionRequests()->where('status','pending')->count() }}</div>
            @endif
        </a>
        @endif

        
        @if ($order->contract)
        <a target="_blank" href="{{ route('client.contracts.show', $order->hash_code) }}" class="btn-slide">
            العقد المتفق عليه
        </a>
        <a href="{{ route('client.documents', $order->hash_code) }}" class="btn-slide">
            المستندات المطلوبة
            <div class="lg-badge ">{{ $order->documents_count }}</div>
        </a>
        <a href="{{ route('client.events', $order->hash_code) }}" class="btn-slide">
            الأعمال المنفذة
            <div class="lg-badge ">{{ $order->events_count }}</div>
        </a>
        {{-- @if (!$order->without_judgers)
        <a href="{{ route('client.objection', $order->hash_code) }}" class="btn-slide">
            الإحالة إلى التحكيم
            @if($order->objection_id)
            <div class="lg-badge ">1</div>
            @else
            <div class="lg-badge ">0</div>
            @endif
        </a>
        @endif --}}
        <a href="{{ route('client.invoices.orderInvoices', $order->hash_code) }}" class="btn-slide">
            الفواتير
            <div class="lg-badge ">{{ $order->invoices_count }}</div>
        </a>
        <a href="{{ route('client.orders.log', $order->hash_code) }}" class="btn-slide">
            ملف الطلب الإلكتروني
        </a>
        @endif
    </div>
</div>
@endclient
@vendor
<div class="col-xl-3 mb-3">
    <div class="slide-order">
        <a href="{{ route('vendor.orders.show', $order->hash_code) }}" class="btn-slide">
            الصفحة الرئيسية للطلب
        </a>
        @if (!$order->HasUnpaidInvoices and $order->contract)
        <a target="_blank" href="{{ route('vendor.contracts.show', $order->hash_code) }}" class="btn-slide">
            العقد المتفق عليه
        </a>
        <a  href="{{ route('vendor.documents', $order->hash_code) }}" class="btn-slide">
            المستندات المطلوبة
            <div class="lg-badge ">{{ $order->documents_count }}</div>
        </a>
        <a href="{{ route('vendor.events', $order->hash_code) }}" class="btn-slide">
            الأعمال المنفذة
            <div class="lg-badge ">{{ $order->events_count }}</div>
        </a>
       {{--  @if (!$order->without_judgers)
        <a href="{{ route('vendor.objection', $order->hash_code) }}" class="btn-slide">
            الإحالة إلى التحكيم
            @if($order->objection_id)
            <div class="lg-badge ">1</div>
            @else
            <div class="lg-badge ">0</div>
            @endif
        </a>
        @endif --}}

        <a href="{{ route('vendor.invoices.orderInvoices', $order->hash_code) }}" class="btn-slide">
            الفواتير
            <div class="lg-badge ">{{ $order->invoices_count }}</div>
        </a>
        <a href="{{ route('vendor.orders.log', $order->hash_code) }}" class="btn-slide">
            ملف الطلب الإلكتروني
        </a>
        @endif
    </div>
</div>
@endvendor


@judger
<div class="col-xl-3">
    @if($order->objection_id)
    <div class="slide-order">
        @if ($order->contract)
        <a href="{{ route('judger.orders.show', $order->hash_code) }}" class="btn-slide">
            الصفحة الرئيسية للطلب
        </a>
        @if($order->ActiveJudger==auth()->id())
        <a target="_blank" href="{{ route('judger.contracts.show', $order->hash_code) }}" class="btn-slide">
            العقد المتفق عليه
        </a>
        @endif
        <a href="{{ route('judger.documents', $order->hash_code) }}" class="btn-slide">
            المستندات المطلوبة
            <div class="lg-badge ">{{ $order->documents_count }}</div>
        </a>
        <a href="{{ route('judger.events', $order->hash_code) }}" class="btn-slide">
            الأعمال المنفذة
            <div class="lg-badge ">{{ $order->events_count }}</div>
        </a>
        <a href="{{ route('judger.objection', $order->hash_code) }}" class="btn-slide">
            إعداد المحكم للحكم
            @if($order->objection_id)
            <div class="lg-badge ">1</div>
            @else
            <div class="lg-badge ">0</div>
            @endif
        </a>
        <a href="{{ route('judger.invoices.orderInvoices', $order->hash_code) }}" class="btn-slide">
            الفواتير
            <div class="lg-badge ">{{ $order->invoices_count }}</div>
        </a>
        <a href="{{ route('judger.orders.log', $order->hash_code) }}" class="btn-slide">
            ملف الطلب الإلكتروني
        </a>
        @endif
    </div>
    @endif
</div>
@endjudger

@admin
<div class="col-xl-3">
    <div class="slide-order">
        @if ($order->contract)
        <a href="{{ route('admin.orders.show', $order->hash_code) }}" class="btn-slide">
            الصفحة الرئيسية للطلب
        </a>
        <a target="_blank" href="{{ route('admin.contracts.show', $order->hash_code) }}" class="btn-slide">
            العقد المتفق عليه
        </a>
        <a href="{{ route('admin.documents', $order->hash_code) }}" class="btn-slide">
            المستندات المطلوبة
            <div class="lg-badge ">{{ $order->documents_count }}</div>
        </a>
        <a href="{{ route('admin.events', $order->hash_code) }}" class="btn-slide">
            الأعمال المنفذة
            <div class="lg-badge ">{{ $order->events_count }}</div>
        </a>
        {{-- <a href="{{ route('admin.objection', $order->hash_code) }}" class="btn-slide">
            الإحالة إلى التحكيم
            <div class="lg-badge ">5</div>
        </a> --}}

        <a href="{{ route('admin.invoices.orderInvoices', $order->hash_code) }}" class="btn-slide">
            الفواتير
            <div class="lg-badge ">{{ $order->invoices_count }}</div>
        </a>
        <a href="{{ route('admin.orders.log', $order->hash_code) }}" class="btn-slide">
            ملف الطلب الإلكتروني
        </a>
        @endif
    </div>
</div>
@endadmin
