@extends('front.layouts.front')
@section('title','إنشاء استشارة')
@section('content')
@if(!auth()->check())
<header class="main-header-login">
    <div
        class="container py-2 text-start d-flex align-items-center gap-4 justify-content-center justify-content-md-between">
        <div class="group-logo d-flex align-items-center justify-content-between ">
            <a href="/">
                <img class="head-logo" src="{{asset('front-assets')}}/img/global/ethaq-logo.png" alt="" srcset="" />
            </a>
            <div class="tog-home tog-active" data-active=".group-login">
                <span class="one-bar"></span>
                <span class="two-bar"></span>
                <span class="three-bar"></span>
            </div>
        </div>

        <div class="group-login d-flex align-items-center justify-content-between flex-fill gap-4">
            <ul class="list-item">
                <li>
                    <a href="#landing" class="item active">الرئيسية</a>
                </li>
                <li>
                    <a href="#questions-page" class="item">كيف تعمل منصتنا</a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="item">تواصل معنا</a>
                </li>
            </ul>
            <div class=" group-btn  d-flex align-items-center  gap-3">
                <div class="dropdown">
                    <a class="btn-header btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        إنشاء عضوية
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="{{ route('client.register') }}">تسجيل عميل</a></li>
                        <li><a class="dropdown-item"
                                href="{{ setting('register_by_nafath')?route('register.nafath'):route('vendor.register') }}">تسجيل
                                محامي</a></li>
                    </ul>
                </div>
                <a href="{{ route('login') }}" class="btn-header btn btn-two"> تسجيل الدخول </a>
            </div>
        </div>
    </div>
</header>
@else
@include(auth()->user()->type.'.layouts.head')
@include(auth()->user()->type.'.layouts.header')
@endif
<!-- End Header -->
<section class="contact py-5">
  <div class="container">
    <x-messages></x-messages>
    <form action="{{ route('storeConsultation') }}" method="POST" enctype="multipart/form-data">
      <div class="row g-4">
        <div class="col-12 col-md-12">
          <div class="alert alert-info mb-0" role="alert">
            <p class="from mb-0">طلب استشارة من المحامي : {{ $vendor->name }}</p>
          </div>
        </div>
        @csrf
        <input type="hidden" name="vendor_id" value="{{ $vendor->id }}">
        <input type="hidden" name="status" value="pending">
        <input type="hidden" name="amount" value="{{ $vendor->consulting_price ?? 5 }}">
        @if(!auth()->check())
        <div class="col-12 col-md-4 col-lg-3">
          <div class="inp-holder">
            <label for="" class="mb-2">الاسم <span class="text-danger">*</span></label>
            <input type="text" name="name" id="" class="form-control">
          </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
          <div class="inp-holder">
            <label for="" class="mb-2">رقم الجوال <span class="text-danger">*</span></label>
            <input type="number" name="phone" id="" class="form-control">
          </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
          <div class="inp-holder">
            <label for="" class="mb-2">الرقم السري <span class="text-danger">*</span></label>
            <input type="password" name="password" id="" class="form-control">
          </div>
        </div>
        @endif
        <div class="col-12 col-md-12 m-0">
          <hr class="bg-transparent m-0">
        </div>
        <div class="col-12 col-md-4 col-lg-3">
          <div class="inp-holder">
            <label for="" class="mb-2">القسم <span class="text-danger">*</span></label>
            <select name="department_id" id="" class="form-select">
              <option value="">اختر القسم </option>
              @foreach ($departments as $department)
              <option value="{{ $department->id }}">{{ $department->name }} </option>

              @endforeach
            </select>
          </div>
        </div>
        <div class="col-12 col-md-12 m-0">
          <hr class="bg-transparent m-0">
        </div>
        <div class="col-12 col-md-8 col-lg-6">
          <label for="" class="mb-2">تفاصيل الاستشارة <span class="text-danger">*</span></label>
          <textarea name="details" id="" rows="6" class="form-control"></textarea>
        </div>
        <div class="col-12 col-md-12 m-0">
          <hr class="bg-transparent m-0">
        </div>
        <div class="col-12 col-md-8 col-lg-6">
          <label for="" class="mb-2">المرفقات <span class="text-danger">*</span></label>
          <input type="file" multiple name="images[]" id="" class="form-control">
        </div>
        <div class="col-12 col-md-12">
          <button type="submit" class="btn btn-primary btn-sm px-5">ارسال</button>
        </div>
      </div>
    </form>

  </div>
</section>
<!-- Start Footer -->
@endsection
