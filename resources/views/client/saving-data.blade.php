@extends('client.layouts.client')
@section('title','الاعدادات')
@section('content')
<section class="height-section py-5 saving-data">
    <div class="container ">
    <form action="" method="POST" class="container">
                        <div class="row row-gap-24">
                            <div class="col-xl-3">
                                <div class="mb-1"> الأسم الأول<span class="text-danger">*</span></div>
                                <input type="text" name="name" class="main-inp " value="">
                            </div>
                            <div class="col-xl-3">
                                <div class="mb-1"> أسم العائلة<span class="text-danger">*</span></div>
                                <input type="text" name="name" class="main-inp" value="">
                            </div>
                            <div class="col-xl-3">
                                <div class="mb-1"> المدينة  <span class="text-danger">*</span></div>
                                <div class="box-inp">
                                    <select name="city_id" class="inp">
                                        <option value="">أختر المدينة</option>
                                                                                <option value="1" selected="">جدة</option>
                                                                                <option value="2">الرياض</option>
                                                                                <option value="3">القاهرة</option>
                                                                                <option value="4">دبي</option>
                                                                            </select>
                                    <div class="icon">
                                        <svg class="svg-inline--fa fa-angle-down" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg=""><path fill="currentColor" d="M192 384c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L192 306.8l137.4-137.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-160 160C208.4 380.9 200.2 384 192 384z"></path></svg><!-- <i class="fas fa-angle-down"></i> Font Awesome fontawesome.com -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="mb-1"> رقم الهوية <span class="text-danger">*</span></div>
                                <input type="text" name="id_number" class="main-inp" value="111">
                            </div>
                            <div class="col-xl-3">
                                <div class="mb-1"> تاريخ انتهاء الهوية <span class="text-danger">*</span></div>
                                <input type="date" name="birthdate" class="main-inp" value="">
                            </div>
                            <div class="col-12 mt-3 d-flex justify-content-end">
                                <button class="inp-sub ms-0" type="submit">
                                    حفظ
                                    <svg class="svg-inline--fa fa-angle-left" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M192 448c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l137.4 137.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448z"></path></svg><!-- <i class="fas fa-angle-left"></i> Font Awesome fontawesome.com -->
                                </button>
                            </div>
                        </div>
                </form>
    </div>
</section>
@endsection
