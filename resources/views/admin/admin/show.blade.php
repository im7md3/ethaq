@extends('admin.layouts.admin')
@section('title',$admin->name)
@section('content')
<section class=" show-user">
  <nav aria-label="breadcrumb ">
    <ol class="breadcrumb bg-light p-3">
      <li href="" class="breadcrumb-item" aria-current="page">
        عرض مشرف
      </li>
    </ol>
  </nav>
  <div class="content_view">
    <div class="row row-gap-24">
      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="first_name" class="small-label">الاسم الاول</label>
        <input readonly type="text" name="first_name" value="{{ $admin->first_name }}" class="form-control" id="first_name">
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="second_name" class="small-label">الاسم الثاني</label>
        <input readonly type="text" value="{{ $admin->second_name }}" name="second_name" class="form-control" id="second_name">
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="third_name" class="small-label">الاسم الثالث</label>
        <input readonly type="text" value="{{ $admin->third_name }}" name="third_name" class="form-control" id="third_name">
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="last_name" class="small-label">الاسم الاخير</label>
        <input readonly type="text" value="{{ $admin->last_name }}" name="last_name" class="form-control" id="last_name">
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="name" class="small-label">الاسم</label>
        <input readonly type="text" value="{{ $admin->name }}" name="name" class="form-control" id="name">
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="last_name" class="small-label">الجنس</label>
        <input readonly type="text" value="{{ __($admin->gender) }}" name="birthdate" class="form-control" id="last_name">
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="last_name" class="small-label">تاريخ الميلاد</label>
        <input readonly type="text" value="{{ $admin->birthdate }}" name="birthdate" class="form-control" id="last_name">
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="email" class="small-label">البريد الالكتروني</label>
        <input type="text" readonly value="{{ $admin->email }}" name="email" class="form-control" id="email">
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="phone" class="small-label">رقم الجوال</label>
        <input type="text" readonly value="{{ $admin->phone }}" name="phone" class="form-control" id="phone">
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="phone" class="small-label">رقم الجوال</label>
        <input type="text" readonly value="{{ $admin->id_number }}" name="phone" class="form-control" id="phone">
      </div>

      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="country" class="small-label">الدولة</label>
        <input type="text" readonly value="{{ $admin->country?->name }}" name="country" class="form-control" id="country">
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="city" class="small-label"> المدينة </label>
        <input type="text" readonly value="{{ $admin->city?->name }}" name="city" class="form-control" id="city">
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="" class="small-label"> الصورة الشخصية </label>
        <img src="{{ display_file($admin->photo) }}" alt="" class="" width="195" height="130">
      </div>
    </div>
  </div>
</section>
@endsection
