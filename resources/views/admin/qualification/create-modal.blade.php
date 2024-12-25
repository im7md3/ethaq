<div class="modal fade" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">إضافة مؤهل جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.qualifications.store') }}" method="POST">
            <div class="modal-body">
                @csrf
                <div class="form-group">
                    <label for="">اسم المؤهل</label>
                    <input type="text" name="name" id="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">نوع العضوية</label>
                    <select name="type" id="">
                        <option value="">اختر نوع العضوية</option>
                        <option value="vendor">محامي</option>
                        <option value="judger">محكم</option>
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