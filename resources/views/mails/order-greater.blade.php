<!DOCTYPE html>
<html>
<head>
    <title>طلب قيمته أكبر من 1000 ريال</title>
</head>
<body>
    <h3><a href="{{ route('admin.orders.show',$order->hash_code) }}"> الطلب {{ $order->id}} قيمته أكبر من 1000 ريال </a></h3>
    <strong>شكرا لك</strong>
</body>
</html>