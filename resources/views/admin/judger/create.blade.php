@extends('admin.layouts.admin')
@section('title', 'إضافة عضو')
@section('content')
    <section class="" id="app">
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb bg-light p-3">
                <li href="" class="breadcrumb-item" aria-current="page">
                    اضافة عضو
                </li>
            </ol>
        </nav>
        <div class="content_view">
            <form action="{{ route('admin.judgers.store') }}" method="POST" enctype="multipart/form-data">
                <div class="row row-gap-24">
                    @csrf
                    <input type="hidden" name="type" value="judger" id="">
                    <input type="hidden" name="membership" value="individual" id="">
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label for="" class="small-label">الاسم <span class="text-danger">*</span></label>
                        <input type="text" required name="name" class="form-control" value="{{ old('name') }}">
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label for="" class="small-label"> الجنس </label>
                        <select name="gender" class="form-control">
                            <option value="">أختر الجنس</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>انثى</option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label for="" class="small-label">تاريخ الميلاد </label>
                        <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate') }}">
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label for="" class="small-label">البريد الالكتروني <span
                                class="text-danger">*</span></label>
                        <input type="email"  name="email" class="form-control" value="{{ old('email') }}">
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label for="" class="small-label"> رقم الجوال <span class="text-danger">*</span></label>
                        <input type="number" required name="phone" class="form-control rmv-arw-inp"
                            value="{{ old('phone') }}">
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label for="" class="small-label"> رقم الهوية <span class="text-danger">*</span></label>
                        <input type="number" required name="id_number" class="form-control rmv-arw-inp"
                            value="{{ old('id_number') }}">
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label for="" class="small-label"> نهاية الهوية </label>
                        <input type="date" name="id_end" class="form-control rmv-arw-inp"  value="{{ old('id_end') }}">
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label for="" class="small-label"> الباسورد </label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label for="" class="small-label"> الصورة الشخصية </label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label for="" class="small-label"> الدولة </label>
                        <select name="country_id" class="form-control">
                            <option value="">أختر الدولة</option>
                            @foreach (App\Models\Country::all() as $country)
                                <option value="{{ $country->id }}" @if(old('country_id') == $country->id) selected @elseif($country->id==1) selected @endif
                                   >{{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3" v-if="type=='vendor' || type=='judger'">
                        <label for="" class="small-label"> سنوات الخبرة </label>
                        <input type="number" name="years_of_experience" max="99" class="form-control" onkeypress="if(this.value.length==2) return false;" >
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3" v-if="type=='vendor' || type=='judger'">
                        <label for="" class="small-label"> التخصص  </label>
                        <select name="specialty_id" class="form-control" >
                            <option value="">أختر التخصص </option>
                            @foreach (App\Models\Specialty::get() as $specialty)
                            <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3" v-if="type=='vendor' || type=='judger'">
                        <label for="" class="small-label"> المؤهل </label>
                        <select name="qualification_id" class="form-control" >
                            <option value="">أختر المؤهل</option>
                            @foreach (App\Models\Qualification::get() as $qualification)
                            <option value="{{ $qualification->id }}" >{{ $qualification->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <div class="col-sm-6 col-md-4 col-lg-3">
                        <label for="" class="small-label"> المدينة </label>
                        <select name="city_id" class="form-control">
                            <option value="">أختر المدينة</option>
                            @foreach (App\Models\City::all() as $city)
                                <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    {{-- <div class="col-sm-6 col-md-4 col-lg-3" v-if="membership=='company' && type=='client'">
                        <label for="" class="small-label"> اسم المسؤول </label>
                        <input type="text" name="company_name" class="form-control"
                            value="{{ old('company_name') }}">
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3" v-if="membership=='company' && type=='client'">
                        <label for="" class="small-label"> رقم المسؤول </label>
                        <input type="number" name="company_number" class="form-control"
                            value="{{ old('company_number') }}">
                    </div> --}}
                    <div class="col-12">
                        <div class="mb-1"> النبذة الشخصية <span class="text-danger">*</span></div> <textarea
                            placeholder="النبذة الشخصية" name="bio" maxlength="1000" class="form-control"></textarea>
                    </div>
                    <div class="col-12 d-flex align-items-center justify-content-center mt-3">
                        <button type="submit" class="btn btn-success">حفظ</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    @push('js')
        <script>
            let app = new Vue({
                el: "#app",
                data: {
                    type: '',
                    membership: ''
                },
                methods: {

                },

            });
        </script>
    @endpush
@endsection
