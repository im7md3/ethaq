@extends('admin.layouts.admin')
@section('title','تعديل مشرف')
@section('content')
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb bg-light p-3">
            <li href="" class="breadcrumb-item" aria-current="page">
                تعديل مشرف
            </li>
        </ol>
    </nav>
    <div class="content_view">
        <form action="{{ route('admin.admins.update',$admin) }}" method="POST" enctype="multipart/form-data">
            <div class="row row-gap-24">
                @csrf
                @method('PUT')
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label">الاسم </label>
                    <input type="text" name="name" value="{{ $admin->name }}" class="form-control" >
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> الجنس </label>
                    <select name="gender" class="form-control" >
                        <option value="">أختر الجنس</option>
                        <option value="male" {{ $admin->gender=='male'?'selected':'' }}>ذكر</option>
                        <option value="female" {{ $admin->gender=='female'?'selected':'' }}>انثى</option>
                    </select>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label">البريد الالكتروني </label>
                    <input type="email" name="email" value="{{ $admin->email }}" class="form-control" >
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> رقم الجوال </label>
                    <input type="number" name="phone" value="{{ $admin->phone }}" class="form-control rmv-arw-inp" >
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> الباسورد </label>
                    <input type="password" name="password" class="form-control" >
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> الصورة الشخصية </label>
                    <input type="file" name="image"  class="form-control" >
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="">المجموعة</label>
                    <select class="form-control" name="group" id="">
                        <option value="">اختر المجموعة</option>
                        @foreach ($roles as $role)
                            <option {{ $admin->role?->id == $role->id ? 'selected' : '' }} value="{{ $role->id }}">
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 d-flex align-items-center justify-content-center mt-3">
                    <button type="submit" class="btn btn-success">حفظ</button>
                </div>
            </div>
        </form>
    </div>
@endsection
