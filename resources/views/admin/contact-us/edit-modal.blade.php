<div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.contact-us.update', $item->id) }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="">الحالة</label>
                        <select name="status" id="" class="form-control">
                            <option value="">اختر الحالة</option>
                            <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>بإنتظار الرد</option>
                            <option value="finished" {{ $item->status == 'finished' ? 'selected' : '' }}> تم الرد
                            </option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
