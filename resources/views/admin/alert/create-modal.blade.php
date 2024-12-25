<div class="modal fade" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">إضافة تنبيه جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.alerts.store') }}" method="POST">
                <div class="modal-body">
                    @csrf

                    <div class="form-group">
                        <label for="">عنوان التنبيه</label>
                        <input type="text" name="title" id="mytextarea" class="form-control">
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