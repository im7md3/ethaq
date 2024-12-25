@extends('judger.layouts.judger')
@section('title','الرئيسية')
@section('content')
<section class="">
  <div class="container">
    <div class="row app  g-xxl-5">

      @include('judger.layouts.sidebar')
      <div class="col-lg-9">
        <div class="col-sm-6 col-xl-4  mb-3">
          <form action="">
            <div class="box-inp">
              <div class="icon">
                <i class="fas fa-filter "></i>
              </div>
              <select name="status" class="inp" id="" onchange="this.form.submit()">
                <option value="" @selected(request('selected')=='' )>
                  كل الطلبات
                </option>
                <option value="ongoing" @selected(request('status')=='ongoing' )>
                  طلبات تحت التنفيذ
                </option>
                <option value="pending" @selected(request('status')=='pending' )>
                  طلبات بالانتظار
                </option>
                <option value="done" @selected(request('status')=='done' )>
                  الطلبات منفذة
                </option>
                <option value="close" @selected(request('status')=='close' )>
                  الطلبات ملغية
                </option>
              </select>
            </div>
          </form>
        </div>
        <div class="app-content">
          <div class="">
            <div class="boxes-order boxes-show mt-3">
              @foreach ($orders as $order)
              <div class="box-order d-flex align-items-center flex-column">

                <div
                  class="content-holder flex-column flex-lg-row d-flex justify-between align-items-start gap-2 w-100">
                  <div class="info  ">
                    <img class="photo" src="{{ display_file($order->client?->photo) }}" alt="" />
                    <p class="name">{{ $order->client?->username }}</p>
                    <div class="badge-info">عميل</div>
                  </div>
                  <div class="content">
                    <div class="d-flex justify-content-between ">
                      <div class="header-box">
                        <div class="item">
                          رقم الطلب : <span class="count">{{ $order->id }}</span>

                        </div>
                        <div class="item">
                          <i class="fa-solid fa-calendar-day"></i>
                          {{ $order->created_at->format('Y-m-d') }}
                        </div>

                        <div class="item">
                          <i class="fa-solid fa-calendar-days"></i>
                          {{ $order->created_at->diffForHumans() }}
                        </div>
                      </div>
                      @if($order->encrypted)
                      <button type="button" class=" order-dis" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="هذا الطلب مشفر يمكنك طلب الدخول من العميل وسيتم ارسال الكود عبر المنصة عند الموافقة"><i class="fa-solid fa-exclamation fa-shake"></i></button>
                      @endif
                    </div>
                    <div class="hr my-3"></div>
                    <div class="bar-sections">
                      <div class="bar"></div>
                      <div class="btn-section my-3">
                        {{ $order->mainDepartment?->name }}
                      </div>
                      @if($order->department_id)
                      <div class="btn-section">
                        {{ $order->department?->name }}
                      </div>
                      @else
                      <div class="btn-section my-3">
                        {{ $order->other_department }}
                      </div>
                      @endif
                    </div>
                    <div class="footer-box">

                      <a href="{{ route('judger.orders.show',$order->hash_code) }}"
                        class="btn-icon-cr  btn-gradient-blue btn">
                        {{ __($order->status) }}
                        <i class="fas fa-long-arrow-alt-left"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
