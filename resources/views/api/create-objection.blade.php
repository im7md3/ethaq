<p class="mb-0">
    أطلب أنا {{ $user->name }} إحالة العقد رقم {{ $order->id }} الى المحكم وفق ماتم الاتفاق عليه في العقد للفصل في محل
    النزاع مع {{ $other->name }} بسبب:
<div class="row ">
    <ul>
        @foreach ($reasons as $reason)
        <li>
            {{ $reason }}
        </li>
        @endforeach
        @if($other_reason)
        <li>أخرى: {{ $other_reason }}</li>
        @endif
    </ul>
</div>
</p>