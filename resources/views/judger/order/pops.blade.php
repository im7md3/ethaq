{{-- **************** بوباب الموافقة على التحكيم ********************* --}}
@if ($order->JudgerPendingSelectedJudgers and !request('modal'))
<div class="modal fade" id="popup_show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <input type="text" name="" id="inp-op">
    <div class="modal-dialog modal-lg">

    <div class="d-none">@{{showTexArea}}</div>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title red-color">لقد تم اختيارك محكم {{ $order->JudgerPendingSelectedJudgers->pivot->type=='main'?'أصيل':'احتياطي' }} في الطلب رقم {{ $order->id }}</h5>
                    <div class="close-btn text-start w-100">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <ul class="list-unstyled">
                    <li>

                          <div class=" ">
                            <p>يلتزم المحكم بالإفصاح لكلا طرفي العقد في حال موافقته للتحكيم عن وجود ما يستدعي الرد وفق ما نصت عليه المادة (السادسة عشر) من نظام التحكيم في المملكة العربية السعودية, كما يلتزم بالإفصاح عنها في حال نشوئها بعد الموافقة على التحكيم.</p>
                            <form class="d-flex flex-column gap-2" action="{{ route('judger.selectedJudgers.judgerDecision') }}"
                              method="POST">
                              @csrf
                              @method('PUT')
                              <input type="hidden" name="order_id" value="{{ $order->id }}" id="">
                              <input type="hidden" name="judger_id" value="{{ $order->JudgerPendingSelectedJudgers->id }}" id="">
                              <input type="hidden" name="judger_decision" value="accepted" id="">

                                <div class="d-flex align-items-center gap-3 flex-wrap">
                                    <div class="d-flex align-items-center gap-1" >
                                    وجود موانع
                                        <input class="showText" type="radio" required name="showText" id="" value="showText">
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                    لا يوجد موانع
                                        <input class="notShowText" type="radio" required name="showText" id="" value="notShowText">
                                    </div>
                                </div>

                              <textarea name="rejected" @input="inpArbi($event)" class="form-control textArea d-none w-100" id="" cols="30" rows="2"></textarea>
                              <div class="d-flex align-items-center gap-2">
                              <button class="btn btn-red btn-sm px-4 text-nowrap" type="button" data-bs-toggle="collapse"
                              data-bs-target="#refuse{{ $order->JudgerPendingSelectedJudgers->id }}" aria-expanded="false">رفض</button>
                              <button type="submit" class="btn btn-green btn-sm px-4 text-nowrap">قبول</button>
                              </div>
                            </form>
                            <div class="collapse mt-2" id="refuse{{ $order->JudgerPendingSelectedJudgers->id }}">
                              <form class="d-flex align-items-center flex-wrap gap-2" action="{{ route('judger.selectedJudgers.judgerDecision') }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="order_id" value="{{ $order->id }}" id="">
                                <input type="hidden" name="judger_id" value="{{ $order->JudgerPendingSelectedJudgers->id }}" id="">
                                <input type="hidden" name="judger_decision" value="refused" id="">
                                <input required type="text" @input="inpArbi($event)"  placeholder="سبب الرفض" class="form-control w-auto" name="judger_refused_msg">
                                <button type="submit" class="btn btn-red btn-sm px-4 text-nowrap">رفض الطلب</button>
                              </form>
                          </div>
                          </div>

                    </li>
                </ul>
            </div>
            <div class="modal-footer d-flex justify-content-end  align-items-center">

                <!-- <a target="_blank" type="button"  onclick="document.body.classList.add('overflow-auto')" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">مشاهدة الطلب كاملا</a> -->
                <a href="{{ route('judger.orders.show',[$order->hash_code,'modal'=>'no']) }}" target="_blank"  class="btn btn-secondary btn-sm" >مشاهدة الطلب كاملا</a>
            </div>
        </div>
    </div>

</div>
@endif

<script>
    if ( document.querySelector("#popup_show")) {
        let app = new Vue({
        el: "#popup_show",
        methods: {
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
        },
    });
    }
</script>
@push('js')
    <script>
        if (document.querySelector("#popup_show")) {
            let showText = document.querySelector(".showText"),
            notShowText = document.querySelector(".notShowText"),
            textArea = document.querySelector(".textArea");
            showText.addEventListener("click",()=> {
                textArea.classList.remove("d-none")
            });
            notShowText.addEventListener("click",()=> {
                textArea.classList.add("d-none")
            });
        }

    </script>
    @endpush
