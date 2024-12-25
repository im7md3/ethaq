<div class="d-none d-lg-block col-lg-3 not-print">
    <div class="slide-user pb-0">
        <div class="card-slide">
            <img class="img-user" src="{{ asset(display_file($user->photo)) }}" alt="" />
            <h6 class="">
                {{ $user->name }}
            </h6>
            <div class="badge-info"> عميل</div>
        </div>
        <!-- <div class="card-slide">
            <a href="{{ route('client.settings') }}" class="btn-more-lg ">
                أكمل بيانات حسابي
                <i class="fas fa-arrow-left-long icon"></i>
            </a>
        </div> -->
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
            <a href="{{ route('client.invoices.index') }}" class="btn-icon justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    الفواتير
                    @if($user->invoices_count>0)
                    <div class="lg-badge">
                        {{ $user->invoices_count }}
                    </div>
                    @endif
                </div>
                <div class="icon">
                    <i class="fas fa-angle-left"></i>
                </div>
            </a>
        </div>
        @if(setting('consulting'))
        <div class="card-slide ">
            <a href="{{ route('client.profile') }}" class="btn-icon justify-content-between">
                الطلبات
                <div class="icon">
                    <i class="fas fa-angle-left"></i>
                </div>
            </a>
        </div>
        <div class="card-slide ">
            <a href="{{ route('client.consulting.index') }}" class="btn-icon justify-content-between">
                <div class="d-flex align-items-center gap-2">
                الاستشارات
                <span class="lg-badge">{{ App\Models\Consulting::where('client_id',
                    $user->id)->where('status','active')->count() }}</span>
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
        <div class="card-slide ">
            <a href="{{ route('client.specialServices.index') }}" class="btn-icon justify-content-between">
                خدمات خاصة
            </a>
        </div>
        <!-- <div class="card-slide ">
            <a href="{{ route('client.orders.create') }}" class="btn-icon justify-content-between">
                    طلب جديد
                    <div class="icon">
                        <i class="fas fa-angle-left"></i>
                    </div>
                </a>
        </div>
        <div class="card-slide ">
            <a href="{{ route('client.profile') }}" class="btn-icon justify-content-between">
                طلباتي
                <div class="icon">
                    <i class="fas fa-angle-left"></i>
                </div>
            </a>
        </div>
        <div class="card-slide ">
            <a href="{{ route('tickets.index') }}" class="btn-icon justify-content-between">
                التذاكر
                <div class="icon">
                    <i class="fas fa-angle-left"></i>
                </div>
            </a>
        </div> -->
    </div>
</div>
