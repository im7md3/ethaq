@extends('client.layouts.client')
@section('title', 'شات استشارة رقم '.$con->id)
@push('css')
<!--load amimate.css from CDN-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.4.0/animate.min.css">
@endpush
@section('content')
<section class="height-section section-chat pb-4" id="chat">
    <div class="head">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <a href="./" class="btn-icon text-white">
                        <div class="icon">
                            <img src="{{asset('front-assets')}}/img/global/i-home.png" alt="">
                        </div>
                        <div class="title">
                            <i class="fa-solid fa-angles-left"></i>
                        </div>
                        <span class="title"> الاستشارات</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- <div class="title-section">
            استشارة موجهة
        </div> -->
        @if($con->status=='active')
        <div class="box-num">
            <div>
                <span id="timer">@{{ time_chat }} / 15:0</span>
            </div>
        </div>
        @endif
    </div>
    <div class="container">
        {{-- --------------------------------- data of Cons --------------------------- --}}
        <div class="box-chat">
            <div class="d-flex mb-2 align-items-center justify-content-between gap-1">
                <div class="d-flex main-color align-items-center gap-2">
                    <div class="cr"></div>
                    <small>
                        الاستشارة رقم
                    </small>
                    <small>
                        {{ $con->id }}
                    </small>
                </div>
                <small>
                    {{$con->created_at}}
                </small>
            </div>
            <div class="d-flex align-items-start justify-content-between">
                <div class="d-flex mb-3 gap-2 align-items-center">
                    <img src="{{ display_file($con->client->photo) }}" alt="" class="user-img">
                    <div>
                        <div class="name mb-2">
                            {{ $con->client->username }}
                        </div>
                        <!--
                        <small class="d-block">
                            الحالة:
                            <span class="sec-color ">
                                {{ __($con->status) }}
                            </span>
                        </small> -->
                        <small class="d-block">
                            النوع:
                            <span class="sec-color">
                                {{ $con->departmentName }}
                            </span>
                        </small>
                    </div>
                </div>
                <div class="">
                    <div class="btn-icon-cr not btn-gradient-blue btn cursor-context">
                        {{ __($con->status) }}
                    </div>
                </div>
            </div>
            <div class="">
                <div class="line-text mb-2 break-text">
                    {{ $con->details }}
                </div>
            </div>
            <div class="d-flex align-items-center mt-2 box-btn flex-column gap-2 mx-auto">
                <div class="d-flex flex-wrap w-100 align-items-center gap-2 justify-content-center">
                    <x-attachments :files="$con->files" :voices="$con->voices"></x-attachments>
                </div>
                @if($con->CanCancel)
                <form action="{{ route('client.consulting.update',$con) }}" method="POST" class="w-100">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="cancel">
                    <button class="btn-chat red" type="submit">إلغاء الاستشارة</button>
                </form>
                @endif
                @if($con->status=='active')
                <form action="{{ route('client.consulting.update',$con) }}" method="POST" class="w-100">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="done">
                    <button class="btn-chat red" type="submit">إنهاء الاستشارة</button>
                </form>
                @endif
                @if($con->status!='cancel')
                @if( $con->invoices?->status=='paid')
                <div class="btn-chat flex-column main-color">
                    <small class="fw-normal">
                        تم الدفع
                    </small>
                </div>
                <a target="_blank" class="btn btn-sm btn-info"
                    href="{{ route('client.invoices.show',$con->invoices) }}">الفاتورة</a>
                @else
                @if($con->vendor_id and $con->invoices)
                <form class="w-100" action="{{ route('clickpay.store',$con->invoices) }}" method="POST">
                    @csrf
                    <button type="submit" class="main-btn pay-btn">سداد</button>
                </form>
                @endif
                @endif
                @else
                <div class="btn-chat flex-column red">
                    <small class="fw-normal">
                        تم إلغاء الاستشارة
                    </small>
                </div>
                @endif
            </div>
        </div>
        <ul class="main-ul my-3">
            <li class=" wow fadeInUp" data-wow-delay=".3s">
                سيتواصل معك محاميك خلال "8 ساعة"
            </li>
            <li class=" wow fadeInUp" data-wow-delay=".4s">
                مدة الاستشارة "15" دقيقة, وتستطيع التمديد بعد انتهاء الوقت
            </li>
            <li class=" wow fadeInUp" data-wow-delay=".7s">
                سيكون معك المحامي /المستشار مدة ربع ساعة يجيبك علي استفساراتك القانونية, وللعلم فإن المحادثة توفر
                ميزة التوقف التلقائي لعداد الوقت في حال عدم تفاعل المحامي /المستشار مدة 10 ثواني متواصلة, حفظأ لحقك
                في وقت الاستشارة, وتحسبأ لأي ظرف قد يواجه المحامي / المستشار
            </li>
            </ul>
            <div class="alert alert-info mb-0 text-center" role="alert">
                لكي يتم تفعيل الاستشارة يتطلب سداد مبلغ الاسشتارة
            </div>
        {{-- --------------------------------- Offers --------------------------- --}}
        @if(!$con->vendor_id)
        @include('client.consulting.offers')
        @endif
        <div class=" box-send mt-1 position-relative  ">
            <div class="box-msg" :class="[!stopTime && time_chat!='15:0' ? 'pb-0' :'']">
                {{-- --------------------------------- Messages --------------------------- --}}
                <div class="d-flex gap-3 flex-column p-3 ">
                    <div :class="{msg:true,from:user_id!=msg.from}" v-for="msg in messages" :key="msg.id">
                        <div class="info-user d-flex align-items-center gap-2 mb-1">
                            <img :src="url+msg.from_user.photo" alt="" class="photo">
                            <span class="name">@{{ msg.from_user.username }}</span>
                            <span class="date ">@{{ msg.created_at }}</span>
                        </div>
                        <p class="content-msg " v-if="msg.msg">
                            <span v-html="lineMsg(msg.msg)"></span>
                        </p>
                        <div class="d-flex flex-column gap-1 mt-1">
                            <div class="files d-flex align-items-center gap-1 w-100 ">
                                <a v-for="(file,i) in msg.files" :key="file.id" v-if="file.type=='pdf'"
                                    class="btn-border btn-sm" target="_blank" :href="url+file.path" download="">
                                    <span>مرفق </span>
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            </div>
                            <!-- Audio -->
                            <div class="d-flex flex-column gap-1">
                                <audio v-for="(file,i) in msg.files" :key="file.id" v-if="file.type=='audio'"
                                    class="w-100" :src="url+file.path" controls="controls">
                                    <source :src="url+file.path" type="audio/mpeg">
                                </audio>
                            </div>
                            <!-- Img -->
                            <div class="box-show-imgs">
                                <a v-for="(file,i) in msg.files" :key="file.id" v-if="file.type=='img'" class=""
                                    target="_blank" :href="url+file.path">
                                    <img :src="url+file.path" class="img" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <span v-show="typing" class="help-block mt-3" style="font-style: italic">
                    يكتب الآن ...
                </span>
            </div>
            {{-- --------------------------------- Form for Messages --------------------------- --}}
            @if($con->status=='active')
            <div class="form">
                @include('components.attach')
                <attach-form name='msg' id="2" show=true ref="attach" realtime=true></attach-form>
            </div>
            @endif
            @if($con->status=='done' )
            <h6>تقييم الاستشارة</h6>
            @if($con->evaluate_count==0)
            <form action="{{ route('client.consulting.evaluate') }}" method="POST">
                @csrf
                <input type="hidden" name="consulting_id" value="{{ $con->id }}">
                <input type="hidden" name="client_id" value="{{ $con->client_id }}">
                <input type="hidden" name="vendor_id" value="{{ $con->vendor_id }}">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center gap-1">
                        <input type="radio" name="value" value="1">
                        <label for="">ضعيف</label>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <input type="radio" name="value" value="2">
                        <label for="">مقبول</label>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <input type="radio" name="value" value="3">
                        <label for="">جيد</label>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <input type="radio" name="value" value="4">
                        <label for="">جيد جدا</label>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <input type="radio" name="value" value="5">
                        <label for="">ممتاز</label>
                    </div>
                </div>
                <button type="submit" class="small-btn main-btn mt-2">ارسال</button>
            </form>
            @else
            قمت بتقييم المحامي بتقييم {{ $con->evaluate->evaluateName }}
            <div class="box-stars">
                <x-consultation.evaluation :value="$con->evaluate->value">
                </x-consultation.evaluation>
            </div>
            @endif
            @endif
        </div>
    </div>
