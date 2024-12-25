<footer class="main-footer">
    <div class="container d-flex align-items-center justify-content-between gap-5  flex-column flex-md-row">
        <div class="d-flex align-items-center gap-3 justify-content-center flex-wrap">
            <a href="">سياسة الأستخدام و الخصوصية</a>
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
</footer>
<!-- End Footer -->
<!-- Js Files -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/all.min.js') }}"></script>
@include('sweetalert::alert')

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
            timer:10000,
            icon: type,
            title: message
        })
    })
    @if(session()->has('success'))
    Toast.fire({
        icon: "success",
        title: "{{session('success')}}"
    })
    @endif
</script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<!--Start of Tawk.to Script-->
<!-- <script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/62da651254f06e12d88ac6ff/1g8ihlk8d';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script> -->
<!--End of Tawk.to Script-->
@if(auth()->check())

<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

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
@stack('js')
</body>

</html>
