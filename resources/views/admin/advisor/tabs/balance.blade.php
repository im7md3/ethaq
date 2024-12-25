<div class="tab-pane fade" id="nav-balance">
    <div class="table-responsive">
        <div class="d-flex gap-4">
            <div class="">
                <p class="">
                    الرصيد الإجمالي:
                    <span class="main-color d-inline fw-bold fs-5"> {{ $user->total_balance }}ر.س </span>
                </p>
            </div>
            <div class="">
                <p class="">
                    الرصيد المعلق:
                    <span class="main-color d-inline fw-bold fs-5"> {{ $user->suspended_balance }}ر.س
                    </span>
                </p>
            </div>
            <div class="">
                <p class="">
                    الرصيد المتاح للسحب:
                    <span class="main-color d-inline fw-bold fs-5"> {{ $user->current_balance }}ر.س
                    </span>
                </p>
            </div>
        </div>
        @if ($user->PendingWithdrawals->count() > 0)
            <div class="">
                <h4>طلبات السحب الجديدة</h4>
                @foreach ($user->PendingWithdrawals->get() as $item)
                    <div class="card">
                        <div class="card-body ">
                            <p>تاريخ السحب: {{ $item->created_at }}</p>
                            <p>المبلغ: {{ $item->amount }}</p>
                            <p>الحالة: {{ __($item->status) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <div class="">
            <h3>المعاملات المالية</h3>
            @foreach ($financial as $item)
                <div class="card">
                    <div class="card-body d-flex justify-content-between">
                        <p>{{ $item->content }}</p>
                        <p>{{ $item->created_at }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $financial->links() }}
    </div>
</div>
