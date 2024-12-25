<table>
    <thead>
        <tr>
            <th>رقم</th>
            <th>العنوان</th>
            <th>القسم</th>
            <th>حالة الطلب</th>
            <th>العميل</th>
            <th>المحامي</th>
            <th>العروض</th>
            <th>الاعتراضات</th>
            <th>مبلغ العرض</th>
            <th>برايفت</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->title }}</td>
                <td>{{ $order->department?->name }}</td>
                <td>{{ __($order->status) }}</td>
                <td>{{ $order->client?->name }}</td>
                <td>{{ $order->vendor?->name ?? 'لم يحدد بعد' }}</td>
                <td>{{ $order->offers_count }}</td>
                <td>{{ $order->protests_count }}</td>
                <td>{{ $order->activeOffer?->amount }} ر.س</td>
                <td>
                    @if ($order->vendors->count() > 0)
                        نعم
                    @else
                        لا
                    @endif
                </td>
            </tr>
        @endforeach

    </tbody>
</table>