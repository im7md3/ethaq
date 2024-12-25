<!-- <div class="our-member my-3">
    <div class="container">
        <div class="row g-3 justify-content-center">
            <div class="col-12 col-md-3">
                <a href="#">
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
            <a href="#">
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
                <a href="https://play.google.com/store/apps/developer?id=ethaq&hl=ar&gl=US&pli=1" target="_blank">
                    <img class="" src="{{ asset('front-assets') }}/img/global/play.png" alt="google play">
                </a>
                <a href="#" target="_blank">
                    <img class="" src="{{ asset('front-assets') }}/img/global/app.png" alt="app store">
                </a>
            </div>
        </div>
      </div>
    </div>
  </div>
<footer class="main-footer">
  <div
    class="container d-flex align-items-center justify-content-center justify-content-sm-between gap-3 flex-column flex-md-row">
    <div class="d-flex align-items-center gap-3 justify-content-center flex-wrap">
      <a href="{{ route('politics') }}">سياسة الأستخدام و الخصوصية</a>
      <a href="{{ route('contact') }}">أتصل بنا</a>
      <a href="#">من إيثاق؟</a>
    </div>
    <div class="d-flex align-items-center gap-3 flex-column">
      <b>جميع الحقوق محفوظة إيثاق 2022</b>
    </div>
    <a href="" class="logo-sm">
      <img src="{{ asset('front-assets/img/global/Image-cr.webp') }}" alt="" />
    </a>
  </div>
</footer> -->
<!-- End Footer -->
<!-- Js Files -->

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/all.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
const Toast = Swal.mixin({
  toast: true,
  position: 'bottom',
  showConfirmButton: false,
  showCloseButton: true,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
});

window.addEventListener('alert', ({
  detail: {
    type,
    message
  }
}) => {
  Toast.fire({
    timer: 10000,
    icon: type,
    title: message
  })
})
@if(session() -> has('success'))
Toast.fire({
  icon: "success",
  title: "{{session('success')}}"
})
@endif
@if(session() -> has('warning'))
Toast.fire({
  icon: "warning",
  title: "{{session('warning')}}"
})
@endif
@if(session() -> has('error'))
Toast.fire({
  icon: "error",
  title: "{{session('error')}}"
})
@endif
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
<!--End of Tawk.to Script-->


<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-CSZS8KB01D"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-CSZS8KB01D');
</script>



<!-- Start Google tag (gtag.js) -->
<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-N3J9ZW8F84"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-N3J9ZW8F84');
</script> -->

<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-N3J9ZW8F84"></script>
<script>
window.dataLayer = window.dataLayer || [];

function gtag() {
  dataLayer.push(arguments);
}
gtag('js', new Date());

gtag('config', 'G-N3J9ZW8F84');
</script> -->
<!-- End Google tag (gtag.js) -->
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
@if(auth()->check())

<script>
    // Enable pusher logging - don't include this in production

    var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
        cluster: '{{env('PUSHER_APP_CLUSTER')}}'
    });

    var channel = pusher.subscribe('new-notification-{{auth()->id()}}');
    channel.bind('new-notification', function(data) {
        // app.messages.push(JSON.stringify(data));
        Swal.fire({
            title: data.notification.title,
            icon: 'info',
            html:
                '<a class="btn btn-success btn-sm text-nowrap" href="{{url('notifications')}}">عرض كل الاشعارات</a>',
            showConfirmButton: false,
            position:'top-start',
            padding:'13px',
            customClass:'swal-alert-info',
            showCloseButton: false,
            showCancelButton: false,
            focusConfirm: false,
        })
    });

</script>
@endif
<!-- bootstrap Tooltip -->
<script>
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
</script>
@stack('js')
</body>

</html>
