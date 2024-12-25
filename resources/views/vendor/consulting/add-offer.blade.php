<div class="">
    @if(!$con->AddedOffer)
    <form action="{{ route('vendor.consulting.offers.store') }}" method="POST">
        @csrf
        <input type="hidden" name="consulting_id" value="{{ $con->id }}" id="">
        <input type="hidden" name="vendor_id" value="{{ auth()->id() }}" id="">
        <div class="row g-3 mb-3 mt-2">
            <h6 class="title mt-3 mb-0 fw-bold">اضف عرضك</h6>
            <div class="d-flex align-items-end gap-2 flex-wrap">
                <label class="">
                    <!-- <span class="span-label">المبلغ</span> -->
                    <div class="input-group input-group-sm amount-input-group">
                        {{-- @if(!$con->free) --}}
                        @if(auth()->user()->consulting_price)
                        <input type="number" name="amount" class="form-control"
                            min="{{ setting('minimum_amount_for_consultation') }}" max="{{ setting('pay_later_max') }}">
                        <span class="input-group-text">ريال</span>
                        <button class="main-btn small-btn">إرسال</button>
                        @else
                        <p class="text-danger">يرجى تعديل سعر الاستشارة لتستطيع تقديم عرض</p>
                        @endif
                        {{-- @else
                        <div class="">
                            <small class="text-success">الاستشارة مجانية</small>
                        </div>
                        <input readonly type="number" name="amount" class="form-control" value="0">
                        <span class="input-group-text">ريال</span>
                        <button class="main-btn small-btn">إرسال</button>
                        @endif --}}
                    </div>
                </label>
            </div>
        </div>
    </form>
    @else
    <div class="">
        <h6 class="my-3">العرض المقدمة</h6>
        <div class="boxes-offers row">
            <div class="col-12 col-md-6">
                <div class="box-offer">
                    <div class="box-child consulting">
                        <div class="d-flex w-100 gap-2 mb-1">
                            <div class="img-cont">
                                <img class="" src="{{ display_file($user->photo) }}" alt="" />
                            </div>
                            <div class="info-holder d-flex flex-column align-items-start justify-content-center">
                                <h3 class="name"> {{$user->name }}</h3>
                                <div class="rate-holder d-flex align-items-center gap-2">
                                    <x-consultation.evaluation :value="$user->VendorConsultingTotalEvaluate">
                                    </x-consultation.evaluation>
                                    <span class="mb-1 brage">|</span>
                                    <small class="mb-0 rate-word">تقييم</small>
                                </div>
                                <div class="d-flex justify-content-center mt-1 align-items-center gap-4 small-info">
                                    <div class="work-holder">
                                        <i class="fa-solid fa-briefcase"></i>
                                        محامي
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mt-3">
                            <div href="" class="btn-more-ac btn">
                                الاتعاب المالية
                                <br>
                                <b>{{ $my_offer->amount }}</b>
                                ر.س
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>