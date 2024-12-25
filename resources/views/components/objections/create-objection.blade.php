<p class="mb-0">
    أطلب أنا {{ $user->name }} إحالة العقد رقم {{ $order->id }} الى المحكم وفق ماتم الاتفاق عليه في العقد للفصل في محل
    النزاع مع {{ $other->name }} بسبب:
<div class="row ">
    <ul>
        <li v-for="(reason,i) in reasons" :key="i">
            @{{ reason }}
        </li>
        <li v-if="other">أخرى: @{{ other_text }}</li>
    </ul>
</div>
</p>