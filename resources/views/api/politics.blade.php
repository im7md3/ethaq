@extends('api.layout')
@section('title','السياسات')
<!-- Start Header -->
@section('content')
<!-- End Header -->
<section class=" height-section py-5">
  <div class="container">
      <h3 class="mb-3">السياسات</h3>
      <div class="bg-body rounded p-3 shadow-sm ">
        {!! setting('politics') !!}
      </div>
  </div>
</section>
@endsection
