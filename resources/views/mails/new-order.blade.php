<!DOCTYPE html>
<html>
<head>
    <title>طلب جديد</title>
</head>
<body>
    <h3><a href="{{ route('admin.orders.show',$order->hash_code) }}">طلب جديد برقم {{ $order->id }}</a></h3>
    <strong>شكرا لك</strong>
</body>
</html>