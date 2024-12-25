<div class="" id="offer_or_negotiable">
    <input type="text" name="" id="inp-op">
    <button class="btn main-btn mb-3" @click="current_form='offer'">إضافة عرض</button>
    <a href="{{ route('vendor.negotiations.show',[$order->id,$user->negotiations[0] ?? 0]) }}"
        class="btn sec-btn mb-3">استفسار وتفاوض</a>

    {{-- ****************** Add Offer *************************** --}}
    <form action="{{ route('vendor.offers.store') }}" method="POST" v-show="current_form=='offer'"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}" id="">
        <input type="hidden" name="vendor_id" value="{{ $user->id }}" id="">
        <div class="row row-gap-24 mb-2">
            <h5 class="title  fw-bold">اضف عرضك</h5>

        </div>

        <div class="d-flex  justify-content-center flex-column gap-3">
            <div class="d-flex flex-column gap-2">
                <small class="text-danger">
                    تلك الخانات مطلوبة *
                </small>
                <a class="btn btn-success w-100 " data-bs-toggle="collapse" href="#collapse-1" role="button"
                    aria-expanded="false" aria-controls="collapse-1">
                    <small>حصر الأعمال المطلوب تنفيذها تفصيلا +</small>
                </a>
                <div class="collapse" id="collapse-1">
                    <textarea name="works" @input="inpArbi($event)" class="form-control"
                        rows="5">{{ old('works') }}</textarea>
                </div>
            </div>
            <div class="d-flex flex-column gap-2">
                <a class="btn btn-success w-100 " data-bs-toggle="collapse" href="#collapse-2" role="button"
                    aria-expanded="false" aria-controls="collapse-2">
                    <small>حصر المتطلبات والمستندات الاساسية للأعمال مطلوب تنفيذها +</small>
                </a>
                <div class="collapse" id="collapse-2">
                    <textarea name="documents" @input="inpArbi($event)" id="" class="form-control"
                        rows="5">{{ old('documents') }}</textarea>
                </div>
            </div>
            <div class="d-flex flex-column gap-2">
                <a class="btn btn-success w-100 " data-bs-toggle="collapse" href="#collapse-3" role="button"
                    aria-expanded="false" aria-controls="collapse-3">
                    <small>طريقة ووسائل تنفيذ الأعمال +</small>
                </a>
                <div class="collapse" id="collapse-3">
                    <div class="row row-gap-24">
                        <div class=" col-sm-6 col-lg-4 ">
                            <input class="form-check-input" id="attach_file" name="execution_method[]"
                                value="كتابياً بإرفاق ملف عبر المنصة فقط." type="checkbox">
                            <label class="form-check-label" for="attach_file">كتابياً بإرفاق ملف عبر المنصة فقط.</label>
                        </div>
                        <div class=" col-sm-6 col-lg-4 ">
                            <input class="form-check-input" id="chat" name="execution_method[]"
                                value="المحادثة الكتابية عبر المنصة فقط" type="checkbox">
                            <label class="form-check-label" for="chat">المحادثة الكتابية عبر المنصة فقط.</label>
                        </div>
                        <div class=" col-sm-6 col-lg-4 ">
                            <input class="form-check-input" id="voice_chat" name="execution_method[]"
                                value="المحادثة الصوتية عبر المنصة فقط" type="checkbox">
                            <label class="form-check-label" for="voice_chat">المحادثة الصوتية عبر المنصة فقط.</label>
                        </div>
                        <div class=" col-sm-6 col-lg-4 ">
                            <input class="form-check-input" id="report" name="execution_method[]"
                                value="التمثيل أمام الغير بتقديم تقرير عن كل عمل." type="checkbox">
                            <label class="form-check-label" for="report">التمثيل أمام الغير بتقديم تقرير عن كل
                                عمل.</label>
                        </div>
                        <!-- <div class=" d-flex flex-column  gap-1 col-sm-6 col-lg-4">

                            <div>
                                <input v-model='execution_method' class="form-check-input" id="other"
                                    name="execution_method[]" value="other" type="checkbox">
                                <label class="form-check-label" for="other">
                                    آخرى
                                </label>
                            </div>
                            <input :disabled='!execution_method' name="other_execution_method" class="form-control"
                                type="text" value="{{ old('other_execution_method') }}">
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column gap-2">
                <a class="btn btn-success w-100 " data-bs-toggle="collapse" href="#collapse-4" role="button"
                    aria-expanded="false" aria-controls="collapse-4">
                    <small> المقابل المالي +</small>
                </a>
                <div class="collapse" id="collapse-4">
                    <div class="d-flex align-items-center gap-2">
                        <input type="number" required name="amount" class="form-control mt-1" style="width: 90px"
                            min="{{ setting('lowest_offer_amount') }}">
                        <div class="d-flex gap-1">
                            <span>غير قابل للتفاوض</span>
                            <input type="checkbox" class="form-check-input" name="negotiable">
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column gap-2">
                <a class="btn btn-success w-100 " data-bs-toggle="collapse" href="#collapse-5" role="button"
                    aria-expanded="false" aria-controls="collapse-5">
                    <small> مدة التنفيذ +</small>
                </a>
                <div class="collapse" id="collapse-5">

                    <div class="row row-gap-24">
                        <div class="col-sm-6 d-flex align-items-start">
                            <div class=" align-items-center gap-2  d-flex">
                                <label for="specified" class="">
                                    <input v-model="checkTime" type="radio" name="duration" id="specified"
                                        value="specified" />
                                    محدد المدة
                                </label>
                                <input v-if="checkTime == 'specified'" type="number" require name="days"
                                    class="form-control mt-1" style="width: 100px" min="1">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="unspecified" class="w-100 mb-2">
                                <input v-model="checkTime" type="radio" name="duration" value="unspecified"
                                    id="unspecified" />
                                غير محدد المدة
                                حتى صدور حكم أو قرار من :
                            </label>
                            <div v-if="checkTime == 'unspecified'">

                                <label for="courts_of_first_instance">
                                    <input type="radio" name="decision_place" value="محاكم الدرجة الأولى"
                                        id="courts_of_first_instance" />
                                    محاكم الدرجة الأولى
                                </label>

                                <label for="courts_of_appeal">
                                    <input type="radio" name="decision_place" value="محاكم الإستئناف"
                                        id="courts_of_appeal" />
                                    محاكم الإستئناف
                                </label>

                                <label for="supreme_court">
                                    <input type="radio" name="decision_place" value="المحكمة العليا"
                                        id="supreme_court" />
                                    المحكمة العليا
                                </label>

                                <label for="execution_court">
                                    <input type="radio" name="decision_place" value="محكمة التنفيذ"
                                        id="execution_court" />
                                    محكمة التنفيذ
                                </label>
                                <div class="mb-2">
                                    <label for="committee">
                                        <input v-model="typeTime" type="radio" name="decision_place" value="لجنة"
                                            id="committee" />
                                        لجنة
                                    </label>
                                    <input type="text" @input="inpArbi($event)" :disabled='typeTime != "لجنة"'
                                        class="form-control" name="committee" />
                                </div>

                                <label for="decision_from_place">
                                    <input type="radio" v-model="typeTime" name="decision_place" id="decision-of-party"
                                        value="قرار من الجهة/الإدارة" />
                                    قرار من الجهة/الإدارة
                                </label>
                                <input type="text" @input="inpArbi($event)"
                                    :disabled='typeTime != "قرار من الجهة/الإدارة"' class="form-control"
                                    name="management" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="d-flex flex-column gap-2">
                <a class="btn btn-success w-100 " data-bs-toggle="collapse" href="#collapse-6" role="button"
                    aria-expanded="false" aria-controls="collapse-6">
                    <small> أقصى مدة للرد على العميل +</small>
                </a>
                <div class="collapse" id="collapse-6">
                    <div class="d-flex align-items-center gap-2">
                        <select name="response_speed" id="" class="form-select  w-150px">
                            <option value="يوم">يوم</option>
                            <option value="يومين">يومين</option>
                            <option value="ثلاثة أيام">ثلاثة أيام</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn-holder mt-4 mb-2 text-center">
            <button type="submit" class="btn btn-success btn-sm px-5 py-2">إرسال </button>
        </div>
    </form>

    {{-- ****************** Add Negotiable *************************** --}}
    <span class="" v-if="current_form=='negotiable'">
        <x-negotiation.form :order="$order" :user="$user" :negotiation="$user->negotiations[0] ?? 0">
        </x-negotiation.form>
    </span>
    @push('js')
    <script>
        let app = new Vue({
                el: "#offer_or_negotiable",
                data: {
                    current_form: '',
                    checkTime:'unspecified',
                    typeTime:'',
                    execution_method:'',
                },
                methods: {
                    inpArbi($event) {
                        var formControl =$event.target;
                        var valueBeforeChange = formControl.value;
                        var allowedValue = ' ';
                        allowedValue += "ياىآبپتثجچهخدذرزژسشصضطظعغفقکگلمنوحكةؤءئأإ"; //or any collection in any language you want
                        allowedValue += "0123456789"; // normal digits
                    allowedValue += "۰۱۲۳۴۵۶۷۸۹"; // arabic digits
                    allowedValue += "،.=+-)(*&%$#@!/_.|"; // allowed symbols
                    allowedValue += "\n"; // allowed symbols

                var valueAfterChange = '';
                for (var i = 0; i < valueBeforeChange.length; i++) {
                    var tmpChar = valueBeforeChange.charAt(i);
                    if (allowedValue.indexOf(tmpChar) > -1) valueAfterChange = valueAfterChange + tmpChar;
                }
                formControl.value = valueAfterChange;
                if (document.querySelector('#inp-op')) {
                    document.querySelector('#inp-op').focus();
                    formControl.focus();
                }
            },

        },
        computed: {

        },
            });
    </script>
    @endpush
</div>