<!DOCTYPE html>
<html>
<head>
    <title>{{ __($user->type) }} جديد</title>
</head>
<body>
    <h3><a href="{{ route('admin.'.$user->type.'s.show', $user->id) }}">تم تسجيل {{ __($user->type) }} جديد</a></h3>
    <div class="row">
        <div class="col-md-3">الاسم: {{ $user->name }}</div>
        <div class="col-md-3">رقم الجوال: {{ $user->phone }}</div>
        <div class="col-md-3">البريدي الالكتروني: {{ $user->email }}</div>
    </div>
    <strong>شكرا لك</strong>
</body>
</html>