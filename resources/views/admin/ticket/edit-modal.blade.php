<div class="modal fade" id="edit{{ $ticket->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل تذكرة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.tickets.update', $ticket->id) }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')


                    <div class="form-group">
                        <label for="">العميل</label>
                        <select name="user_id" id="" class="form-control">
                            <option value="">اختر العميل</option>
                            @foreach (App\Models\User::whereIn('type', ['client', 'vendor', 'judger'])->get() as $client)
                                <option value="{{ $client->id }}"
                                    {{ $ticket->user_id == $client->id ? 'selected' : '' }}>{{ $client->name }} -
                                    {{ __($client->type) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="">النوع</label>
                        <select name="type" id="" class="form-control">
                            <option value="">اختر النوع</option>

                            <option value="orders" {{ $ticket->type == 'orders' ? 'selected' : '' }}>الطلبات</option>
                            <option value="activate_mempership"
                                {{ $ticket->type == 'activate_mempership' ? 'selected' : '' }}>تفعيل العضوية</option>
                            <option value="other" {{ $ticket->type == 'other' ? 'selected' : '' }}>آخرى</option>

                        </select>
                    </div>


                    <div class="form-group mb-3">
                        <label for="">عنوان التذكرة</label>
                        <input type="text" name="title" id="" value="{{ $ticket->title }}"
                            class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">الوصف</label>
                        <textarea name="description" class="form-control" rows="8">{{ $ticket->description }}</textarea>
                    </div>


                    <div class="form-group mb-3">
                        <label for="">الحالة</label>
                        <select name="status" id="" class="form-control">
                            <option value="">اختر الحالة</option>
                            <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>مفتوحة</option>
                            <option value="finished" {{ $ticket->status == 'finished' ? 'selected' : '' }}> تم الرد
                            </option>
                            <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>مغلقة</option>

                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
