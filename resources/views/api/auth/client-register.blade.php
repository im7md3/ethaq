<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Normalize -->
    <link rel="stylesheet" href="{{asset('front-assets')}}/css/normalize.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset('front-assets')}}/css/bootstrap.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('front-assets')}}/css/all.min.css" />
    <!-- Main Faile Css  -->
    <link rel="stylesheet" href="{{asset('front-assets')}}/css/auth.css" />
    <!-- Font Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@500;600;700;800&display=swap"
        rel="stylesheet" />
    <title>تسجيل</title>
</head>

<body>
    <div class="loader_layout" id="loader">
        <h2 class="brand">
            <img class="img-user" src="{{asset('front-assets')}}/img/global/ethaq-logo.png" alt="" />
        </h2>
        <div class="loading-bar"></div>
    </div>
    <div class="scrl-support">
        <div class="shere tog-active support">
            <div class="img"><img src="{{asset('front-assets')}}/img/global/Asset 15@5x.png" alt=""></div>
            <div class="shere-list">
                <a target="_blank" href="{{ setting('twitter') }}" class="shere-item">
                    <i class="fab fa-twitter"></i>
                </a>
                <a target="_blank" href="{{ setting('facebook') }}" class="shere-item">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a target="_blank" href="{{ setting('linkedin') }}" class="shere-item">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a target="_blank" href="{{ setting('instagram') }}" class="shere-item">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="{{route('tickets.index')}}" class="shere-item">
                    <img src="{{asset('front-assets')}}/img/global/Asset 13@5x.png" alt="">
                </a>
            </div>
        </div>
    </div>
    <div id="register-page">
        <section class="height-section-footer section-register bg-brand py-4">
            <div class="container">
                {{-- <form action="{{ route('register') }}" method="POST"> --}}
                    {{-- @csrf --}}
                    <!-- start step one -->
                    {{-- <div v-show="step == 1">
                        <div class="h-page">
                            <div class="row w-100 row-gap-24 text-center">
                                @if(setting('register_new_client_individual') or setting('register_new_client_company'))
                                <label class=" col-md-6  " for="client">
                                    <div class="card-user active">
                                        <input class="inp-hidd par-inp" id="client" ref="autoCheckClient"
                                            @click="checkUser($event)" type="radio" v-model="user" name="type"
                                            value="client">
                                        <!-- <img src="{{asset('front-assets')}}/img/global/reg-icon1.png" alt="" class="logo-icon"> -->
                                        <div class="title">
                                            عميل
                                        </div>
                                        <div class="group-type-user">
                                            @if(setting('register_new_client_individual'))
                                            <div class="card-type-user">
                                                <input class="inp-hidd child-inp" @click="checkMembership($event)"
                                                    type="radio" v-model="membership" name="membership"
                                                    value="individual" id="">
                                                فرد
                                            </div>
                                            @endif
                                            @if(setting('register_new_client_company'))
                                            <div class="card-type-user">
                                                <input class="inp-hidd child-inp" @click="checkMembership($event)"
                                                    type="radio" v-model="membership" name="membership" value="company"
                                                    id="">
                                                شركات
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </label>
                                @endif
                            </div>
                        </div>
                        <div class="mt-3" v-if="errors.length>0">
                            <div class="alert alert-danger" v-for="(error,key) in errors" :key='key'>@{{ error }}</div>
                        </div>
                        <div class="mt-4 d-flex justify-content-center ">
                            <button @click.prevent="increaseStep()" class="button btn next_btn rounded-pill">
                                التالي
                            </button>
                        </div>
                        <div class=" d-flex justify-content-center mt-2  ">
                            <a href="{{ route('login') }}" class="fw-bold main-color">
                                لديك حساب بالفعل؟
                            </a>
                        </div>
                    </div> --}}
                    <!-- end step one -->
                    <!-- start step two -->
                    <div {{-- v-show="step == 2" --}} class="content-step-2">
                        <div class="  d-flex align-items-center flex-wrap gap-5 justify-content-start">
                            <h4 class="main-color fw-bold">
                                انشاء حساب
                            </h4>
                            <!-- <div class="bar-type-user d-flex  align-items-center items-title ">
                                <div class="title-type-user  " :class="[user == 'client' ? 'active' :'']">عميل</div>
                                <div class="mx-2">|</div>
                                <div class="title-type-user  " :class="[user == 'vendor' ? 'active' :'']">مقدم خدمة
                                </div>
                                <div class="mx-2">|</div>
                                <div class="title-type-user "> محكم</div>
                            </div> -->
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm-10 col-md-8 col-lg-6">
                                <div class="box-register">
                                    <p class=" mb-4 d-block fw-bold text-color-dark text-fs-3">
                                        نرجو التأكد بإضافة البيانات الصحيحة لكي يتم التفعيل المباشر للعضوية
                                    </p>
                                    {{-- <form action=""> --}}
                                        {{-- <div class="" v-if='user=="vendor"'>
                                            <div class="mb-3">

                                                <label for="" class="small-label">رقم الرخصة <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" class="form-control" v-model="license_name" id="">
                                            </div>
                                            <div class="mb-3">
                                                <label for="" class="small-label">الرخصة <span
                                                        class="text-danger">*</span></label>
                                                <input type="file" class="form-control" name="license" id=""
                                                    v-on:change="onFileChange">
                                            </div>
                                            <div class="mb-3">
                                                <label for="" class="small-label">تاريخ الانتهاء <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" class="form-control" v-model="end_at" id=""
                                                    min="{{ now()->addDay()->format('Y-m-d') }}">
                                            </div>
                                        </div> --}}
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label for="" class="small-label">الاسم <span
                                                        class="text-danger">*</span></label>
                                                <input @click="scrollInp($event)" type="text" class="form-control" name="name" v-model="name">
                                            </div>
                                            <div class="col-lg-12">
                                                <label for="" class="small-label">الإيميل <span
                                                        class="text-danger">*</span></label>
                                                <input @click="scrollInp($event)" type="email" class="form-control" name="email" v-model="email">
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="mb-4">
                                                    <label for="">
                                                        رقم الجوال
                                                        <span class="text-danger">*</span>
                                                        <small>(يجب ان يكون 10 أرقام)</small>
                                                    </label>
                                                    <input @click="scrollInp($event)" type="text" required
                                                        @keypress="checkNum($event)" class=" form-control" name="phone"
                                                        value="{{ old('phone') }}" v-model='mobile'>
                                                </div>
                                                <small class="text-danger" v-cloak v-if="mobile_required_error">يرجى
                                                    إدخال رقم
                                                    الجوال</small>
                                                <small class="text-danger" v-cloak v-if="mobile_exists_error">رقم الهاتف
                                                    غير
                                                    موجود</small>
                                                <small class="text-danger" v-cloak v-if="error_show">@{{ error_show
                                                    }}</small>
                                                <div v-show="checkSendCode" v-cloak>
                                                    <div
                                                        class="w-100 d-flex grey-color-dark fs-6 align-items-center gap-2 mb-2">
                                                        <i class="fas fa-hashtag"></i>
                                                        ادخل الكود المرسل
                                                        @if(setting('code_display_status'))
                                                        <span class="text-dark">
                                                            @{{ code }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <input
                                                        @click="scrollInp($event)"
                                                        type="number"
                                                        required
                                                        class=" form-control"
                                                        v-model="numCode"
                                                    >
                                                    <small class="text-danger" v-if="code_required_error">يرجى إدخال
                                                        الكود
                                                        بشكل صحيح</small>
                                                    <p class="mb-1">
                                                        <small class="ms-1"> اعادة الارسال بعد: </small>
                                                        <span class="timer">0: 0 </span>
                                                    </p>
                                                    <button class="btn-resend btn btn-secondary btn-sm "
                                                        @click.prevent="sendMobile()">اعادة ارسال
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <p for="" class="group-cheack">
                                            <input type="checkbox" required id="" name="agree" v-model='agree'>
                                            <a target="_blank" href="{{ route('politics') }}">
                                                الموافقة على شروط الاستخدام وسياسة الخصوصية

                                            </a>
                                            <span class="text-danger">*</span>
                                        </p>
                                        <button v-if="!checkSendCode" @click.prevent="sendMobile()"
                                            class="main-btn w-100 d-flex align-items-center justify-content-center gap-2">
                                            ارسال رمز التحقق
                                            <div v-if="sendCode" class="spinner-border text-light w-1rem h-1rem" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                        </button>
                                        <button v-else v-cloak @click.prevent="verifyCodeToLogin()"
                                            class="main-btn w-100 ">
                                            إنشاء حساب
                                        </button>
                                        <div class="mt-3" v-if="errors.length>0">
                                            <div class="alert alert-danger" v-for="(error,key) in errors" :key='key'>@{{
                                                error }}</div>
                                        </div>
                                        {{-- <input type="submit" class="submit w-100" value="انشاء حساب"> --}}
                                        <!-- <button @click="step--" class="submit w-100 bg-secondary mt-2">رجوع</button> -->
                                        {{--
                                    {{-- </form>  --}}
                                </div>
                            </div>
                        </div>
                    </div>
                {{-- </form> --}}

                <!-- end step two -->
            </div>

        </section>
    </div>
    <footer class="main-footer py-5">
        <div
            class="container d-flex align-items-center justify-content-center justify-content-sm-between gap-3 flex-column flex-md-row">
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
                    <a href="{{ route('politics') }}">سياسة الأستخدام و الخصوصية</a>
                    <a href="{{ route('contact') }}">أتصل بنا</a>
                    <a href="#">من إيثاق؟</a>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3 flex-column">
                <b>جميع الحقوق محفوظة إيثاق 2022</b>
            </div>
        </div>
    </footer>
    <!-- Js Files -->
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <script src="{{asset('js/all.min.js')}}"></script>
    <!--Start of Tawk.to Script-->
    <!-- <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/62da651254f06e12d88ac6ff/1g8ihlk8d';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script> -->
    <script src="{{asset('js/jwt-decode.js')}}"></script>
    <script src="{{asset('js/vue.js')}}"></script>
    <script src="{{ asset('js/axios.js') }}"></script>
    <script>
        let registerPage = new Vue({
            el: "#register-page",
            data: {
                checkSendCode: false,
                mobile: '',
                mobile_required_error: false,
                code_required_error: false,
                mobile_exists_error: false,
                unexpected_error: false,
                error_show: null,
                sendCode : false,
                numCode : '',
                code : '',
                agree: '',
                user: 'client',
                membership: 'individual',
                errors: [],
                email:'',
                name: '',
            },
            computed: {
                otp() {
                    return this.numCode;
                }
            },
            methods: {
                scrollInp($event) {
                    $event.target.scrollIntoView({
                        behavior: 'smooth'
                    });
                },
                checkNum(evt) {
                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;
                    if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                        evt.preventDefault();;
                    } else {
                        return true;
                    }
                },
                sendMobile(e) {
                    this.errors = []
                    if (this.mobile) {
                        this.sendCode = true;
                        this.mobile_required_error = false;
                        var formData = new FormData();
                        formData.append('user_name', this.name);
                        formData.append('phone', this.mobile);
                        formData.append('email', this.email);
                        formData.append('type', this.user);
                        formData.append('membership', this.membership);
                        formData.append('agree', this.agree);
                        axios.post('/register/sms', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then(r => {
                            this.code = r.data.code
                            this.checkSendCode = true;
                            this.updateTheCounter()
                        }).catch(error => {
                            this.sendCode = false;
                            /* this.errorMessage = error.response.data.message; */
                            if (error.response.status == '400') {
                                this.error_show = error.response.data.error;
                            } else if (error.response.status == '422') {
                                this.errors.push(error.response.data.message);
                            } else {
                                this.error_show = 'عفواً هناك خطأ ما الرجاء';
                            }
                        });
                    } else {
                        this.mobile_required_error = true;
                    }
                },
                verifyCodeToLogin() {
                    this.errors = []
                    if (this.otp == this.code) {
                        this.code_required_error = false;
                        this.mobile_required_error = false;
                        var formData = new FormData();
                        formData.append('phone', this.mobile);
                        formData.append('user_name', this.name);
                        formData.append('email', this.email);
                        formData.append('type', this.user);
                        formData.append('membership', this.membership);
                        formData.append('agree', this.agree);
                        formData.append('otp', this.otp);
                        axios.post('/createUser', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then(r => {
                            window.location.replace(r.data.url);
                        }).catch(error => {
                            if (error.response.status == '400') {
                                this.error_show = error.response.data.error;
                            } else {
                                this.errors.push(error.response.data.message);
                            }
                        });
                    } else {
                        this.code_required_error = true;
                    }
                },
                updateTheCounter() {
                    let resendBtn = document.querySelector(".btn-resend")
                    const timeContainer = document.querySelector(".timer");
                    timeContainer.innerHTML = "1:00";
                    const startingMinute = 1;
                    let totalTimeBySec = startingMinute * 60;
                    const handlerTimer = setInterval(() => {
                        let min = Math.floor(totalTimeBySec / 60)
                        let sec = totalTimeBySec % 60;
                        timeContainer.innerHTML = `${sec}:  ${min}  `;
                        totalTimeBySec--;
                        if (sec === 0 && min === 0) {
                            clearInterval(handlerTimer);
                            resendBtn.style.display = 'block';
                        } else {
                            resendBtn.style.display = 'none';
                        }
                    }, 1000)
                },
            },
        });
    </script>
</body>

</html>
