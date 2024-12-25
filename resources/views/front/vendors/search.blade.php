@extends('front.layouts.front')
@section('title','المحامين')
<!-- Start Header -->
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
<section class="height-section py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <form method="GET" action="" class="filter_side w-100">
          <h5 class="mb-4">المحامين</h5>
          <div class="filtering_section">
            <div class="search_holder mb-4">
              <label for="name">الاسم</label>
              <input type="search" name="name" id="name" class="form-control" value="{{ request('name')}}">
            </div>
            {{-- <h6>التصنيفات</h6>
            <div class="inp_holder mb-4">
              <select name="department_id" id="department_id" class="form-select">
                <option value="" selected>اختر القسم </option>
                @forelse ($departments as $department)
                <option value="{{ $department->id }}" {{ $department->id == $department_id ? 'selected' : '' }}>
                  {{ $department->name }}</option>
                @empty
                @endforelse
              </select>
            </div> --}}
            {{-- <div class="inp_holder mb-4">
              <select name="city_id" id="city_id" class="form-select">
                <option value="" selected>اختر المدينة </option>
                @forelse ($cities as $city)
                <option value="{{ $city->id }}" {{ $city->id == $city_id ? 'selected' : '' }}>{{ $city->name }}</option>
                @empty

                @endforelse
              </select>
            </div> --}}
            <!-- <div class="inp_holder mb-4">
                            <input type="checkbox" name="last_seen" id="last_seen"{{--  {{ $last_seen ? 'checked' :'' }} --}}>
                            <label for="last_seen">متصل</label>

                        </div> -->
            <button class="btn btn-info">بحث</button>
          </div>
        </form>
      </div>
      <div class="col-md-9">
        <div class="row g-2">
          @forelse ($vendors as $vendor)
          <div class="col-md-6 col-lg-4  col-xl-3">
            <div class="exhibition_box vendors">
              <div class="image_holder">
                <a href="{{ route('vendor.profile', $vendor->id) }}">
                  <img src="{{ display_file($vendor->photo) }}" width="100" alt="{{ $vendor->username }}">
                </a>
              </div>
              <div class="exhibition-name">
                <a href="#">{{ $vendor->name }}</a>
                <i
                  class="fa-solid fa-circle state_offline {{ Cache::has('user-is-online-' . $vendor->id) ? 'text-success' : '' }}"></i>
              </div>
              <div class="visit_holder">
                <a href="{{ route('vendor.profile', $vendor->id) }}" class="btn visit_profile">الملف الشخصي</a>
              </div>
            </div>
          </div>
          @empty

          @endforelse
          <div class="col-12 mt-3">
            {{ $vendors->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
