<div class="d-none d-lg-block col-lg-3">
    <div class="slide-user pb-0">
        <div class="card-slide ">
                <img class="img-user"
                src="{{ display_file($user->photo) }}"
                alt="" />
            <h6 class="">
                {{ $user->name }}
            </h6>
            <div class="badge-info">{{ $user->occupation?->name??'لا يوجد' }}</div>
        </div>
        <!-- <div class="card-slide">
            <p class="">حسابك مكتمب بنسبة 48%</p>
            <p>
            <div class="small-prog progress">
                <div class="progress-bar " style="width:75%;" role="progressbar" aria-valuenow="75"
                    aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            </p>
            <a href="{{ route('judger.settings') }}" class="btn-more-lg ">
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
                <div class="d-flex align-items-center gap-2">
                    <div class="icon">
                        <i class="fas fa-angle-left"></i>
                    </div>
                </div>
            </a>
        </div>
        @if ($user->checkUserActive())
        <div class="card-slide ">
            <a href="{{ route('judger.invoices.index') }}" class="btn-icon justify-content-between">
                الفواتير
                <div class="d-flex align-items-center gap-3">
                    <div class="icon">
                        <i class="fas fa-angle-left"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="card-slide ">
            <a href="" class="btn-icon justify-content-between">
                اخر الطلبات
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
