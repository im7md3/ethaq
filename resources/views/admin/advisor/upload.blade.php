@if ($advisor->type == 'vendor' || $advisor->membership == 'company' )
@if ($advisor->type != 'judger')

<section class="height-section ">
    <div class="container">
        <div class="col-md-6">
            <div class="bg-white p-3 rounded shadow">
                @if($advisor->advisorFile?->status=='refused')
                <div class="alert alert-danger py-2 mb-1" role="alert">
                    تم رفض المؤهل بسبب {{ $advisor->advisorFile?->refused_msg }}
                </div>
                @endif
                @if($advisor->HasActiveAdvisorFile)
                @if ($advisor->advisorFile?->status=='pending')
                <div class="alert alert-warning py-2 mb-1" role="alert">
                    جاري مراجعة البينات والتحقق
                </div>
                @endif
                <div class="row row-gap-24">
                    <div class="col-md-6">
                        <label for="" class="small-label">اسم المؤهل</label>
                        <input type="text" readonly class="form-control" value=" {{ $advisor->advisorFile?->name }}">
                    </div>
                    @if(setting('edit_documents'))
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
                                        <h5 class="modal-title" id="exampleModalLabel">تعديل المؤهل</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form
                                        action="{{ route($advisor->type.'.advisorFile.update',$advisor->advisorFile?->id) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf @method('PUT')
                                        <div class="modal-body">
                                            <input type="hidden" name="user_id" value="{{ $advisor->id }}" id="">
                                            <div class="col-md-12">
                                                <label for="" class="small-label"> اسم المؤهل</label>
                                                <input type="text" class="main-inp form-control" name="name" id=""
                                                    value="{{ $advisor->advisorFile?->name }}">
                                            </div>
                                            <div class="col-md-12">
                                                <label for="" class="small-label">الرخصة</label>
                                                <input type="file" class="main-inp form-control" name="attach"
                                                    id="">
                                                <img src="{{ display_file( $advisor->advisorFile?->file ) }}"
                                                    width="100" alt="">
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
                    @endif
                    <div class="col-md-6">
                        <div class="d-flex gap-2 align-items-center justify-content-end">
                            <label for="" class="small-label d-block mb-0">المؤهل</label>
                            <a href="{{ display_file($advisor->advisorFile?->file) }}" target="_blank"
                                class="btn btn-sm btn-success">عرض </a>
                        </div>
                    </div>
                </div>
                @else
                <form class="row row-gap-24" action="{{ route($advisor->type.'.advisorFiles') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}" id="">
                    <div class="col-md-6">
                        <label for="" class="small-label">اسم المؤهل</label>
                        <input type="text" class="main-inp" name="name" id="">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="small-label">الرخصة</label>
                        <input type="file" class="main-inp" name="attach" id="">
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <button type="submit" class="btn btn-success">ارسال</button>
                    </div>
                </form>
                @endif
            </div>
        </div>

    </div>
</section>
@else

@endif
@endif
