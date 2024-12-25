@extends('admin.layouts.admin')
@section('title','إضافة طلب')
@section('content')
<section class="" id="app">
    @php
    $departments=App\Models\Department::all();
    @endphp
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb bg-light p-3">
            <li href="" class="breadcrumb-item" aria-current="page">
                اضافة طلب
            </li>
        </ol>
    </nav>
    <div class="content_view">
        <div class="row row-gap-24">
            <div class="col-md-6">
                <label for="" class="small-label"> البحث عن عميل </label>
                <div class="select-drop">
                    <input type="text" v-model="clientInp" @input="searchData('clientSearch','clientInp')" class="form-control">
                    <div v-if="typeof clientSearch == 'object' && clientSearch.length >= 1" class="list-drop">
                        <button v-for="(user,i) in clientSearch" :key="i" @click="selectUser(user,'client','clientSearch','clientInp')" class="item">@{{user.name}}</button>
                    </div>
                    <div v-else-if="clientSearch === 'loder'" class="list-drop p-3">
                        <div class="spinner-border text-main-color mx-auto" role="status">
                    </div>
                    </div>
                    <div v-else-if="clientSearch === 'notUser'" class="list-drop p-3">
                        <h6 class="m-0 text-center">
                            لا يوجد مستخدم بهذا الأسم
                        </h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="" class="small-label"> البحث عن محامي </label>
                <div class="select-drop">
                    <input type="text" v-model="vendorInp" @input="searchData('vendorSearch','vendorInp')" class="form-control">
                    <div v-if="typeof vendorSearch == 'object' && vendorSearch.length >= 1" class="list-drop">
                        <button v-for="(user,i) in vendorSearch" :key="i" @click="selectUser(user,'vendor','vendorSearch','vendorInp')" class="item">@{{user.name}}</button>
                    </div>
                    <div v-else-if="vendorSearch === 'loder'" class="list-drop p-3">
                        <div class="spinner-border text-main-color mx-auto" role="status">
                    </div>
                    </div>
                    <div v-else-if="vendorSearch === 'notUser'" class="list-drop p-3">
                        <h6 class="m-0 text-center">
                            لا يوجد مستخدم بهذا الأسم
                        </h6>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <form action="{{ route('admin.orders.store') }}" method="POST" enctype="multipart/form-data">
            <div class="row row-gap-24">
                @csrf
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> القسم الرئيسي </label>
                    <select name="" class="form-control" v-model='main_department_id'>
                        <option value="">أختر القسم الرئيسي</option>
                        @foreach ($departments->whereNull('parent') as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> القسم الفرعي </label>
                    <select name="main_department_id" class="form-control" v-model='sub_department_id'>
                        <option value="">أختر القسم الفرعي</option>
                        <option :value="sub.id" v-for="sub in sub_departments" :key="sub.id">@{{ sub.name }}</option>
                    </select>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> القسم الثالث </label>
                    <select name="department_id" class="form-control">
                        <option value="">أختر القسم الثالث</option>
                        <option :value="third.id" v-for="third in third_departments" :key="third.id">@{{ third.name }}
                        </option>
                    </select>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> العميل </label>
                    <!-- <select name="client_id" class="form-control">
                        <option value="">أختر العميل</option>
                        @foreach (App\Models\User::clients()->get() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select> -->
                    <input type="text" v-model="client.name" class="form-control" disabled>
                    <input type="hidden" name="client_id" v-model="client.id" name="">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> المحامي </label>
                    <!-- <select name="vendor_id" class="form-control">
                        <option value="">أختر المحامي</option>
                        @foreach (App\Models\User::vendors()->get() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select> -->
                    <input type="text" v-model="vendor.name" class="form-control" disabled>
                    <input type="hidden" name="vendor_id" v-model="vendor.id" name="">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label">عنوان الطلب <span class="text-danger">*</span></label>
                    <input type="text" required name="title" class="form-control" value="{{ old('title') }}">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label">تفاصيل الطلب <span class="text-danger">*</span></label>
                    <textarea type="text" required name="details" class="form-control">{{ old('details') }}</textarea>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label"> حالة الطلب </label>
                    <select name="status" class="form-control" v-model='status'>
                        <option value="">أختر حالة الطلب</option>
                        <option value="archive">مسودة</option>
                        <option value="pending">بالانتظار</option>
                        <option value="open">مفتوح</option>
                        <option value="close">مغلق</option>
                        <option value="refused">مرفوض</option>
                        <option value="request_done">تم طلب التسليم'</option>
                        <option value="done">تم التسليم</option>
                    </select>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3" v-if="status=='refused'">
                    <label for="" class="small-label">سبب الرفض <span class="text-danger">*</span></label>
                    <textarea type="text" required name="refused_msg"
                        class="form-control">{{ old('refused_msg') }}</textarea>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3" >
                    @include('components.attach')
                    <attach-form name='images' id="1" ></attach-form>
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
        status:"",
        departments:[],
        main_department_id:"",
        sub_department_id:"",
        clientSearch:"",
        clientInp:"",
        client:"",
        vendorSearch:"",
        vendorInp:"",
        vendor:"",
    },
    computed:{
                sub_departments(){
                    return this.departments.filter((e)=>e.parent==this.main_department_id);
                },
                third_departments(){
                    return this.departments.filter((e)=>e.parent==this.sub_department_id);
                },

            },
    methods: {
        async searchData(data, inp) {
            if (this[inp].length >= 1) {
                this[data] = 'loder';
                try {
                const response = await axios.get(`/api/general/${data}?name=${this[inp]}`);
                if (response.data.data.length >= 1) {
                    this[data] = response.data.data;
                } else {
                    this[data] = 'notUser';
                }
                } catch (error) {
                console.error('حدث خطأ في الطلب:', error);
                }
            } else {
                this[data] = "";
            }
        },
        selectUser(data, inp, search, userInp) {
            this[inp] = data;
            this[search] = '';
            this[userInp] = data.name;
        }
    },
    mounted(){
        this.departments={!! $departments !!}
    }

});
</script>
@endpush
@endsection
