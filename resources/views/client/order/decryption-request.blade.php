@extends('client.order.layout')
@section('order-content')
<div class="boxes-order" id="negotiations">
  <div class="container">
    <div class=" ">
      <p class="text-666 fw-bold mb-3 fs-6">طلبات فتح التشفير</p>
      <div class="parent-table mb-4">
        <table class="table table-bordered table-striped">
          <tr>
            <td>اسم طالب الدخول</td>
            <td>تاريخ</td>
            <td>الحالة</td>
            <td>قرار</td>
          </tr>
          @foreach($order->DecryptionRequests as $item)
          <tr>
            <td><a target="_blank"
                href="{{-- {{ route('front.vendor.profile',$item->vendor->id) }} --}}">{{$item->name}}</a></td>
            <td>{{$item->pivot->created_at}}</td>
            <td>{{(__($item->pivot->status))}}</td>
            <td>
              @if($item->pivot->status == 'pending' and !$item->pivot->code)
              <div class="d-flex align-items-center gap-1 justify-content-center">
                  <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                    data-bs-target="#staticBackdrop{{$item->id}}">
                    قبول
                  </button>
                  <form action="{{ route('client.decryption_request.update',[$order->id,$item->id]) }}" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="refused" id="">
                    <button type="submit" class="btn btn-sm btn-danger">رفض</button>
                  </form>
              </div>
              <!-- Modal -->
              <div class="modal fade" id="staticBackdrop{{$item->id}}" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header py-2">
                      <button type="button" class="btn m-0 btn-close border-0 bg-transparent" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <h6>في حالة القبول سيتم انشاء كود</h6>
                    </div>
                    <div class="modal-footer justify-content-end">
                      <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                      <form action="{{ route('client.decryption_request.update',[$order->id,$item->id]) }}" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="pendingLogin" id="">
                      <button type="submit" class="btn btn-sm btn-success">إرسال</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>


              @else
              @if($item->pivot->code)
              كود :
              {{$item->pivot->code}}
              @endif
              @endif
            </td>
          </tr>
          @endforeach
        </table>
      </div>

    </div>
  </div>
</div>
@push('js')
<script>
  let app = new Vue({
        el: "#negotiations",
        data:{
        }
    });

</script>
@endpush
@endsection
