@extends('admin.layouts.admin')
@section('title','إضافة مشرف')
@section('content')
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb bg-light p-3">
            <li href="" class="breadcrumb-item" aria-current="page">
                اضافة مشرف
            </li>
        </ol>
    </nav>
    <div class="content_view">
        <form action="{{ route('admin.admins.store') }}" method="POST" enctype="multipart/form-data">
            <div class="row row-gap-24">
                @csrf
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label">الاسم <span class="text-danger">*</span></label>
                    <input type="text" required  name="name" class="form-control"  value="{{ old('name') }}">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> الجنس </label>
                    <select name="gender" class="form-control" >
                        <option value="">أختر الجنس</option>
                        <option value="male">ذكر</option>
                        <option value="female">انثى</option>
                    </select>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label">البريد الالكتروني <span class="text-danger">*</span></label>
                    <input type="email" required  name="email" class="form-control"  value="{{ old('email') }}">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> رقم الجوال <span class="text-danger">*</span></label>
                    <input type="number" required  name="phone" class="form-control rmv-arw-inp"  value="{{ old('phone') }}">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> الباسورد </label>
                    <input type="password" name="password" class="form-control"  >
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> الصورة الشخصية </label>
                    <input type="file" name="image" class="form-control" >
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="">المجموعة</label>
                    <select class="form-control" name="group" id="">
                        <option value="">اختر المجموعة</option>
                        @foreach ($roles as $role)
                            <option  value="{{ $role->id }}">
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
