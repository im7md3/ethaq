<div class="modal fade" id="delete_agent{{$role->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.roles.destroy',$role) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    هل أنت متأكد من حذف المجموعة؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">لا</button>
                    <button class="btn btn-sm  btn-danger" type="submit" data-bs-dismiss="modal">نعم</button>
                </div>
            </form>
        </div>

    </div>
</div>