<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title',setting('website_name'))</title>
    <!-- Normalize -->
    <link rel="stylesheet" href="{{asset('admin-assets/css/normalize.css')}}" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset('admin-assets/css/bootstrap.rtl.min.css')}}" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('admin-assets/css/all.min.css')}}" />
    <!-- Main Faile Css  -->
    <link rel="stylesheet" href="{{asset('admin-assets/css/main.css')}}" />
    <!-- Font Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <script src="{{asset('js/vue.js')}}"></script>
    <script src="{{asset('js/axios.js')}}"></script>

    @stack('css')
</head>

<body>
    <div class="loader_layout" id="loader">
        <h2 class="brand">
            <img class="img-user" src="{{asset('front-assets')}}/img/global/ethaq-logo.png" alt="" />
        </h2>
        <div class="loading-bar"></div>
    </div>
