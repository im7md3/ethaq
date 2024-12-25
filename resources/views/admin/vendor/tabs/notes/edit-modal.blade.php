<div class="modal fade" id="edit{{ $note->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل ملاحظة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.notes.update',$note->id) }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="form-group">
                    <label for="" class="d-block mb-1">الملاحظة</label>
                        <textarea name="content" id="" class="form-control" rows="4">{{ $note->content }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">نعم</button>
                </div>
            </form>
        </div>
    </div>
</div>