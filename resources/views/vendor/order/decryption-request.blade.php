<div class="p-5 height-section">
    <div class="w-100 p-3">
        {{-- ******************* طلب كود التشفير من العميل ************************ --}}
        @if (!$user->HasDecoded($order->id))
        <div class="">
            <p class="m-0 text-danger">
                هذا الطلب مشفر يمكنك طلب الدخول من العميل وسيتم ارسال الكود عبر المنصة عند الموافقة
                <br>
            <div class="d-flex justify-content-end">
                <form action="{{route('vendor.decryption_request.store',$order)}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-primary ">إرسال الطلب</button>
                </form>
            </div>
            </p>
        </div>
        @endif
        @if ($user->getRequestHasCode($order->id)->count()>0 )
            <div class="alert alert-success">قام العميل بقبول طلب التشفير لهذا الطلب والكود هو {{ $user->getRequestHasCode($order->id)->first()->pivot->code }}</div>
            <form action="{{route('vendor.decryption_request.login',$order)}}" method="post">
            @csrf @method('PUT')
            <div class="d-flex align-items-center justify-content-between gap-3">
                <input class="form-control  inp-num" name="code" placeholder="كود الدخول">
                <button class="btn btn-success flex-fill">دخول</button>
            </div>
        </form>
        @elseif ($user->HasPendingDecoded($order->id))
            <div class="alert alert-info">لقد طلبت كود التشفير بالفعل, يرجى انتظار رد العميل</div>
        @elseif ($user->HasRefusedDecoded($order->id))
            <div class="alert alert-danger">لقد تم رفض طلب التشفير الخاص بك من العميل</div>
        @endif

    </div>
</div>
