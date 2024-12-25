<section class="height-section section-chat py-4 d-flex align-items-center justify-content-center">
    <div class="container">
        <form action="{{ route('vendor.consulting.Access') }}" method="POST" class="row">
            @csrf
            <div class="col-12 col-md-12 text-center">
                <h5 class="">الدفع سيكون لاحقا بما يخص هذه الاستشارة</h5>
                <input type="hidden" name="consulting_id" value="{{ $con->id }}" id="">
                <input type="hidden" name="vendor_id" value="{{ $user->id }}" id="">
                <button type="submit" class="btn btn-sm btn-success px-5">موافق</button>
                <a href="{{ route('vendor.consulting.index') }}" class="btn btn-sm btn-danger px-5">رفض</a>
            </div>
        </form>
    </div>
</section>
