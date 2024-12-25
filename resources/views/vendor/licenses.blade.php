<!-- <div class="scrl-support">
    <a href="{{route('tickets.index')}}" class="support">
        <img src="{{asset('front-assets')}}/img/global/Asset 13@5x.png" alt="">
        الدعم
    </a>
    <div class="shere tog-active">
        <div class="img"><img src="{{asset('front-assets')}}/img/global/Asset 15@5x.png" alt=""></div>
        <div class="shere-list">
            <a href="#" class="shere-item">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="shere-item">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="shere-item">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="#" class="shere-item">
            <i class="fas fa-envelope"></i>
            </a>
        </div>
    </div>
</div> -->
<section class="height-section">
        <div class="row row-gap-24">
            <div class="col-md-12">
                <div class="bg-white p-3 rounded shadow">
                    @if($user->HasActiveLicense)
                    <div class="alert alert-info py-2 mb-0" role="alert">
                        متبقى على انتهاء الترخيص {{
                        Carbon::createFromDate($user->license?->end_at)->diffInDays(Carbon::now()) }} يوم
                    </div>
                    <div class="row row-gap-24">
                            <div class="col-md-12">
                                <label for="" class="small-label">رقم الرخصة</label>
                                <input type="text" readonly class="form-control" value=" {{ $user->license?->name }}">
                            </div>
                            <div class="col-md-12">
                                <label for="" class="small-label">تاريخ الانتهاء</label>
                                <input type="text" readonly class="form-control" value="{{ $user->license?->end_at }}">
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex gap-2 align-items-center justify-content-end">
                                    <label for="" class="small-label d-block mb-0">الرخصة</label>
                                    <a href="{{ display_file($user->license?->file) }}" target="_blank" class="btn btn-sm btn-success">عرض </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @company
            <div class="col-md-12">
                <div class="bg-white p-3 rounded shadow">
                    @if($user->HasActiveCommercial)
                    <div class="alert alert-info py-2 mb-0" role="alert">
                        متبقى ع انتهاء الترخيص {{
                        Carbon::createFromDate($user->commercial?->end_at)->diffInDays(Carbon::now()) }} يوم
                    </div>
                    <div class="row row-gap-24">
                            <div class="col-md-12">
                                <label for="" class="small-label">رقم الرخصة</label>
                                <input type="text" readonly class="form-control" value=" {{ $user->commercial?->name }}">
                            </div>
                            <div class="col-md-12">
                                <label for="" class="small-label">تاريخ الانتهاء</label>
                                <input type="text" readonly class="form-control" value="{{ $user->commercial?->end_at }}">
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex gap-2 align-items-center justify-content-end">
                                    <label for="" class="small-label mb-0 d-block">السجل</label>
                                    <a href="{{ display_file($user->commercial?->file) }}" target="_blank" class="btn btn-sm btn-success">عرض </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-12 ">
                <div class="bg-white p-3 rounded shadow">
                    @if($user->contract)
                    <div class="row row-gap-24">
                        <div class="col-md-12">
                        <label for="" class="small-label">اسم المسؤول</label>
                        <input type="text" readonly value="{{ $user->company_name }}" class="form-control">
                    </div>
                    <div class="col-md-12">
                            <label for="" class="small-label">جوال المسؤول</label>
                        <input type="text" readonly value="{{ $user->company_number }}" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex gap-2 align-items-center justify-content-end">
                            <a href="{{ display_file($user->contract) }}" target="_blank" class="btn btn-sm btn-success">عرض </a>
                        </div>
                    </div>
                    </div>
                    @endif
                </div>
            </div>
            @endcompany
        </div>
</section>
