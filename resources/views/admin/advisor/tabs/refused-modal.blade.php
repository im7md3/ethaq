<div class="modal fade" id="refused{{ $model?->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">رفض مرفق</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.'.$route.'.update',$model?->id) }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="refused">
                    <label for="">رسالة الرفض</label>
                    <textarea name="refused_msg" class="form-control"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">رفض</button>
                </div>
            </form>
        </div>
    </div>
</div>