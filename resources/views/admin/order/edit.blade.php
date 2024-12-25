@extends('admin.layouts.admin')
@section('title', 'تعديل طلب')
@section('content')
    <section class="" id="app">
        @php
            $departments = App\Models\Department::all();
        @endphp
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb bg-light p-3">
                <li href="" class="breadcrumb-item" aria-current="page">
                    تعديل طلب
                </li>
            </ol>
        </nav>
        <div class="content_view">
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" enctype="multipart/form-data">
                <div class="row row-gap-24">
                    @csrf
                    @method('PUT')
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
                            <option :value="sub.id" v-for="sub in sub_departments" :key="sub.id">
                                @{{ sub.name }}</option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label for="" class="small-label"> القسم الثالث </label>
                        <select name="department_id" class="form-control" v-model='third_department_id'>
                            <option value="">أختر القسم الثالث</option>
                            <option :value="third.id" v-for="third in third_departments" :key="third.id">
                                @{{ third.name }}</option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label for="" class="small-label"> العميل </label>
                        <select name="client_id" class="form-control">
                            <option value="">أختر العميل</option>
                            @foreach (App\Models\User::clients()->get() as $user)
                                <option value="{{ $user->id }}" {{ $user->id == $order->client_id ? 'selected' : '' }}>
                                    {{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label for="" class="small-label">عنوان الطلب <span class="text-danger">*</span></label>
                        <input type="text" required name="title" class="form-control"
                            value="{{ old('title', $order->title) }}">
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label for="" class="small-label">تفاصيل الطلب <span class="text-danger">*</span></label>
                        <textarea type="text" required name="details" class="form-control">{{ old('details', $order->details) }}</textarea>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label for="" class="small-label"> حالة الطلب </label>
                        <select name="status" class="form-control" v-model='status'>
                            <option value="">أختر حالة الطلب</option>
                            <option value="archive" {{ $order->status == 'archive' ? 'selected' : '' }}>مسودة</option>
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>بالانتظار</option>
                            <option value="open" {{ $order->status == 'open' ? 'selected' : '' }}>مفتوح</option>
                            <option value="ongoing" {{ $order->status == 'ongoing' ? 'selected' : '' }}>تحت التنفيذ
                            </option>
                            <option value="close" {{ $order->status == 'close' ? 'selected' : '' }}>مغلق</option>
                            <option value="refused" {{ $order->status == 'refused' ? 'selected' : '' }}>مرفوض</option>
                            <option value="request_done" {{ $order->status == 'request_done' ? 'selected' : '' }}>تم طلب
                                التسليم'
                            </option>
                            <option value="done" {{ $order->status == 'done' ? 'selected' : '' }}>تم التسليم</option>
                            <option value="judger Decision" {{ $order->status == 'judger Decision' ? 'selected' : '' }}>
                                قرار
                                التحكيم</option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3" v-if="status=='refused'">
                        <label for="" class="small-label">سبب الرفض <span class="text-danger">*</span></label>
                        <textarea type="text" required name="refused_msg" class="form-control">{{ old('refused_msg', $order->refused_msg) }}</textarea>
                    </div>
                    {{-- <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="" class="small-label">تفعيل التشفير <span class="text-danger">*</span></label>
                    <input type="checkbox" name="encrypted" {{ $order->encrypted?'checked':'' }}>
                </div>   --}}
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label for="" class="small-label">ايقاف الطلب وامكانية استرداد المبلغ <span
                                class="text-danger">*</span></label>
                        <input type="checkbox" name="money_back" {{ $order->money_back ? 'checked' : '' }}>
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label for="" class="small-label">ملف العقد </label>
                        <input type="file" name="contract_file" class="form-control mb-2">
                        @if ($order->contract_file)
                            <a href="{{ display_file($order->contract_file) }}" target="_blank"
                                class="btn btn-sm btn-success">تحميل العقد</a>
                        @endif
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
                    status: "",
                    departments: [],
                    main_department_id: "",
                    sub_department_id: "",
                    third_department_id: "",
                },
                computed: {
                    sub_departments() {
                        return this.departments.filter((e) => e.parent == this.main_department_id);
                    },
                    third_departments() {
                        return this.departments.filter((e) => e.parent == this.sub_department_id);
                    },

                },
                methods: {

                },
                mounted() {
                    this.status = '{{ $order->status }}'
                    this.departments = {!! $departments !!}
                    this.main_department_id = 1
                    this.sub_department_id = '{{ $order->main_department_id }}'
                    this.third_department_id = '{{ $order->department_id }}'

                }

            });
        </script>
    @endpush
@endsection
