<div class="modal fade" id="edit{{ $alert->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل تنبيه </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.alerts.update', $alert->id) }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">اسم التنبيه </label>
                        <input type="text" name="title" value="{{ $alert->title }}" id="mytextarea"
                            class="form-control">
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
@push('js')
<script src="https://cdn.tiny.cloud/1/4dz1oquugug0qegc7xv2d6vf51m5ncnejbx7ruqvjzl6xu2x/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
      selector: "#mytextarea",
      plugins: "emoticons",
      toolbar: "emoticons",
      toolbar_location: "bottom",
      menubar: false
    });
  </script>
@endpush