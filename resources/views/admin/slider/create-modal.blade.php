<div class="modal fade" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">إضافة شريحة جديدة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                @csrf
                <div class="form-group">
                    <div class="form-group">
                        <label for="">الصورة</label>
                        <input type="file" name="file"  id="" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group">
                        <label for="">العضوية</label>
                        <select name="type" class="form-control">
                            <option value="all">الكل</option>
                            <option value="vendor">محامي</option>
                            <option value="client">عميل</option>
                            <option value="judger">محكم</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group">
                        <label for="">خاص ب</label>
                        <select name="model_type" class="form-control">
                            <option value="all">الكل</option>
                            <option value="orders">الطلبات</option>
                            <option value="services">الطلبات الخاصة</option>
                            <option value="consulting">استشارات</option>
                        </select>
                    </div>
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