</section>
@push('js')
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.6.1/dist/echo.iife.js"></script>
<!-- load WOW js from CDN-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script>
    new WOW().init();
</script>
<script>
    window.Echo = new Echo({
      broadcaster: 'pusher',
      key: '{{ env("PUSHER_APP_KEY") }}',
      cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
      encrypted: true
    });
</script>
<script>
    let app = new Vue({
        el: "#chat",
        data:{
            typing:false,
            messages:[],
            from:'',
            to:'',
            consulting_id:'',
            url:'',
            timeout:null,
            time_chat:'',
            stopTime:true,
            startingMinute:false,
            user_id:'',
            min:'',
            sec:'',
        },
        watch:{
            /* مراقبة هل يكتب الان وايقاف الوقت اذا كان اكبر من 10 ثواني */
            typing:function(){
                if(!this.typing){
                    this.timeout = setTimeout(() => {
                        this.stopTime=true
                        let channel = window.Echo.join(`TimeChatChannelStatus.${this.consulting_id}`);
                            channel.whisper('timeStatus', {
                                time: true,
                            });

                    }, 10000);
                }
            },
        },
        methods:{
            getRestTime(){
                axios.get(`/api/consulting/${this.consulting_id}/get-time`).then(r => {
                    $rest_time=r.data.data
                    this.min=$rest_time.min
                    this.sec=$rest_time.sec
                    this.time_chat= `${this.min}:${this.sec}`
                })
            },
            /* عداد الزمن */
            updateTheCounter(){
                $this=this
                var timer = setInterval(function() {
                    if(!$this.stopTime && $this.time_chat!='15:0'){
                        $this.sec++;
                        if ($this.sec == 60) {
                            $this.min++;
                            $this.sec = 0;
                        }
                    }
                    $this.time_chat= `${$this.min}:${$this.sec}`
                }, 1000)
            },
            updateTheCounter2() {
                    let totalTimeBySec = this.min * 60 + parseInt(this.sec);
                    const handlerTimer = setInterval(() => {
                        let min = Math.floor(totalTimeBySec / 60)
                        let sec = totalTimeBySec % 60;
                        this.time_chat= `${min}:${sec}`
                        if(!this.stopTime && this.time_chat!='15:0'){
                            totalTimeBySec--;
                            this.min=min
                            this.sec=sec
                        }
                    }, 1000)
            },
            /* يكتب الان */
            isTyping() {
                let channel = window.Echo.join(`typingChannel.${this.consulting_id}`);
                    channel.whisper('typing', {
                        typing: true
                    });
                if (this.timeout) {
                    clearTimeout(this.timeout);
                }
                this.timeout = setTimeout(() => {
                    channel.whisper('stopped-typing', {
                        typing: false
                    });
                }, 3000);
            },
            /* ارسال الرسالة */
            storeMessage(){
                var formData = new FormData();
                formData.append('to', this.to);
                formData.append('from',this.from);
                formData.append('consulting_id', this.consulting_id);
                formData.append('msg', this.$refs.attach.$data.msg);
                this.$refs.attach.$data.images.forEach( img => {
                    formData.append('images[]', img);
                })
                this.$refs.attach.$data.itemsRealtime.forEach( img => {
                    formData.append('images[]', img);
                })
                formData.append('min', this.min);
                formData.append('sec', this.sec);
                axios.post('/api/consulting-messages', formData,{
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }}).then(r => {
                            // var boxMsg = document.querySelector(".box-msg");
                            // boxMsg.scrollTo(0,boxMsg.scrollHeight);
                            // this.$refs.attach.$data.images=[]
                            // this.$refs.attach.$data.items=[]
                            // this.$refs.attach.$data.record=''
                            // this.$refs.attach.$data.audio=''
                            // this.$refs.attach.$data.msg=''
                            // this.$refs.attach.$data.itemsRealtime=[]
                        })
            },
            //     // فصل السطور في الرسالة
            lineMsg(msg) {
                var eleText = msg.split("\n").join('\n</br>');
                    return eleText;
            },
        },
        mounted(){
            /* اسناد القيم الى المتغيرات */
            this.messages={!! $con->messages !!}
            this.to="{{  $to }}"
            this.from="{{  $from }}"
            this.consulting_id="{{  $con->id }}",
            this.url="{{ display_file('') }}"
            this.user_id="{{ auth()->id() }}"
            /* عرض وقت المحادثة */
            this.getRestTime()
             /* الاستماع الى قناة المحادثة وعرض الرسائل دون تحديث */
            window.Echo.channel(`myChat-${this.consulting_id}`).listen('.chat', (data) => {

                this.messages.push(data.messages)
                this.getRestTime()
                var boxMsg = document.querySelector(".box-msg");
                boxMsg.scrollTo(0,boxMsg.scrollHeight);
            });
            /* الاستماع الى قناة هل يكتب الان ام لا */
            window.Echo.join(`typingChannel.${this.consulting_id}`)
                .listenForWhisper('typing', (e) => {
                    this.typing = e.typing;
                }).listenForWhisper('stopped-typing', (e) => {
                this.typing = e.typing;
            })
            /* الاستماع الى قناة تغيير حالة الوقت */
            window.Echo.join(`TimeChatChannelStatus.${this.consulting_id}`)
                .listenForWhisper('timeStatus', (e) => {
                    this.stopTime = e.time;
                    this.getRestTime()
                    // this.updateTheCounter()
                })
            /* تغيير السكرول الى اخر الشات */
            window.addEventListener("load",()=> {
                var boxMsg = document.querySelector(".box-msg");
                boxMsg.scrollTo(0,boxMsg.scrollHeight);
            })
        }
    });

</script>
@endpush
@endsection
