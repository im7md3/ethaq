@php
$pending_activation = App\Models\User::whereHas('license', function ($q) {
$q->where('status', 'pending');
})
->orWhereHas('commercial', function ($q) {
$q->where('status', 'pending');
})->orWhereHas('advisorFile', function ($q) {
$q->where('status', 'pending');
})
->count();
$specialServices=App\Models\SpecialService::where('status','pending')->count();
@endphp
<nav class="main-navbar">
    <div
      class="container-fluid d-flex align-items-lg-center align-items-stretch  flex-column flex-xl-row gap-3 justify-content-between">
      <div class="logo">
        <div class="tog-active d-block d-lg-none" data-tog="true" data-active=".app">
          <i class="fas fa-bars"></i>
        </div>
        <img src="{{ asset('admin-assets/img') }}/logo.svg" class="img" alt="" />
        <div class="text d-none d-lg-block">
          إيثاق منصة قانونية
        </div>
      </div>
      <div class="d-flex align-items-center gap-2rem">
        <div class="list-item d-none d-lg-flex">
          @can('read_licenses')
                <a href="{{ route('admin.user.active_requests') }}" class="main-btn btn-orange">
                    <span class="main-badge">{{ $pending_activation }}</span>
                    تراخيص وسجلات بانتظار التحقق
                    <img src="{{ asset('admin-assets/img') }}/icons/user-white.svg" alt="" class="icon" />
                </a>
                @endcan
          @can('read_orders')
                <a href="{{ route('admin.orders.index') }}" class="main-btn">
                    الطلبات الحديثة
                    <img src="{{ asset('admin-assets/img') }}/icons/bell-white.svg" alt="" class="icon" />
                </a>
                @endcan
                <a href="{{ route('admin.specialServices.index') }}" class="main-btn btn-orange">
                  <span class="main-badge">{{ $specialServices }}</span>
                  خدمات خاصة
                  <img src="{{ asset('admin-assets/img') }}/icons/user-white.svg" alt="" class="icon" />
              </a> 
        </div>
        <div class="d-flex align-items-center gap-2rem">
          <div class="dropdown icon-nav">
          <div class="main-badge badge-info">@auth{{ auth()->user()->unreadNotifications->count() }}@endauth</div>
            <button class="dropdown-toggle icon-nav" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
              aria-expanded="false">
              <img src="{{ asset('admin-assets/img') }}/icons/msg.svg" alt="" class="icon" />
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            @auth
                    @foreach (auth()->user()->unreadNotifications->take(5)->get() as $notification)
                    <li>
                        <a class="dropdown-item text-right" href="{{ $notification->link }}">
                            {{$notification->title}}
                        </a>
                    </li>
                    @endforeach
                    @endauth
            </ul>
          </div>
          <div class="dropdown icon-nav">
            <div class="main-badge">0</div>
            <button class="dropdown-toggle icon-nav" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
              aria-expanded="false">
              <img src="{{ asset('admin-assets/img') }}/icons/bell.svg" alt="" class="icon" />
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <li><a class="dropdown-item" href="#"></a></li>
              <li></li>
            </ul>
          </div>
        </div>
        <div class="dropdown info-user ms-auto">
          <button class="dropdown-toggle d-flex align-items-center gap-2 content" type="button" id="dropdownMenuButton1"
            data-bs-toggle="dropdown" aria-expanded="false">
            <div class="text">
              <div class="name">
                <i class="fas fa-angle-down"></i>
                الادارة
              </div>
              <div class="dic">
                المدير المسئول
              </div>
            </div>
            <div class="img">
              <img src="{{ asset('admin-assets/img') }}/icons/user-black.svg" alt="" class="icon" />
            </div>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li> <form action="{{ route('logout') }}" method="post" id="logout-form">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            تسجيل الخروج
                        </button>
                    </form></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
{{-- {{ dd(auth()->user()->unreadNotifications()->get()) }} --}}
{{-- {{ dd(auth()->user()->unreadNotifications()->get()) }} --}}
