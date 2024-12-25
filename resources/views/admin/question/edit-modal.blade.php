<div class="modal fade" id="edit{{ $question->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل سؤال</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.questions.update',$question->id) }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                     
                    <div class="form-group">
                        <label for=""> عنوان السؤال </label>
                        <input type="text" name="name" value="{{ $question->name }}" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">  الجواب</label>
                        <input type="text" name="result" value="{{ $question->result }}" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">العضوية</label>
                        <select name="type" id="">
                            <option value="">للكل</option>
                            <option value="client" @selected($question->type=='client')>عميل</option>
                            <option value="vendor" @selected($question->type=='vendor')>محامي</option>
                            <option value="judger" @selected($question->type=='judger')>محكم</option>
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