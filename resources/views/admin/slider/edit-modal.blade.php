<div class="modal fade" id="edit{{ $slider->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل شريحة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.sliders.update',$slider->id) }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">الصورة</label>
                        <input type="file" name="file"  id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label for="">العضوية</label>
                            <select name="type" class="form-control">
                                <option value="">اختر العضوية</option>
                                <option value="all" {{ $slider->type=='all'?'selected':'' }}>الكل</option>
                                <option value="vendor" {{ $slider->type=='vendor'?'selected':'' }}>محامي</option>
                                <option value="client" {{ $slider->type=='client'?'selected':'' }}>عميل</option>
                                <option value="judger" {{ $slider->type=='judger'?'selected':'' }}>محكم</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label for="">خاص ب</label>
                            <select name="model_type" class="form-control">
                                <option value="all" {{ $slider->model_type=='all'?'selected':'' }}>الكل</option>
                                <option value="orders" {{ $slider->model_type=='orders'?'selected':'' }}>الطلبات</option>
                                <option value="services" {{ $slider->model_type=='services'?'selected':'' }}>الطلبات الخاصة</option>
                                <option value="consulting" {{ $slider->model_type=='consulting'?'selected':'' }}>استشارات</option>
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