<div class="d-none d-lg-block col-lg-3">
    <div class="slide-user pb-0">
        <div class="card-slide ">
                <img class="img-user" src="{{ display_file($user->photo) }}" alt="" />
            <h6 class="">
                {{ $user->name }}
            </h6>
            <div class="badge-info">{{ $user->occupation?->name??'لا يوجد' }}</div>
        </div>
        <div class="card-slide px-0">
            <!-- <p class="">
                الرصيد الكلي:
                <span class="main-color d-inline fw-bold fs-5"> {{ $user->total_balance }}$ </span>
            </p>
            <p class="">
                الرصيد المعلق :
                <span class="main-color d-inline fw-bold fs-5 "> {{ $user->suspended_balance }}$ </span>
            </p> -->

        </div>
        <!-- <div class="card-slide ">
            <a href="" class="btn-icon justify-content-between">
                انشاء عقد
                <div class="icon">
                    <i class="fas fa-angle-left"></i>
                </div>
            </a>
        </div> -->
        <div class="card-slide ">
            <a href="{{ route('balance') }}" class="btn-icon justify-content-between">
                عرض الرصيد
                <div class="d-flex align-items-center gap-3">
                    <div class="icon">
                        <i class="fas fa-angle-left"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="card-slide ">
            <a href="{{ route('vendor.home') }}" class="btn-icon justify-content-between">
                الطلبات
                <div class="icon">
                    <i class="fas fa-angle-left"></i>
                </div>
            </a>
        </div>
        <div class="card-slide ">
            <a href="{{ route('vendor.invoices.index') }}" class="btn-icon justify-content-between">
                الفواتير
                <div class="icon">
                    <i class="fas fa-angle-left"></i>
                </div>
            </a>
        </div>
        @if(setting('consulting'))
        <div class="card-slide ">
            <a href="{{ route('vendor.consulting.index') }}" class="btn-icon justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    الاستشارات
                    <span class="lg-badge">{{ App\Models\Consulting::where('vendor_id', $user->id)->where('status','active')->count() }}</span>
                </div>
                <div class="icon">
                    <i class="fas fa-angle-left"></i>
                </div>
            </a>
        </div>
        @endif
        <div class="card-slide ">
            <a target="_blank" href="{{ route('arbitrationRegulations') }}" class="btn-icon justify-content-between">
                الائحة التحكيمية
            </a>
        </div>
    </div>
</div>
