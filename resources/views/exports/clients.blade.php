<table class="main-table mb-2">
    <thead>
        <tr>
            <th>#</th>
            <th>الاسم</th>
            <th>الجوال</th>
            <th>المدينة</th>
            <th>نوع العضوية</th>
            <th>حالة الاتصال</th>
            <th>الواتساب</th>
            <th>آخر دخول</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clients as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->city?->name }}</td>
                <td>{{ __($user->type) }}</td>
                <td><i
                        class="fa-solid fa-circle state_offline {{ Cache::has('user-is-online-' . $user->id) ? 'text-success' : 'text-secondary' }}"></i>
                </td>
                <td>
                    <a href="https://wa.me/{{ substr($user->phone, 1) }}" target="_blank" class="btn-whatsapp">
                       واتس اب
                    </a>
                </td>
                <td>{{ $user->last_seen_text }}</td>
            </tr>
        @endforeach

    </tbody>
</table>
