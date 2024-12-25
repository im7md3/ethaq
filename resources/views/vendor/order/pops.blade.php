{{-- **************** بوباب اختيار محكم ********************* --}}
@if ($order->IsReadyToSelectJudgerOrAccept and $order->ClientPendingSelectedJudgers->count()==0 and
$order->ClientAcceptedSelectedJudgers->count()!=2 and !$order->contract and !$order->without_judgers)
<div class="modal fade" id="popup_show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        @if($order->ClientRefusedSelectedJudgers->count()>0)
        @foreach ($order->ClientRefusedSelectedJudgers as $judger)
        <div class="alert alert-danger">تم رفض المحكم {{ $judger->pivot->type=='main'?'الأساسي':'الاحتياطي' }} {{ $judger->name }} بسبب {{ $judger->pivot->client_refused_msg }}</div>
        @endforeach
        @endif
        @if($order->JudgerRefusedSelectedJudgers->count()>0)
        @foreach ($order->JudgerRefusedSelectedJudgers as $judger)
        <div class="alert alert-danger">رفض المحكم {{ $judger->name }} طلب التحكيم بسبب {{ $judger->pivot->judger_refused_msg }}</div>
        @endforeach
        @endif
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title red-color">
                    {{-- @if(!$order->first_judger_id and $order->second_judger_id)
                    يجب عليك اختيار محكم الأصيل
                    @elseif(!$order->second_judger_id and $order->first_judger_id)
                    يجب عليك اختيار محكم الاحتياطي
                    @else
                    يجب عليك اختيار محكم الأصيل أو الاحتياطي
                    @endif --}}

                </h5>
                <button type="button" onclick="document.body.classList.add('overflow-auto')" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-footer d-flex justify-content-end  align-items-center">
                <form method="POST" action="{{ route('vendor.without_judgers',$order) }}">
                    @csrf
                    <button class="btn btn-primary text-nowrap">لانتقال الي اعداد العقد</button>
                </form>
                {{-- <a href="{{ route('vendor.selectJudgers',$order) }}" class="btn main-btn  text-nowrap">
                    @if(!$order->first_judger_id and $order->second_judger_id)
                    اختيار محكم أصيل
                    @elseif(!$order->second_judger_id and $order->first_judger_id)
                    اختيار محكم احتياطي
                    @else
                    اختيار محكم أصيل و محكم احتياطي
                    @endif
                </a> --}}
                <!-- <a href="#" class="btn btn-primary text-nowrap">رشح محكم من الخارج</a> -->
            </div>
        </div>
    </div>
</div>
@endif

{{-- **************** بوباب تسديد فواتير المحكم ********************* --}}
@if ($user->invoicesForOrder($order->id,'judger','unpaid')->count()>0)
<div class="modal fade" id="popup_show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title red-color">فاتورة أتعاب المحكم</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive parent_table">
                    <table class="table table-n-border sm table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">رقم الفاتورة / رقم العقد</th>
                                <th scope="col">أتعاب المحكم</th>
                                <!-- <th scope="col">ضريبة المحكم {{ setting('judger_cost_tax') }}%</th> -->
                                <th scope="col">ضريبة القيمة المضافة</th>
                                <th scope="col">الإجمالي</th>
                                <th>تسديد</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->invoicesForOrder($order->id,'judger','unpaid')->get() as $invoice)

                            <tr>
                                <td>{{ $invoice->id .'/'. $order->id }}</td>
                                <td>{{ $invoice->amount }} ر.س</td>
                                <td>{{ $invoice->tax }} ر.س</td>
                                <td>{{ $invoice->total }} ر.س</td>
                                <td>
                                    <form class="d-flex align-items-center gap-1 justify-content-center"
                                        action="{{ route('clickpay.store',$invoice) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn table_btn btn-sm">سداد</button>
                                        <!-- <a href="" class="btn table_btn btn-sm"><i class="fa-solid fa-eye"></i></a> -->
                                    </form>
                                    <a target="_blank" class="btn btn-sm btn-info"
                                        href="{{ route('vendor.invoices.show',$invoice) }}">عرض</a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endif

{{-- **************** بوباب ان المستخدم الاخر لم يقم بدفع فاتورته بعد ********************* --}}
@if ($order->HasUnpaidInvoices)
<div class="modal fade" id="popup_show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2">
                <div class="close-btn text-start w-100">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-header">
                <div class="d-flex w-100 align-items-center justify-content-between">
                    <h5 class="modal-title red-color">لم يقم العميل بدفع الفاتورة بعد</h5>
                    <a href="{{ url('/') }}" class="btn btn-primary">الصفحة الرئيسية</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- **************** بوباب تم إنشاء العقد ********************* --}}
@if (($order->JudgerAcceptedSelectedJudgers->count()==2 and !$order->contract and !$order->vendor_contract) || ($order->without_judgers and !$order->contract and !$order->vendor_contract))
<div class="modal fade" id="popup_show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title red-color">تم إنشاء العقد</h5>
                <button type="button" onclick="document.body.classList.add('overflow-auto')" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer d-flex justify-content-end  align-items-center">
                <a target="_blank" href="{{ route('vendor.contracts.show',$order->hash_code) }}" class="btn btn-green  text-nowrap">
                    الإطلاع على العقد
                </a>
            </div>
        </div>
    </div>
</div>
@endif
