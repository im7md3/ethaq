<div class="">
    <div class="">
        <h6 class="my-3">العرض المقدمة</h6>
        @foreach ($con->offers as $offer)
        <div class="boxes-offers row">
            <div class="col-12 col-md-6">
                <div class="box-offer">
                    <div class="box-child consulting">
                        <div class="d-flex w-100 gap-2 mb-1">
                            <div class="img-cont">
                                <img class="" src="{{ display_file($offer->vendor->photo) }}" alt="" />
                            </div>
                            <div class="info-holder d-flex flex-column align-items-start justify-content-center">
                                <h3 class="name"> {{$offer->vendor->name }}</h3>
                                <div class="rate-holder d-flex align-items-center gap-2">
                                    <x-consultation.evaluation :value="$offer->vendor->VendorConsultingTotalEvaluate">
                                    </x-consultation.evaluation>
                                    <span class="mb-1 brage">|</span>
                                    <small class="mb-0 rate-word">تقييم</small>
                                </div>
                                <div class="d-flex justify-content-center align-items-center mt-1 gap-4 small-info">
                                        <div class="work-holder">
                                            <i class="fa-solid fa-briefcase"></i>
                                            محامي
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="to-profile d-flex justify-content-end">
                            <a target="_blank" href="{{ route('client.vendor.profile', $offer->vendor->id) }}"
                                class="btn-profile">
                                <i class="fa-solid fa-chevron-left"></i>
                            </a>
                        </div>
                        <form action="{{ route('client.consulting.accept.offer') }}" method="POST">
                            @csrf
                            <input type="hidden" name="consulting_id" value="{{ $con->id }}">
                            <input type="hidden" name="offer_id" value="{{ $offer->id }}">
                            <input type="hidden" name="vendor_id" value="{{ $offer->vendor->id }}">
                            <input type="hidden" name="amount" value="{{ $offer->amount }}">
                            <input type="hidden" name="status" value="accepted">
                            <div class="d-flex mt-3">
                                <button class="btn-more-ac btn">
                                    الاتعاب المالية
                                    <br>
                                    <b>{{ $offer->amount }}</b>
                                    ر.س
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
