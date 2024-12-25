@extends('admin.layouts.admin')
@section('title', 'إشعارات الاعضاء')
@section('content')
    <section class="">
        <div class="main-title">
            <div class="small">
                الاشعارات
            </div>
            <div class="large">
                الاشعارات الإداراية
            </div>
        </div>
        <div class="section_content content_view">
            @if ($notifications->count() > 0)
            <form action="{{ route('admin.notifications.AdminDeleteAll',request()->query()) }}" method="POST">
                @csrf
                <button class="btn btn-danger" style="position: absolute; left: 35px;" onclick="return confirm('هل أنت متأكد من الحذف ؟')">حذف الكل</button>
            </form>
            @endif
            <form action="{{ route('admin.notifications.deleteSelected') }}" method="post">
                @csrf
                <div class="info_holder d-flex align-items-center gap-2 mb-2">
                    @if ($notifications->count() > 0)
                        <button class="btn btn-danger" onclick="return confirm('هل أنت متأكد من الحذف ؟')">حذف المحدد</button>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="main-table mb-2">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاشعار</th>
                                <th>الوقت</th>
                                <th><input type="checkbox" id="checkall"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notifications as $notification)
                                    <tr>
                                        <td>{{ $loop->iteration }}</th>
                                        <td>{{ $notification->title }}</td>
                                        <td>{{ $notification->created_at }}</td>
                                        <td><input type="checkbox" class="checkbox" name="ids[]"
                                                value="{{ $notification->id }}">
                                        </td>
                                    </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{ $notifications->links() }}
                </div>
            </form>

        </div>
    </section>

    @push('js')
        <script src="https://code.jquery.com/jquery-3.6.1.min.js"
            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

        <script>
            $("#checkall").click(function() {
                if ($("#checkall").is(':checked')) {
                    $(".checkbox").each(function() {
                        $(this).prop("checked", true);
                    });
                } else {
                    $(".checkbox").each(function() {
                        $(this).prop("checked", false);
                    });
                }
            });
        </script>
    @endpush


@endsection
