@extends('api.layout')
@section('title','الخدمات الخاصة')
<!-- Start Header -->
@section('content')
<!-- End Header -->
<section class=" height-section py-5">
  <div class="container">
      <h3 class="mb-3">الخدمات الخاصة</h3>
      <div class="bg-body rounded p-3 shadow-sm ">
        {!! setting('specialServices') !!}
      </div>
  </div>
</section>
@endsection
