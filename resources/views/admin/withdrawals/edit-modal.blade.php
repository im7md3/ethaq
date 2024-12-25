<div class="modal fade" id="edit{{ $withdrawal->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.withdrawals.update', $withdrawal) }}" method="post">
                @csrf @method('PUT')
                <div class="form-check form-switch d-flex">
                    <select name="status" >
                        <option value="">اختر حالة الطلب</option>
                        <option value="pending" @selected($withdrawal->status=='pending') >بالانتظار
                        </option>
                        <option value="completed" @selected($withdrawal->status=='completed')>تم السحب
                        </option>
                        <option value="refused" @selected($withdrawal->status=='refused')>رفض عملية
                            السحب</option>
                    </select>
                    
                </div>
                <div class="form-check form-switch d-flex">
                    <label for="">سبب الرفض</label>
                    <textarea name="refused_msg" id="" cols="30" rows="10"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>