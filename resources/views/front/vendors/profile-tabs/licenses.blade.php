<div class="tab-pane fade" id="v-pills-licenses" role="tabpanel" aria-labelledby="v-pills-licenses-tab" tabindex="0">
    <h3 class="h5">
        التراخيص
    </h3>
    <div class="row row-gap-24">
        <div class="col-md-12">
            <div class="bg-white p-3 rounded shadow">
                @if($user->HasActiveLicense)
                <div class="row row-gap-24">
                    <div class="col-md-12">
                        <label for="" class="small-label">الاسم</label>
                        <input type="text" readonly class="form-control" value=" {{ $user->license?->name }}">
                    </div>
                </div>
                @endif
            </div>
        </div>
        @company
        <div class="col-md-12">
            <div class="bg-white p-3 rounded shadow">
                @if($user->HasActiveCommercial)

                <div class="row row-gap-24">
                    <div class="col-md-12">
                        <label for="" class="small-label">الرقم</label>
                        <input type="text" readonly class="form-control" value=" {{ $user->commercial?->name }}">
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-12 ">
            <div class="bg-white p-3 rounded shadow">
                @if($user->contract)
                <div class="row row-gap-24">
                    <div class="col-md-12">
                        <label for="" class="small-label">اسم المسؤول</label>
                        <input type="text" readonly value="{{ $user->company_name }}" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label for="" class="small-label">جوال المسؤول</label>
                        <input type="text" readonly value="{{ $user->company_number }}" class="form-control">
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endcompany
    </div>
</div>