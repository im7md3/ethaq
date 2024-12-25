{{-- ************************ Order Cancel POP ***************************** --}}
<div class="modal fade" id="order_cancel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title red-color">هل أنت متأكد من إلغاء العقد؟</h5>
            </div>
            <div class="modal-body">
                {{ setting('cancellation_terms') }}
                <form action="{{ route('client.orders.update_status',$order) }}" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="close" id="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="submit" class="btn btn-primary">نعم</button>
            </div>
            </form>

        </div>
    </div>
</div>
{{-- ************************ Order Deliveery POP ***************************** --}}
<div class="modal fade" id="order_delivery" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <h5 class="modal-title green-color">هل أنت متأكد من تسليم الطلب؟</h5>
            </div> -->
            <div class="modal-body">
                <!-- {{ setting('delivery_order_terms') }} -->
                <form action="{{ route('vendor.orders.submissionOfWork',$order) }}" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="request_done">
                    <div class="d-flex align-items-center justify-content-between gap-2">
                        عند تسليم الأعمال لا يمكنك إضافة أعمال أخرى
                    <button type="submit" class="btn btn-primary">موافق</button>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
            </div>
            </form>

        </div>
    </div>
</div>
{{-- **************** بوباب استرجاع المبالغ ********************* --}}
<div class="modal fade" id="refund" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title red-color">استرجاع مبلغ</h5>
            </div>
            <div class="modal-body">
                <p>المبلغ الذي قمت بدفعه لهذا الطلب هو: {{
                    auth()->user()->invoicesForOrder($order->id,null,'paid')->sum('total') }}</p>
                <p>هل أنت متأكد من استرجاعه؟</p>
                <form action="{{ route('client.refund.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="hidden" name="amount" value="{{ auth()->user()->invoicesForOrder($order->id,null,'paid')->sum('total') }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="submit" class="btn btn-primary">نعم</button>
            </div>
            </form>

        </div>
    </div>
</div>
