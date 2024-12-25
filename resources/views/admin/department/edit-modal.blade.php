<div class="modal fade" id="edit{{ $department->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل قسم</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.departments.update',$department->id) }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">اسم القسم</label>
                        <input type="text" name="name" value="{{ $department->name }}" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">القسم الأب</label>
                        <select name="parent" id="" class="form-control">
                            <option value="">اختر القسم</option>
                            @foreach (App\Models\Department::all() as $depart)
                                <option value="{{ $depart->id }}" {{ $depart->id==$department->parent?'selected':'' }}>{{ $depart->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">الصورة</label>
                        <input type="file" name="photo" id="" class="form-control">
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