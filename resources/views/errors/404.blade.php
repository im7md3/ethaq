@extends('front.layouts.front')
@section('title','404')
<!-- Start Header -->
@section('content')
<!-- End Header -->
<section class="bg-light-green height-section-footer d-flex align-items-center justify-content-center py-5">
    <div class="container text-center">
        <h1>404
            غير متوفر</h1>
        <a href="{{ url('/') }}" class="btn btn-primary mt-2">الصفحة الرئيسية</a>
    </div>
</section>


@endsection
