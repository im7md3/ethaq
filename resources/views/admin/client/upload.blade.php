@if ($client->type == 'vendor' || $client->membership == 'company' )
@if ($client->type != 'judger')

<section class="height-section ">
    <div class="container">
        {{-- <div class="alert alert-danger py-2 mb-3" role="alert">
            لكي يتم تفعيل كل الخدمات يجيب رفع المستندات والبينات المطلوبة
        </div> --}}
        <div class="row row-gap-24">
            <div class="col-md-6">
                <div class="bg-white p-3 rounded shadow">
                    @if($client->license?->status=='refused')
                    <div class="alert alert-danger py-2 mb-1" role="alert">
                        تم رفض الترخيص بسبب {{ $client->license?->refused_msg }}
                    </div>
                    @endif
                    {{-- {{ $client->license->end_at }} --}}
                    @if($client->HasActiveLicense)
                    @if ($client->license?->status=='pending')
                    <div class="alert alert-warning py-2 mb-1" role="alert">
                        جاري مراجعة البينات والتحقق
                    </div>

                    @endif
                    <div class="alert alert-info py-2 mb-0" role="alert">
                        متبقى على انتهاء الترخيص {{
                        Carbon::createFromDate($client->license?->end_at)->diffInDays(Carbon::now()) }} يوم
                    </div>
                    <div class="row row-gap-24">
                        <div class="col-md-6">
                            <label for="" class="small-label">رقم الرخصة</label>
                            <input type="text" readonly class="form-control" value=" {{ $client->license?->name }}">
                        </div>
                        <div class="col-md-6">
                            <label for="" class="small-label">تاريخ الانتهاء</label>
                            <input type="text" readonly class="form-control" value="{{ $client->license?->end_at }}">
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-2 align-items-center ">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#editLicens">
                                    تعديل
                                </button>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="editLicens" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">تعديل الرخصة</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.license.update',$client->license?->id) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf @method('PUT')
                                            <div class="modal-body">
                                                <input type="hidden" name="user_id" value="{{ $client->id }}" id="">
                                                <div class="col-md-12">
                                                    <label for="" class="small-label"> رقم الرخصة</label>
                                                    <input type="text" class="main-inp form-control" name="name" id="" value="{{ $client->license?->name }}">
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="" class="small-label">الرخصة</label>
                                                    <input type="file" class="main-inp form-control" name="license"
                                                        id="">
                                                        <img src="{{ display_file( $client->license?->file ) }}" width="100" alt="">
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="" class="small-label">تاريخ الانتهاء</label>
                                                    <input type="date" class="main-inp form-control" name="end_at" id=""
                                                        min="{{ now()->addDay()->format('Y-m-d') }}" value="{{ $client->license?->end_at }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">إلغاء</button>
                                                <button type="submit" class="btn btn-primary">حفظ</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-2 align-items-center justify-content-end">
                                <label for="" class="small-label d-block mb-0">الرخصة</label>
                                <a href="{{ display_file($client->license?->file) }}" target="_blank"
                                    class="btn btn-sm btn-success">عرض </a>
                            </div>
                        </div>
                    </div>
                    @else
                    <form class="row row-gap-24" action="{{ route('admin.license') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $client->id }}" id="">
                        <div class="col-md-12">
                            <label for="" class="small-label">اسم الرخصة</label>
                            <input type="text" class="main-inp form-control" name="name" id="">
                        </div>
                        <div class="col-md-12">
                            <label for="" class="small-label">الرخصة</label>
                            <input type="file" class="main-inp form-control" name="license" id="">
                        </div>
                        <div class="col-md-12">
                            <label for="" class="small-label">تاريخ الانتهاء</label>
                            <input type="date" class="main-inp form-control" name="end_at" id=""
                                min="{{ now()->addDay()->format('Y-m-d') }}">
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <button type="submit" class="btn btn-success">ارسال</button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
            @company
            <div class="col-md-6">
                <div class="bg-white p-3 rounded shadow">
                    @if($client->commercial?->status=='refused')
                    <div class="alert alert-danger py-2 mb-1" role="alert">
                        تم رفض السجل بسبب {{ $client->commercial?->refused_msg }}
                    </div>
                    @endif
                    @if($client->HasActiveCommercial)
                    @if ($client->commercial?->status=='pending')
                    <div class="alert alert-warning py-2 mb-1" role="alert">
                        جاري مراجعة البينات والتحقق
                    </div>
                    @endif
                    <div class="alert alert-info py-2 mb-0" role="alert">
                        متبقى ع انتهاء الترخيص {{
                        Carbon::createFromDate($client->commercial?->end_at)->diffInDays(Carbon::now()) }} يوم
                    </div>
                    <div class="row row-gap-24">
                        <div class="col-md-12">
                            <label for="" class="small-label">الاسم</label>
                            <input type="text" readonly class="form-control" value=" {{ $client->commercial?->name }}">
                        </div>
                        <div class="col-md-12">
                            <label for="" class="small-label">تاريخ الانتهاء</label>
                            <input type="text" readonly class="form-control" value="{{ $client->commercial?->end_at }}">
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex gap-2 align-items-center justify-content-end">
                                <label for="" class="small-label mb-0 d-block">السجل</label>
                                <a href="{{ display_file($client->commercial?->file) }}" target="_blank"
                                    class="btn btn-sm btn-success">عرض </a>
                            </div>
                        </div>
                    </div>
                    @else
                    <form class="row row-gap-24" action="{{ route($client->type.'.commercial') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $client->id }}" id="">
                        <div class="col-md-12">
                            <label for="" class="small-label">اسم السجل</label>
                            <input class="main-inp form-control" type="text" name="name" id="">
                        </div>
                        <div class="col-md-12">
                            <label for="" class="small-label">السجل التجاري</label>
                            <input class="main-inp form-control" type="file" name="commercial" id="">
                        </div>
                        <div class="col-md-12">
                            <label for="" class="small-label">تاريخ الانتهاء</label>
                            <input class="main-inp form-control" type="date" name="end_at"
                                min="{{ now()->addDay()->format('Y-m-d') }}">
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <button class="btn btn-success" type="submit">ارسال</button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="bg-white p-3 rounded shadow">
                    @if($client->contract)
                    <div class="row row-gap-24">
                        <div class="col-md-6">
                            <label for="" class="small-label">اسم المسؤول</label>
                            <input type="text" readonly value="{{ $client->company_name }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="" class="small-label">رقم المسؤول</label>
                            <input type="text" readonly value="{{ $client->company_number }}" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex gap-2 align-items-center justify-content-end">
                                <a href="{{ display_file($client->contract) }}" target="_blank"
                                    class="btn btn-sm btn-success">عرض </a>
                            </div>
                        </div>
                    </div>
                    @else
                    <form class="row row-gap-24" action="{{ route($client->type.'.company.info') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $client->id }}" id="">
                        <div class="col-md-6">
                            <label for="" class="small-label">اسم المسؤول</label>
                            <input class="main-inp form-control" type="text" name="company_name" id="">
                        </div>
                        <div class="col-md-6">
                            <label for="" class="small-label">رقم المسؤول</label>
                            <input class="main-inp form-control" type="text" name="company_number" id="">
                        </div>
                        <div class="col-md-6">

                            <label for="" class="small-label">عقد التأسيس</label>
                            <input class="main-inp form-control" type="file" name="file" id="">
                        </div>

                        <div class="col-12 d-flex justify-content-center">
                            <button class="btn btn-success" type="submit">ارسال</button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
            @endcompany
        </div>
    </div>
</section>
@else

@endif
@endif
