@extends('client.layouts.client')
@section('title','المحامين')
@section('content')
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
            <div class="exhibition_box">
              <div class="image_holder">
                <a href="{{ route('client.vendor.profile', $vendor->id) }}">
                  <img src="{{ display_file($vendor->photo) }}" width="100" alt="{{ $vendor->username }}">
                </a>
              </div>
              <div class="exhibition-name">
                <a href="#">{{ $vendor->name }}</a>
                <i
                  class="fa-solid fa-circle state_offline {{ Cache::has('user-is-online-' . $vendor->id) ? 'text-success' : '' }}"></i>
              </div>
              <div class="visit_holder">
                <a href="{{ route('client.vendor.profile', $vendor->id) }}" class="btn visit_profile">الملف الشخصي</a>
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
