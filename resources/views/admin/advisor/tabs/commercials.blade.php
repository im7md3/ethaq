<div class="tab-pane fade" id="nav-records">
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
          @if($commercial)
          <tr>
            <td>1</td>
            <td>
              <a target="_blank" href="{{ display_file($commercial?->file) }}" class="text-primary fs-6">
                <i class="fa-solid fa-file-lines"></i>
              </a>
            </td>
            <td>{{$commercial?->end_at}}</td>
            <td>
              @if($commercial?->status=='pending')
              <form action="{{ route('admin.commercials.update',$commercial?->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="accepted">
                <button type="submit" class="btn btn-sm btn-success">قبول</button>
              </form>
              <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#refused{{ $commercial?->id }}">
                رفض
            </button>
              @include('admin.vendor.tabs.refused-modal',['model'=>$commercial,'route'=>'commercials'])
              @elseif($commercial?->status=='accepted')
              <button class="btn btn-sm btn-success">مقبول</button>
              @elseif($commercial?->status=='refused')
              <button type="submit" class="btn btn-sm btn-danger">مرفوض</button>
              <p>سبب الرفض: {{ $commercial?->refused_msg }}</p>
              @endif
            </td>
  
            <td>
              <div class="d-flex gap-2">
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{ $commercial?->id }}">
                  <i class="fa-solid fa-trash"></i>
              </button>
                @include('admin.vendor.tabs.delete-modal',['model'=>$commercial,'route'=>'commercials'])
              </div>
            </td>
          </tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>