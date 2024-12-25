@extends('admin.layouts.admin')
@section('title')
    اضافة اشعار للاعضاء
@endsection
@section('content')
    <div class="row" id="app">
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title pt-3">اضافة اشعار للاعضاء</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.notifications.store') }}" method="POST" class="row w-100"
                        enctype="multipart/form-data">
                        @csrf
                        @if ($user)
                            <p class="text-danger">إرسال إشعار للمستخدم {{ $user->name }}</p>
                            <input type="hidden" name="id" value="selected" id="">
                            <input type="hidden" name="user_id" value="{{ $user->id }}" id="">
                        @else
                            <div class="form-group">
                                <label for="id">اختيار الاعضاء</label>
                                <select class="form-control users_id" name="id" id="id">
                                    <option value="">اختر</option>
                                    <option value="0">ارسال لكل الاعضاء</option>
                                    <option value="client_individual">عميل</option>
                                    <option value="client_company">عميل شركة</option>
                                    <option value="vendor_individual">محامي</option>
                                    <option value="vendor_company">محامي شركة</option>
                                    <option value="judger">محكم</option>
                                </select>
                            </div>
                        @endif

                        <div class="form-group col-md-12 mb-2 ">
                            <label class="mb-1" for="notification">الرسالة </label>
                            {{-- <textarea name="notification" rows="6" id="notification" class="form-control"></textarea> --}}
                            <select name="notification" class="form-control">
                                <option value="">اختر</option>
                                @foreach ($alerts as $alert)
                                    <option value="{!! $alert->title !!}">{!! $alert->title !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary col-md-4 mt-3 rounded">ارسال</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
