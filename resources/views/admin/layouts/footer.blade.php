<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/all.min.js')}}"></script>
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
@stack('js')
</body>
</html>