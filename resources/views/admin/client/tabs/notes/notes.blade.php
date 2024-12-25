<div class="tab-pane fade" id="nav-notes">
    <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#create">
        إضافة
    </button>
    @include('admin.client.tabs.notes.create-modal')

    <div class="table-responsive">
        <table class="table">
            <tr>
                <th>#</th>
                <th>الملاحظة</th>
                <th>العمليات</th>
            </tr>
            @foreach ($notes as $note)
            <tr>
                <th>{{ $loop->iteration   }}</th>
                <th>{{ $note->content }}</th>
                <th>
                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit{{ $note->id }}">
                        تعديل
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{ $note->id }}">
                        حذف
                    </button>
                    @include('admin.client.tabs.notes.delete-modal',['note'=>$note])
                    @include('admin.client.tabs.notes.edit-modal',['note'=>$note])
                </th>
            </tr>
            @endforeach
        </table>
        {{ $notes->links() }}
    </div>
</div>
