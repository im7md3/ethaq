<table class="table main-table">
    <thead>
        <tr>
            <th colspan="2" class="text-center">الاسم</th>
            <th colspan="2" class="text-center">رقم الجوال</th>
            <th colspan="2" class="text-center">تاريخ التسجيل</th>
            <th colspan="2" class="text-center">آخر دخول</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($vendors as $vendor)
            <tr>
                <td colspan="2" class="text-end">{{ $vendor->name }}</td>
                <td colspan="2">{{ $vendor->phone }}</td>
                <td colspan="2">{{ $vendor->created_at }}</td>
                <td colspan="2">{{ $vendor->last_seen_text }}</td>
            </tr>
        @endforeach

    </tbody>
</table>
