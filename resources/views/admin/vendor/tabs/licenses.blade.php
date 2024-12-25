<div class="tab-pane fade" id="nav-licenses">
  @can('read_licenses')
  <div class="table-responsive">
    <table class="table table-hover">
      <thead class="table-dark">
        <tr>
          <th>رقم الرخصة</th>
          <th>الترخيص</th>
          <th>تاريخ نهاية الترخيص</th>
          <th>قبول/رفض</th>
          <th>إدارة</th>
        </tr>
      </thead>
      <tbody>
        @if($license)
        <tr>
          <td>1</td>
          <td>
            <a target="_blank" href="{{ display_file($license->file) }}" class="text-primary fs-6">
              <i class="fa-solid fa-file-lines"></i>
            </a>
          </td>
          <td>{{$license?->end_at}}</td>
          <td>
            @can('update_licenses')
            @if($license?->status=='pending')
            <form action="{{ route('admin.licenses.update',$license?->id) }}" method="POST">
              @csrf
              @method('PUT')
              <input type="hidden" name="status" value="accepted">
              <button type="submit" class="btn btn-sm btn-success">قبول</button>
            </form>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#refused{{ $license?->id }}">
              رفض
          </button>
            @include('admin.vendor.tabs.refused-modal',['model'=>$license,'route'=>'licenses'])
            @endcan
            @elseif($license?->status=='accepted')
            <button class="btn btn-sm btn-success">مقبول</button>
            @elseif($license?->status=='refused')
            <button type="submit" class="btn btn-sm btn-danger">مرفوض</button>
            <p>سبب الرفض: {{ $license?->refused_msg }}</p>
            @endif
          </td>

          <td>
            @can('delete_licenses')
            <div class="d-flex gap-2">
              <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{ $license?->id }}">
                <i class="fa-solid fa-trash"></i>
            </button>
              @include('admin.vendor.tabs.delete-modal',['model'=>$license,'route'=>'licenses'])
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
