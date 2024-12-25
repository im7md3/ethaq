<form action="{{ route($user->type.'.storeMessage',$negotiation??0) }}" 
    enctype="multipart/form-data" method="POST" id="nego">
    @csrf
    <input type="hidden" name="order_id" value="{{ $order->id }}" id="">
    <input type="hidden" name="negotiation_id" value="{{ $negotiation->id??0 }}" id="">
    <input type="hidden" name="user_id" value="{{ $user->id }}" id="">
    <span class="mb-2">الاستفسار</span>
    <attach-form name='msg' id="2" show=true></attach-form>
</form>