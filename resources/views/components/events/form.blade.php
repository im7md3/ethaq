<form action="{{ route($user->type.'.events.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="user_id" value="{{ $user->id }}">
    <input type="hidden" name="order_id" value="{{ $order->id }}">
    <input type="hidden" name="type" value="question">
    <input type="hidden" name="parent" value="{{ $event->id }}">
    <attach-form name='content' id="{{ $event->id }}" show=true place="الجواب على الرد">
    </attach-form>
</form>