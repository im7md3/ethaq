@extends('admin.layouts.admin')
@section('title','عرض طلب')
@section('content')
<section class=" show-user">
  <nav aria-label="breadcrumb ">
    <ol class="breadcrumb bg-light p-3">
      <li href="" class="breadcrumb-item" aria-current="page">
        عرض طلب
      </li>
    </ol>
  </nav>
  <div class="content_view">


    <div class="row row-gap-24">

      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="" class="small-label"> القسم الرئيسي </label>
        <input readonly type="text" value="المحاماة" class="form-control">
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="" class="small-label"> القسم الفرعي </label>
        <input readonly type="text" value="{{ $order->mainDepartment?->name }}" class="form-control">
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="" class="small-label"> القسم الثالث </label>
        <input readonly type="text" value="{{ $order->department?->name }}" class="form-control">
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="" class="small-label"> العميل </label>
        <input readonly type="text" value="{{ $order->user?->name }}" class="form-control">
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="" class="small-label">عنوان الطلب <span class="text-danger">*</span></label>
        <input readonly type="text" value="{{ $order->title }}" class="form-control">
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="" class="small-label">تفاصيل الطلب <span class="text-danger">*</span></label>
        <textarea readonly type="text" class="form-control">{{ $order->details }}</textarea>
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="" class="small-label"> حالة الطلب </label>
        <input readonly type="text" value="{{ __($order->status) }}" class="form-control">
      </div>
      @if($order->status=='refused')
      <div class="col-sm-6 col-md-4 col-lg-3" v-if="status=='refused'">
        <label for="" class="small-label">سبب الرفض <span class="text-danger">*</span></label>
        <textarea readonly type="text" class="form-control">{{ $order->refused_msg }}</textarea>
      </div>
      @endif
      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="" class="small-label">التشفير <span class="text-danger">*</span></label>
        <input disabled type="checkbox" name="encrypted" {{ $order->encrypted?'checked':'' }}>
      </div>

      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="" class="small-label"> المدن </label>
        @foreach ($order->cities as $city)
          {{ $city->name }},
          @endforeach
      </div>


    </div>
  </div>
</section>
@endsection
