<div class="bar_control d-flex align-items-center flex-wrap gap-2">
  <div class="time-bar flex-grow-1">
    <div class="level">
      @if ($order->status=='done')
      الطلب منفذ
      @elseif ($order->status=='cancel')
      تم إلغاء الطلب
      @elseif ($order->status=='request_done')
      لقد قام المحامي بتسليم الأعمال المتفق عليها, ويمكنك الاطلاع عليها
      @elseif ($order->status=='VerdictHasBeenIssued')
      تم إصدار حكم التحكيم
      @elseif ($order->objection_id)
      الطلب تحت الدراسة لدى المحكم
      @elseif ($order->IsEventStage)
      الطلب قيد التنفيذ
      @elseif($order->HasUnpaidInvoices)
      بانتظار تسديد الفواتير
      @elseif($order->vendor_contract)
      بانتظار قبول العميل للعقد
      {{-- @elseif(count($order->JudgerAcceptedSelectedJudgers)==2) --}}
      @elseif($order->IsReadyToSelectJudgerOrAccept)
      يتم انشاء العقد من قبل المحامي
      {{-- @elseif(count($order->PendingSelectedJudgers)>0 and count($order->ClientPendingSelectedJudgers)==0 and
      count($order->ClientAcceptedSelectedJudgers)==2)
      انتظار الموافقة من قبل المحكمين على الطلب
      @elseif(count($order->ClientPendingSelectedJudgers)>0)
      انتظار اختيارالموافقة من قبل العميل على المحكمين
      @elseif($order->IsReadyToSelectJudgerOrAccept)
      الطلب بانتظار اختيار المحكمين من قبل المحامي --}}
      @else
      الطلب بانتظار تقديم العروض من المحامين
      @endif
    </div>
  </div>
  @if($order->status!=="cancel")
  @if(auth()->user()->type=='client' || auth()->user()->type=='vendor')
  <form action="{{ route(auth()->user()->type.".order.cancel",$order) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-sm btn-danger">إلغاء الطلب</button>
  </form>
  @endif
  @endif
  @vendor
  @if($order->status=='ongoing' and $order->contract and !$order->objection_id)
  <button type="button" class="time-bar delivery_prj" data-bs-toggle="modal" data-bs-target="#order_delivery">
    تسليم الأعمال
  </button>
  @endif
  @endvendor
  @client
  {{-- @if($order->status=='open' or $order->status=='ongoing')
  <button type="button" class="time-bar close_prj" data-bs-toggle="modal" data-bs-target="#order_cancel">
    إلغاء العقد
  </button>
  @endif --}}
  @if($order->money_back and auth()->user()->invoicesForOrder($order->id,null,'paid')->count()>0)
  <button type="button" class="time-bar btn-warning" data-bs-toggle="modal" data-bs-target="#refund">
    استرجاع المبلغ
  </button>
  @endif
  @endclient
</div>
@include('components.order.pops')