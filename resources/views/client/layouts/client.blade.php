@include('client.layouts.head')
@include('client.layouts.header')
<!-- check if user still online  -->
@if (auth()->check())
    <!-- keep online for 2 min -->
    {{ auth::user()->is_online() }}
@endif
<div class="loader_layout" id="loader">
        <h2 class="brand">
            <img class="img-user" src="{{asset('front-assets')}}/img/global/ethaq-logo.png" alt="" />
        </h2>
        <div class="loading-bar"></div>
</div>
<x-messages></x-messages>
@yield('content')
@include('client.layouts.footer')
