<div class="modal fade" id="delete{{ $specialty->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">حذف تخصص</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.specialties.destroy',$specialty->id) }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    هل أنت متأكد من حذف التتخصص؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">نعم</button>
                </div>
            </form>
        </div>
    </div>
</div>