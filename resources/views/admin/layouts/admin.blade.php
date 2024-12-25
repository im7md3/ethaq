@include('admin.layouts.head')
@include('admin.layouts.nav')
<div class="app">
    @include('admin.layouts.sidebar')
    <div class="main-side">
            <x-messages></x-messages>
            @yield('content')
    </div>
</div>
@include('admin.layouts.footer')
