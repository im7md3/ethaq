@if ($order->IsReadyToSelectJudgerOrAccept and $order->ClientPendingSelectedJudgers->count() > 0)
    <div class="modal fade" id="popup_show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title red-color">لقد تم اختيار المحكم من قبل {{ $order->vendor?->name }}</h5>
                    <a href="{{ route('client.profile') }}" class="btn-close"></a>
                </div>
                @foreach ($order->ClientPendingSelectedJudgers as $judger)
                    <div class="modal-body py-2">
                        <div
                            class="info d-flex flex-column flex-lg-row align-items-center justify-content-between flex-wrap">
                            <div class="text">
                                <p class="name text-primary">
                                    {{ $judger->pivot->type == 'main' ? 'المحكم الأصيل' : 'المحكم الاحتياطي' }}</p>
                                <p class="mb-2">الاسم: {{ $judger->name }}</p>
                                <a href="{{ route('judger.profile', $judger) }}" class="btn visit-profile btn-sm px-4">
                                    الملف الشخصي
                                    <i class="fas fa-long-arrow-alt-left"></i>
                                </a>
                                <span class="text-danger d-block mb-0 mt-3">المدة المحددة من قبل المحامي:
                                    {{ $judger->pivot->period }}
                                    أيام</span>
                            </div>
                            <div class="photo">
                                <div class="image_holder">
                                    <img src="{{ display_file($judger->photo) }}" class="circle-image-sm"
                                        alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer py-1 d-flex justify-content-end">
                        <button class="btn btn-red btn-sm px-4 text-nowrap" type="button" data-bs-toggle="collapse"
                            data-bs-target="#refuse{{ $judger->id }}" aria-expanded="false">رفض</button>
                        <form class="d-flex align-items-center gap-2"
                            action="{{ route('client.selectedJudgers.clientDecision') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="order_id" value="{{ $order->id }}" id="">
                            <input type="hidden" name="judger_id" value="{{ $judger->id }}" id="">
                            <input type="hidden" name="client_decision" value="accepted" id="">
                            <button type="submit" class="btn btn-green btn-sm px-4 text-nowrap">قبول</button>
                        </form>
                    </div>
                    <div class="collapse" id="refuse{{ $judger->id }}">
                        <div class="card card-body border-0 pt-0">
                            <form class="d-flex align-items-center gap-2"
                                action="{{ route('client.selectedJudgers.clientDecision') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="order_id" value="{{ $order->id }}" id="">
                                <input type="hidden" name="judger_id" value="{{ $judger->id }}" id="">
                                <input type="hidden" name="client_decision" value="refused" id="">
                                <input required type="text" @input="inpArbi($event)" placeholder="سبب الرفض"
                                    class="form-control w-auto" name="client_refused_msg">
                                <button type="submit" class="btn btn-red text-nowrap">رفض المحكم</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        let app = new Vue({
            el: "#popup_show",
            methods: {
                inpArbi($event) {
                    var formControl = $event.target;
                    var valueBeforeChange = formControl.value;
                    var allowedValue = ' ';
                    allowedValue +=
                    "ياىآبپتثجچهخدذرزژسشصضطظعغفقکگلمنوحكةؤءئأإ"; //or any collection in any language you want
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
            },
        });
    </script>
@endif

{{-- **************** بوباب تسديد فواتير العقد ********************* --}}
@if ($user->invoicesForOrder($order->id, 'vendor', 'unpaid')->count() > 0)
    <div class="modal fade" id="popup_show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title red-color">فاتورة جديدة</h5>
                    <a href="{{ route('client.profile') }}" class="btn-close"></a>
                </div>
                <div class="modal-body">
                    <div class="table-responsive parent_table">
                        <table class="table table-n-border sm table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">رقم</th>
                                    <th scope="col">قيمة العقد</th>
                                    <th scope="col">ضريبة القيمة المضافة {{ setting('contract_tax') }}%</th>
                                    <th scope="col">الاجمالي</th>
                                    <th>تسديد</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->invoicesForOrder($order->id, 'vendor', 'unpaid')->get() as $invoice)
                                    <tr>
                                        <td>{{ $invoice->id . ' / ' . $invoice->order_id }}</td>
                                        <td>{{ $invoice->amount }} ر.س</td>
                                        <td>{{ $invoice->tax }} ر.س</td>
                                        <td>{{ $invoice->total }} ر.س</td>
                                        <td class="d-flex align-items-center gap-1 justify-content-center">
                                            <x-payment-buttons :invoice="$invoice"></x-payment-buttons>
                                            <a target="_blank" class="btn table_btn btn-sm"
                                                href="{{ route('client.invoices.show', $invoice) }}"><i
                                                    class="fa-solid fa-eye"></i></a>
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
{{-- **************** بوباب تسديد فواتير المحكم ********************* --}}
@if ($user->invoicesForOrder($order->id, 'judger', 'unpaid')->count() > 0)
    <div class="modal fade" id="popup_show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title red-color">فاتورة جديدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive parent_table">
                        <table class="table table-n-border sm table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">رقم</th>
                                    <th scope="col">أتعاب المحكم</th>
                                    <th scope="col">ضريبة القيمة المضافة {{ setting('judger_cost_tax') }}%</th>
                                    <th scope="col">الإجمالي</th>
                                    <th>تسديد</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->invoicesForOrder($order->id, 'judger', 'unpaid')->get() as $invoice)
                                    <tr>
                                        <td>{{ $invoice->id . ' / ' . $invoice->order_id }}</td>
                                        <td>{{ $invoice->amount }} ر.س</td>
                                        <td>{{ $invoice->tax }} ر.س</td>
                                        <td>{{ $invoice->total }} ر.س</td>
                                        <td>
                                            <x-payment-buttons :invoice="$invoice"></x-payment-buttons>
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
                <div class="modal-header">
                    <h5 class="modal-title red-color">لم يقم المحامي بدفع الفاتورة بعد</h5>
                    <a href="{{ url('/') }}" class="btn btn-primary">الصفحة الرئيسية</a>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- **************** بوباب الموافقة على العقد ********************* --}}
@if ($order->vendor_contract and !$order->contract)
    <div class="modal fade" id="popup_show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title red-color">تم إنشاء العقد</h5>
                    <button type="button" onclick="document.body.classList.add('overflow-auto')" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer d-flex justify-content-end  align-items-center">
                    @if ($order->contract_file != null)
                        <a target="_blank" href="{{ display_file($order->contract_file) }}"
                            class="btn btn-green btn-sm   text-nowrap">
                            الإطلاع على العقد
                        </a>
                    @else
                        <a target="_blank" href="{{ route('client.contracts.show', $order->hash_code) }}"
                            class="btn btn-green btn-sm   text-nowrap">
                            الإطلاع على العقد
                        </a>
                    @endif


                </div>
            </div>
        </div>
    </div>
@endif
