@extends('judger.order.layout')
@section('order-content')
<div class="boxes-order" id="negotiations">
  {{-- ************************ Messages Card **************************** --}}
  @forelse ($logs as $log)
    <p>{{ $log->content }}</p>
    <p>{{ $log->created_at }}</p>
  {{ $logs->links() }}
  @empty
  <div class="alert alert-danger">لا يوجد أي سجل للطلب</div>
  @endforelse
@endsection