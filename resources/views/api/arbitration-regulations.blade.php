@extends('api.layout')
@section('title','اللائحة التحكيمية')
<!-- Start Header -->
@section('content')
<style>
    ul,ol {
        padding-right: 2rem;
    }
</style>
<!-- End Header -->
<section class=" height-section py-5">
    <div class="container">
        <h3 class="mb-3">اللائحة التحكيمية</h3>
        <div class="bg-body rounded p-3 shadow-sm ">
        {!! setting('arbitration_regulations') !!}
        </div>
    </div>
</section>


@endsection
