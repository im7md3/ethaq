<div class="tab-pane fade" id="nav-licenses">
  @can('read_licenses')
  <div class="table-responsive">
    <table class="table table-hover">
      <thead class="table-dark">
        <tr>
          <th>اسم المؤهل</th>
          <th>المؤهل</th>
          <th>قبول/رفض</th>
          <th>إدارة</th>
        </tr>
      </thead>
      <tbody>
        @if($advisorFile)
        <tr>
          <td>1</td>
          <td>
            <a target="_blank" href="{{ display_file($advisorFile->file) }}" class="text-primary fs-6">
              <i class="fa-solid fa-file-lines"></i>
            </a>
          </td>
          <td>
            @can('update_licenses')
            @if($advisorFile?->status=='pending')
            <form action="{{ route('admin.advisorFile.update',$advisorFile?->id) }}" method="POST">
              @csrf
              @method('PUT')
              <input type="hidden" name="status" value="accepted">
              <button type="submit" class="btn btn-sm btn-success">قبول</button>
            </form>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#refused{{ $advisorFile?->id }}">
              رفض
          </button>
            @include('admin.advisor.tabs.refused-modal',['model'=>$advisorFile,'route'=>'advisorFile'])
            @endcan
            @elseif($advisorFile?->status=='accepted')
            <button class="btn btn-sm btn-success">مقبول</button>
            @elseif($advisorFile?->status=='refused')
            <button type="submit" class="btn btn-sm btn-danger">مرفوض</button>
            <p>سبب الرفض: {{ $advisorFile?->refused_msg }}</p>
            @endif
          </td>

          <td>
            @can('delete_licenses')
            <div class="d-flex gap-2">
              <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{ $advisorFile?->id }}">
                <i class="fa-solid fa-trash"></i>
            </button>
              @include('admin.advisor.tabs.delete-modal',['model'=>$advisorFile,'route'=>'advisorFile'])
            </div>
            @endcan
          </td>
        </tr>
        @endif
      </tbody>
    </table>
  </div>
  @else
<p class="text-danger">ليس لديك صلاحية لعرض التراخيص</p>
@endcan
</div>
