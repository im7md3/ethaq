<div class="header-content-box">
  <div class="container">
    @include('components.order.time-bar')
    <div class="row align-items-center row-gap-24 mt-2">
      <div class="col-xl-3">
        <div class="info-order d-flex flex-column gap-2">
          <div class="text-fs-3 fw-bold">
            حالة الطلب:
            <span class="badge-info text-fs-1">{{ __($order->status) }}</span>
          </div>
          <div class="text-fs-3 fw-bold">
            رقم الطلب:
            <span class="btn-icon fw-bold d-inline-block">
              <div class="icon">{{ $order->id }}</div>
            </span>
          </div>
          <div class="d-flex align-items-center gap-2">
            <!-- <a href="{{ route(auth()->user()->type.'.orders.show',$order->hash_code) }}"
              class="btn btn-secondary ">رجوع</a> -->
            @client
            @if ($order->status=='open')
            <!-- <form action="{{ route('client.orders.update_status',$order) }}" method="POST">
              @csrf @method('PUT')
              <input type="hidden" name="encrypted" value="{{ $order->encrypted?0:1 }}" id="">
              <button type="submit" class="btn {{ $order->encrypted?'btn-green':'btn-red' }}">{{
                $order->encrypted?'إلغاء تشفير الطلب':'تشفير الطلب' }}</button>
            </form> -->
            @endif
            @if($order->status=='archive')
            <form action="{{ route('client.orders.update_status',$order) }}" method="POST">
              @csrf @method('PUT')
              <input type="hidden" name="status" value="open" id="">
              <button type="submit" class="btn btn-green btn-sm">فتح الطلب</button>
            </form>
            @endif
            @endclient
          </div>

          <a href="/" class="btn-icon text-main">
            <div class="icon p-3">
              <img src="http://127.0.0.1:8000/front-assets/img/global/i-home.png" alt="">
            </div>
            الرئيسية
          </a>
        </div>
      </div>
      <div class="col-xl-9">
        <div class="bar-steps">
          <div class="step active">
            <div class="icon ">
              <i class="fa-solid fa-percent"></i>
            </div>
            الاطلاع وتقديم العروض
          </div>
          @if(!$order->without_judgers)
          <div class="step {{ $order->is_ready_to_select_judger_or_accept?'active':'' }}">
            <div class="icon">
              <i class="fa-solid fa-user-tie"></i>
            </div>
            اختيار محكم
          </div>
          @endif
          <div class="step {{ $order->IsReadyToContract?'active':'' }}"">
              <div class=" icon">
            <i class="fa-solid fa-file-lines"></i>
          </div>
          الاتفاق (العرض)
        </div>
        <div class="step {{ $order->contract?'active':'' }}">
          <div class="icon">
            <i class="fa-solid fa-handshake"></i>
          </div>
          التنفيذ
        </div>
        <div class="step {{ $order->status=='done'?'active':'' }}">
          <div class="icon">
            <i class="fa-solid fa-clipboard-check"></i>
          </div>
          الانتهاء
        </div>
      </div>
    </div>

  </div>
</div>
</div>
