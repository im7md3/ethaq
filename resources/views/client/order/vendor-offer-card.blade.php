<div class="row g-3">
    <div class="col-md-6">
        <div class="box-show-offer">
            <div class="row">
                <div class="col-6">
                    <div class="img-cont">
                        <img class="" src="{{ display_file($vendor->photo) }}" alt="" />
                    </div>
                    <p class="nameAndSpecialty mb-1">
                        {{ $vendor->name }}
                        <i class="active  fas fa-circle"></i>
                    </p>
                    <div class="d-flex justify-content-center  align-items-center gap-2 small-info">
                        <span>
                            {{ $vendor->occupation?->name }}
                        </span>
                        <p class="box-info mb-1 w-100">
                        رخصة رقم:
                        {{ $vendor->license?->name }}
                    </p>
                    </div>
                </div>
                <div class="col-6">
                    {{-- <p class="box-info mb-1">
                        {{ $item->department->department_name_ar ?? '' }}
                    </p> --}}
                    <p class="box-info mb-1">
                        مدة التسليم:
                        {{ count($vendor->offers)>0?$vendor->offers[0]->period:'' }}
                    </p>
                    <p class="box-info red mb-1">
                        المبلغ:
                        {{ count($vendor->offers)>0?$vendor->offers[0]->amount:0 }}

                    </p>

                    <p class="box-info red mb-1">
                        التفاوض:
                        {{ $vendor->offers[0]->negotiable??true ? 'غير قابل' : 'قابل' }}
                    </p>

                    <p class="box-info red">
                        سرعة الرد: {{ count($vendor->offers)>0?$vendor->offers[0]->response_speed:'' }}
                    </p>

                </div>
                <div class="col-6 mt-2">
                    <a href="{{ route('client.orders.vendor_offers',[$order,$vendor]) }}"
                        class=" btn btn-green">العروض
                        المقدمة
                        <span class="noti">{{ $vendor->offers_count }}</span>
                    </a>
                </div>
                <div class="col-6 mt-2">
                    <a href="{{ route('client.negotiations.show',[$order->id,$vendor->negotiations[0]]) }}"
                        class="btn btn-blue">
                        الاستفسار
                        <span class="noti">{{ $vendor->messages_count }}</span>
                    </a>
                </div>
                <div class="col-12">
                    <a href="{{ route('client.vendor.profile',$vendor) }}" class="show-profile btn">
                        الملف الشخصي
                        <i class="fas fa-arrow-left-long"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @if($order->offer_id and $order->vendor_id==$vendor->id)
    <div class="alert  alert-success mb-0 mt-3 w-75 mx-auto ">العرض المقبول</div>
    @endif

</div>
