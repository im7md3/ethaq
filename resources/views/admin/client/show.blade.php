@extends('admin.layouts.admin')
@section('title', 'عرض عضو')
@section('content')
    <section class=" show-user">
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb bg-light p-3 d-flex justify-content-between">
                <li href="" class="breadcrumb-item" aria-current="page">
                    عرض عضو
                </li>
                <a class="btn btn-success btn-sm"
                    href="{{ route('admin.notifications.create', ['user_id' => $user->id]) }}">إرسال
                    إشعار</a>
            </ol>
        </nav>
        <div class="content_view">
            <div class="row row-gap-24">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="name" class="small-label">الاسم</label>
                    <input readonly type="text" value="{{ $user->name }}" name="name" class="form-control"
                        id="name">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="name" class="small-label">الاسم المستعار</label>
                    <input readonly type="text" value="{{ $user->username }}" name="name" class="form-control"
                        id="name">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="email" class="small-label">البريد الالكتروني</label>
                    <input type="text" readonly value="{{ $user->email }}" name="email" class="form-control"
                        id="email">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="phone" class="small-label">رقم الجوال</label>
                    <input type="text" readonly value="{{ $user->phone }}" name="phone" class="form-control"
                        id="phone">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="id_number" class="small-label">رقم الهوية</label>
                    <input type="text" readonly value="{{ $user->id_number }}" name="id_number" class="form-control"
                        id="id_number">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="country" class="small-label">الدولة</label>
                    <input type="text" readonly value="{{ $user->country?->name }}" name="country" class="form-control"
                        id="country">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="city" class="small-label"> المدينة </label>
                    <input type="text" readonly value="{{ $user->city?->name }}" name="city" class="form-control"
                        id="city">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> الصورة الشخصية </label>
                    <img src="{{ display_file($user->photo) }}" alt="" class="" width="195" height="130">
                </div>
                {{-- <div class="col-sm-6 col-md-4 col-lg-3">
        <label for="" class="small-label"> رقم الرخصة المسجل في المنصة </label>
        <input type="text" readonly value="" name="" class="form-control">
      </div> --}}
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> تاريخ التسجيل </label>
                    <input type="text" readonly value="{{ $user->created_at->format('Y-m-d') }}" name=""
                        class="form-control">
                </div>
            </div>
            <ul class="nav nav-tabs mt-4 mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <div class="badge-count">0</div>
                        الطلبات
                        <i class="fa-solid fa-cart-flatbed-suitcase icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <div class="badge-count">0</div>
                        العروض
                        <i class="fa-solid fa-sheet-plastic"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" class="nav-link" data-bs-toggle="tab" data-bs-target="#nav-records" type="button">
                        <div class="badge-count">{{ $user->commercial_count }}</div>
                        السجلات التجارية
                        <i class="fa-regular fa-file-lines"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#nav-licenses" type="button">
                        <div class="badge-count">{{ $user->license_count }}</div>
                        التراخيص
                        <i class="fa-solid fa-address-card"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#nav-invoices" type="button">
                        <div class="badge-count">{{ $invoices->count() }}</div>
                        الفواتير
                        <i class="fa-solid fa-money-check-dollar"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <div class="badge-count">0</div>
                        طلبات الشحن
                        <i class="fa-solid fa-credit-card"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#nav-balance" type="button">

                        الرصيد
                        <i class="fa-regular fa-credit-card"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#nav-notes" type="button">
                        الملاحظات
                        <i class="fa-regular fa-credit-card"></i>
                    </a>
                </li>
            </ul>
            @include('admin.client.tabs.commercials')
            @include('admin.client.tabs.licenses')
            @include('admin.client.tabs.invoices')
            @include('admin.client.tabs.balance')
            @include('admin.client.tabs.notes.notes')
        </div>
    </section>
@endsection