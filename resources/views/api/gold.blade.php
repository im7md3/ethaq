@extends('api.layout')
@section('title','الضمان الذهبي')
<!-- Start Header -->
@section('content')
<!-- End Header -->
<section class=" height-section py-5">
  <div class="container">
      <h3 class="mb-3">الضمان الذهبي</h3>
      <div class="bg-body rounded p-3 shadow-sm ">
        {!! setting('gold') !!}
      </div>
  </div>
</section>
@endsection
