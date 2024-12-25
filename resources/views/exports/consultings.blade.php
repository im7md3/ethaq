<table class="main-table">
    <thead>
        <tr>
            <th>رقم</th>
            <th>القسم</th>
            <th>حالة الاستشارة</th>
            <th>العميل</th>
            <th>المحامي</th>
            <th>المبلغ</th>
            <th>حالة الدفع</th>
            <th>التاريخ</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($consultings as $con)
            <tr>
                <td>{{ $con->id }}</td>
                <td>{{ $con->department?->name }}</td>
                <td>{{ __($con->status) }}</td>
                <td>{{ $con->client?->name }}</td>
                <td>{{ $con->vendor?->name ?? 'لم يحدد بعد' }}</td>
                <td>{{ $con->amount ?? 'لم يحدد بعد' }}</td>
                <td>
                    @if ($con->vendor_id)
                        @if ($con->invoices?->status == 'paid')
                            تم الدفع
                        @else
                            بانتظار العميل سداد الفاتورة
                        @endif
                    @endif
                </td>
                <td>{{ $con->created_at }}</td>
            </tr>
        @endforeach

    </tbody>
</table>
