<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title')</title>

  <!-- Normalize -->
  <link rel="stylesheet" href="{{ asset('front-assets/css/normalize.css') }}" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="{{ asset('front-assets/css/bootstrap.min.css') }}" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('front-assets/css/all.min.css') }}" />
  <!-- Main File Css  -->
  <link rel="stylesheet" href="{{ asset('front-assets/css/main.css') }}" />
  <!-- Font Google -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@500;600;700;800&display=swap"
    rel="stylesheet" />
  <script src="{{asset('js/axios.js')}}"></script>
  <script src="{{asset('js/vue.js')}}"></script>

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-L80P12XY8F"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-L80P12XY8F');
  </script>

  <!-- Google Tag Manager -->
  <script>
    (function(w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-ML5ZG35');
  </script>
  <!-- End Google Tag Manager -->

  <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-ML5ZG35" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  @stack('css')
</head>

<body>
