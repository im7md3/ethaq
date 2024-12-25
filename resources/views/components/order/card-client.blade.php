<div class="box-order">
    <div class="info">
        <img class="photo" src="{{ display_file($order->client->photo) }}" alt="" />
        <p class="name">{{ $order->client->username }}</p>
    </div>
    <div class="content">
        <div class="d-flex justify-content-between">
            <div class="header-box">
                <div class="item">
                    رقم الطلب : <span class="count">{{ $order->id }}</span>

                </div>
                <div class="item">
                    <i class="fa-solid fa-calendar-day"></i>
                    {{ $order->created_at->format('Y-m-d') }}
                </div>
                @client
                <div class="item">
                    <i class="fa-solid fa-eye "></i> {{ $order->ViewsCount }}
                    مشاهدة
                </div>
                @endclient
            </div>
            @if($order->encrypted)
            {{-- @client
            <button type="button" class=" order-dis" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="يمكنك تشفير طلبك بحيث لا يظهر للمحامين سوى الاسم ونوع الخدمة ولا يمكن للمحامين قراءة التفاصيل إلا بعد إرسالك الكود للمحامي لرفع التشفير عنه"><i class="fa-solid fa-exclamation fa-shake"></i></button>
            @else
            <button type="button" class=" order-dis" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="هذا الطلب مشفر يمكنك طلب الدخول من العميل وسيتم ارسال الكود عبر المنصة عند الموافقة"><i class="fa-solid fa-exclamation fa-shake"></i></button>
            @endclient --}}
            <button type="button" class=" order-dis" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="الطلب مشفر"><i class="fa-solid fa-exclamation fa-shake"></i></button>
            @endif
        </div>
        <div class="hr my-3"></div>
        <h5 class="title-order">
            {{ $order->title }}
        </h5>
        <div class="content-order line-text">
            {{str()->limit($order->details,200)}}
        </div>
        <div class="mt-2">
            <x-attachments :files="$order->files" :voices="$order->voices"></x-attachments>
        </div>
        <div class="footer-box">

            <a href="{{ route($user->type.'.orders.show',$order->hash_code) }}"
                class="btn-icon-cr btn-gradient-blue btn">
                {{ __($order->status) }}
                <i class="fas fa-long-arrow-alt-left"></i>
            </a>
        </div>
    </div>
</div>
