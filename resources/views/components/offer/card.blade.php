<div class="box-order">
    <div class="info">
        <img class="photo" src="{{ display_file($offer->vendor->photo) }}" alt="" />
        <p class="name mb-0">{{ $offer->vendor->name }}</p>
        <h6 class="main-color fw-bold">محامي</h6>
    </div>
    <div class="content">
        <div class="header-box d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="item">
                    {{ $offer->created_at->diffForHumans() }}
                </div>
                <div class="item">
                    <i class="fa-solid fa-calendar-day"></i>
                    مدة التسليم: {{ $offer->period }}
                </div>
                @notJudger
                <div class="item text-danger">
                    <i class="fa-solid fa-coins"></i> المبلغ: {{ $offer->amount }} SR
                </div>
                <div class="item">
                <i class="fa-regular fa-comment-dots"></i>
                    سرعة الرد: {{  $offer->response_speed }}
                </div>
                @endnotJudger

            </div>
            <div class="btn_blue">
                عرض
            </div>
        </div>
        <div class="hr my-3"></div>
        <div class="content-order">
            <div class="mb-2">
                <h6 class="blue-color m-0 fw-bold">حصر الأعمال المطلوب تنفيذها تفصيلا</h6>
                <div class="line-text mb-2">
                    {{ $offer->works }}
                </div>
            </div>
            <div class="mb-2">
                <h6 class="blue-color m-0 fw-bold">حصر المتطلبات والمستندات الاساسية للأعمال مطلوب تنفيذها</h6>
                <div class="line-text mb-2">
                    {{ $offer->documents }}

                </div>
            </div>
            <div class="mb-2">
                <h6 class="blue-color m-0 fw-bold">طريقة ووسائل تنفيذ الأعمال</h6>
                {!! $offer->ExecutionMethodEncoded !!}
            </div>
        </div>
        <div class="mt-2">
            <x-attachments :files="$offer->files" :voices="$offer->voices"></x-attachments>
        </div>
        <div class="footer-box">
            @client
            @if(!$order->offer_id)
            <form action="{{ route('client.offer.update',$offer) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="order_id" value="{{ $order->id }}" id="">
                <input type="hidden" name="vendor_id" value="{{ $offer->vendor->id }}" id="">
                <button type="submit" class="btn btn-success">قبول العرض</button>
            </form>
            @endif
            @endclient
            @if($order->offer_id==$offer->id)
            <div class="badge-info badge-green text-fs-1 fw-normal py-1">
                تم قبول العرض
            </div>
            @endif
        </div>
    </div>
</div>
