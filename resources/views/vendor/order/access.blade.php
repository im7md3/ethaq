<div class="w-100  p-5 height-section state">
    <div class="container w-100 p-3">
        <div class="me-5">
            <form class="me-5"  action=" {{route('vendor.orders.orderAccess',$order->hash_code)}} " method="post">
                @csrf
                <p class="mb-2">
                يتم تقديم خدمة المحاماة وفق نظام المحاماة الصادر بالمرسوم الملكي رقم م/38 بتاريخ 28/07/1422هـ
                </p>
                <div class="d-flex align-items-center gap-2">
                <div class="form-group d-flex align-items-center gap-1">
                    <input type="radio" name="option" id="option-1" value="1">
                    <label class="text-success" for="option-1">
                    أوافق
                    </label>
                </div>
                <div class="form-group d-flex  align-items-center gap-1">
                    <input type="radio" name="option" id="option-2" value="2">
                    <label class="text-danger" for="option-2">أرفض</label>
                </div>
                </div>
                <div class="w-100 text-center mt-4">
                    <button class="btn btn-success btn-sm px-4">ارسال</button>
                </div>
            </form>
        </div>
    </div>
</div>
