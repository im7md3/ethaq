<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Normalize -->
    <link rel="stylesheet" href="{{ asset('front-assets') }}/css/normalize.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('front-assets') }}/css/bootstrap.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('front-assets') }}/css/all.min.css" />
    <!-- Main Faile Css  -->
    <link rel="stylesheet" href="{{ asset('front-assets') }}/css/home.css" />
    <!-- Font Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@500;600;700;800&display=swap"
        rel="stylesheet" />
    <title>@yield('title', env('APP_NAME'))</title>

    @stack('css')
</head>

<body>
<div class="loader_layout" id="loader">
        <h2 class="brand">
            <img class="img-user" src="{{asset('front-assets')}}/img/global/ethaq-logo.png" alt="" />
        </h2>
        <div class="loading-bar"></div>
    </div>
    <div class="scrl-support">
        <div class="shere tog-active support">
            <div class="img"><img src="{{ asset('front-assets') }}/img/global/Asset 15@5x.png" alt=""></div>
            <div class="shere-list">
                <a target="_blank" href="{{ setting('twitter') }}" class="shere-item">
                    <i class="fab fa-twitter"></i>
                </a>
                <a target="_blank" href="{{ setting('facebook') }}" class="shere-item">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a target="_blank" href="{{ setting('linkedin') }}" class="shere-item">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a target="_blank" href="{{ setting('instagram') }}" class="shere-item">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="{{ route('tickets.index') }}" class="shere-item">
                    <img src="{{ asset('front-assets') }}/img/global/Asset 13@5x.png" alt="">
                </a>
            </div>
        </div>
    </div>

    @yield('content')
    <div class="our-member my-3">
        <div class="container">
            <div class="row g-3 justify-content-center">
                <div class="col-12 col-md-3">
                    <a href="https://apps.apple.com/sa/app/%D8%A5%D9%8A%D8%AB%D8%A7%D9%82-%D9%84%D9%84%D8%B9%D9%85%D9%84%D8%A7%D8%A1/id1673354000?l=ar&platform=iphone"
                        target="_blank">
                        <div class="box-ser">
                            <div class="img-holder">
                                <img src="{{ asset('front-assets') }}/img/global/client-img.png" alt="ser photo">
                            </div>
                            <p class="text">
                                إيثاق للعملاء
                            </p>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-3">
                    <a href="https://apps.apple.com/sa/app/%D8%A5%D9%8A%D8%AB%D8%A7%D9%82-%D9%84%D9%84%D9%85%D8%AD%D8%A7%D9%85%D9%8A%D9%86/id1671407635?l=ar&platform=iphone"
                        target="_blank">
                        <div class="box-ser">
                            <div class="img-holder">
                                <img src="{{ asset('front-assets') }}/img/global/lawyer-img.png" alt="ser photo">
                            </div>
                            <p class="text">
                                إيثاق للمحامين
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="app-box py-4">
        <div class="container">
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <div class="install-app">
                        <h4 class="install">حمل التطبيق الخاص بنا</h4>
                        <p class="shop">من المتجر المناسب لكم</p>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <a href="https://play.google.com/store/apps/developer?id=ethaq&hl=ar&gl=US&pli=1"
                            target="_blank">
                            <img class="" src="{{ asset('front-assets') }}/img/global/play.png"
                                alt="google play">
                        </a>
                        <a href="https://apps.apple.com/sa/app/%D8%A5%D9%8A%D8%AB%D8%A7%D9%82-%D9%84%D9%84%D8%B9%D9%85%D9%84%D8%A7%D8%A1/id1673354000?l=ar&platform=iphone"
                            target="_blank">
                            <img class="" src="{{ asset('front-assets') }}/img/global/app.png" alt="app store">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="main-footer py-5">
        <div
            class="container d-flex align-items-center justify-content-center justify-content-sm-between gap-3 flex-column flex-md-row">
            <div class="d-flex align-items-center gap-3">
                <!-- <img src="{{ asset('front-assets') }}/img/global/ethaq-logo.png" alt="" class="logo" /> -->
                <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
                    <a href="{{ route('politics') }}">سياسة الأستخدام و الخصوصية</a>
                    <a href="{{ route('contact') }}">أتصل بنا</a>
                    <a href="#">من إيثاق؟</a>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3 flex-column">
                <b>جميع الحقوق محفوظة إيثاق 2022</b>
            </div>
        </div>
    </footer>
    <!-- End Footer -->
    <!-- Js Files -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/all.min.js') }}"></script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-CSZS8KB01D"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-CSZS8KB01D');
    </script>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-16502949957">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-16502949957');
</script>
    <!--Start of Tawk.to Script-->
    <!-- <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/62da651254f06e12d88ac6ff/1g8ihlk8d';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script> -->
    @stack('js')
    <!--End of Tawk.to Script-->
</body>

</html>
