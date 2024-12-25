@extends('admin.layouts.admin')
@section('title')
اضافة مجموعة
@endsection
@section('content')

<section class="" id="app">
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb bg-light p-3">
            <li href="" class="breadcrumb-item" aria-current="page">
                اضافة مجموعة
            </li>
        </ol>
    </nav>
    <div class=" w-100 mx-auto p-3 shadow rounded-3  bg-white">
        <b>اضافة مجموعة</b>
        <hr>
        <form class=" row" action="{{ route('admin.roles.store') }}" method="POST">
            @csrf

            <div class="col-12">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group ">
                            <p class="mb-2">الاسم</p>
                            <div class="d-flex">
                                <input type="text" class=" form-control" name="name">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <label>الصلاحيات</label>
            <div>
                تحديد الكل : <input id="checkall" class='' type="checkbox">
            </div>
            <div class="card card-primary card-outline">
                <div class="card-body">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @foreach ($models as $index => $model)
                        <li class="nav-item">
                            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="custom-content-below-home-tab"
                                data-bs-toggle="pill" href="#{{ $model }}{{ $index }}" role="tab"
                                aria-controls="custom-content-below-home" aria-selected="true">{{ __($model)}}</a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="tab-content mt-2" id="custom-content-below-tabContent">
                        @foreach ($models as $index => $model)
                        <div class="tab-pane fade show {{ $index == 0 ? 'active' : '' }}" id="{{ $model }}{{ $index }}"
                            role="tabpanel" aria-labelledby="custom-content-below-home-tab">

                             @foreach (config()->get('permissionsname.models.'.$model) as $map)
                            <label><input type="checkbox" class="checkbox" name="permissions[]"
                                    value="{{ $map . '_' . $model }}">
                                {{ __($map) }}</label><br>
                            @endforeach
                        </div>
                        @endforeach

                    </div>
                    <!-- /.card -->
                </div>
                @error('permissions')
                <div class="text-danger text-bold">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12 mt-3 d-flex justify-content-end ">
                <button class="btn btn-primary">حفظ</button>
            </div>

        </form>


    </div>
</section>
    @endsection
