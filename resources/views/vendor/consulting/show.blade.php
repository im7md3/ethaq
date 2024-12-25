@extends('vendor.layouts.vendor')
@section('title', 'شات استشارة رقم '.$con->id)
@section('content')
@if($user->canAccessConsulting($con))
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
        @if($con->status=='active')
        <div class="box-num">
            <div>
                <span id="timer">@{{ time_chat }} / 15:0</span>
                <button class="btn btn-sm btn-warning" @click="changeTimeStatus(true)">
                    @{{ stopTime?'استئناف الجلسة':'وقف الجلسة' }}</button>
            </div>
        </div>
        @endif
    </div>
    <div class="container">
        {{-- --------------------------------- data of Cons --------------------------- --}}
        <div class="row justify-content-center">
            <div class="col-12 col-md-12">
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
                        <div class="d-flex align-items-center mb-3 gap-2">
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
                        <div class="line-text mb-2">
                            {{ $con->details }}
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-2 box-btn flex-column gap-2">
                        <div class="d-flex flex-wrap w-100 align-items-center gap-2 justify-content-center">
                            <x-attachments :files="$con->files" :voices="$con->voices"></x-attachments>
                        </div>
                        @if($con->CanCancel)
                        <form action="{{ route('vendor.consulting.update',$con) }}" method="POST" class="w-100">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="cancel">
                            <button class="btn-chat red" type="submit">إلغاء الاستشارة</button>
                        </form>
                        @endif
                        
                        <div class="btn-chat flex-column  red-color">
                            <small class="fw-normal">
                                {{ $con->PayMessage }}
                            </small>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- --------------------------------- Add Offer --------------------------- --}}
        @if(!$con->vendor_id)
        @include('vendor.consulting.add-offer')
        @endif
        <div class=" box-send mt-3 position-relative ">
            <div class="box-msg" :class="[!stopTime && time_chat!='15:0' ? 'pb-0' :'']">
                {{-- --------------------------------- Messages --------------------------- --}}
                <div class="d-flex gap-3 flex-column p-3">
                    <div :class="{msg:true,from:user_id!=msg.from}" v-for="msg in messages" :key="msg.id">
                        <div class="info-user d-flex align-items-center gap-2 mb-1">
                            <img :src="url+msg.from_user.photo" alt="" class="photo">
                            <span class="name">@{{ msg.from_user.name }}</span>
                            <span class="date">@{{ msg.created_at }}</span>
                        </div>
                        <p class="content-msg " v-if="msg.msg">
                            <span v-html="lineMsg(msg.msg)"></span>
                        </p>
                        <div class="d-flex flex-column gap-1 mt-1">
                            <div class="files w-100  d-flex align-items-center gap-1 ">

                                <a v-for="(file,i) in msg.files" :key="file.id" v-if="file.type=='pdf'"
                                    class="btn-border btn-sm" target="_blank" :href="url+file.path" download="">
                                    <span>مرفق </span>
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            </div>
                            <!-- Audio -->
                            <div class="d-flex flex-column gap-1 ">

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
            <div class="form" v-show="!stopTime && time_chat!='15:0'">
                @include('components.attach')
                <attach-form name='msg' id="2" show=true ref="attach" realtime=true></attach-form>
            </div>
            @endif
            {{-- --------------------------------- Evaluate --------------------------- --}}
            @if($con->status=='done' and $con->evaluate_count>0)
            تم تقييمك من قبل العميل بتقييم {{ $con->evaluate->evaluateName }}
            <div class="box-stars">
                <x-consultation.evaluation :value="$con->evaluate->value">
                </x-consultation.evaluation>
            </div>
            @endif
        </div>
    </div>
</section>
@push('js')
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.6.1/dist/echo.iife.js"></script>
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
        methods:{
            setRestTime(){
                var formData = new FormData();
                formData.append('consulting_id', this.consulting_id);
                formData.append('min', this.min);
                formData.append('sec', this.sec);
                axios.post(`/api/consulting/${this.consulting_id}/set-time`, formData)
            },
            ChangeStatus(){
                var formData = new FormData();
                formData.append('consulting_id', this.consulting_id);
                axios.post(`/api/consulting/${this.consulting_id}/change-status`, formData)
            },
            /* عداد الزمن */
            updateTheCounter(){
                this.min="{{ $con->min }}"
                this.sec="{{ $con->sec }}"
                $this=this
                var timer = setInterval(function() {
                    if(!$this.stopTime && $this.time_chat!='15:0'){
                        $this.sec++;
                        if ($this.sec == 60) {
                            $this.min++;
                            $this.sec = 0;
                        }
                        if($this.min==15){
                            location.reload();
                            $this.ChangeStatus()
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
                            this.min=min
                            this.sec=sec
                            totalTimeBySec--;
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
            changeTimeStatus(change=null) {
                if(!this.stopTime){
                    this.setRestTime()
                }
                if(change){
                    this.stopTime=!this.stopTime
                }
                let channel = window.Echo.join(`TimeChatChannelStatus.${this.consulting_id}`);
                    channel.whisper('timeStatus', {
                        time: this.stopTime,
                    });
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
                axios.post('/api/consulting-messages', formData,{
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }}).then(r => {
                            // var boxMsg = document.querySelector(".box-msg");
                            // boxMsg.scrollTo(0,boxMsg.scrollHeight);
                            // this.$refs.attach.$data.images=[]
                            // this.$refs.attach.$data.items=[]
                            // this.$refs.attach.$data.record=[]
                            // this.$refs.attach.$data.audio=[]
                            // this.$refs.attach.$data.msg=''
                            // this.$refs.attach.$data.itemsRealtime=[]
                            this.changeTimeStatus(true)
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
            console.log(this.messages);
            this.to="{{  $to }}"
            this.from="{{  $from }}"
            this.consulting_id="{{  $con->id }}",
            this.url="{{ display_file('/') }}"
            this.user_id="{{ auth()->id() }}"
             /* تشغيل دالة العداد الزمني */
            this.updateTheCounter()
            /* الاستماع الى قناة المحادثة وعرض الرسائل دون تحديث */
            window.Echo.channel(`myChat-${this.consulting_id}`).listen('.chat', (data) => {
                
                this.messages.push(data.messages)
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
            window.Echo.join(`TimeChatChannelStatus.${this.consulting_id}`)
                .listenForWhisper('timeStatus', (e) => {
                    this.stopTime = e.time;
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
@else
@include('vendor.consulting.access')
@endif
@endsection