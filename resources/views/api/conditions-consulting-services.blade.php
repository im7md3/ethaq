@extends('api.layout')
@section('title','شروط تقديم خدمة الاستشارات
')
<!-- Start Header -->
@section('content')
<section class="contact height-section py-5">
    <div class="container">
        <h3>شروط تقديم خدمة الاستشارات</h3>
        {!! setting('terms_of_consulting') !!}
    </div>
</section>


@endsection
