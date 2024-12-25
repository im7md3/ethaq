@extends('front.layouts.front')
@section('title','إيثاق - منصة إيثاق')
<!-- Start Header -->
@section('content')
<meta name="title" content="إيثاق - منصة إيثاق">
<meta name="description" content="إيثاق هي منصة الكترونية للخدمات القانونية توفرعدة خدمات منها استشارات ودراسات وصياغة العقود والمذكرات والتمثيل القضائي والقانوني في المملكة العربية السعودية، عن طريق ربط العميل بالمحامي بسهولة و بطريقة آمنة مع الحفاظ على خصوصية بيانات العملاء كاملة، مع توفر العديد من المحامين المرخصين في جميع المجالات القانونية.">
<meta name="keywords" content="إيثاق,منصة إيثاق,خدمات اليكترونية,المحاماة,استشارات قانونية, مذكرات,تمثيل قضائي,محامي">
<meta name="robots" content="index, follow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="language" content="Arabic">
<header class="main-header-login">
  <div class="container py-2 text-start d-flex align-items-center gap-4 justify-content-center justify-content-md-between">
    <div class="group-logo d-flex align-items-center justify-content-between ">
      <a href="/">
        <img class="head-logo" src="{{asset('front-assets')}}/img/global/ethaq-logo.png" alt="" srcset="" />
      </a>
      <div class="tog-home tog-active" data-active=".group-login">
        <span class="one-bar"></span>
        <span class="two-bar"></span>
        <span class="three-bar"></span>
      </div>
    </div>

    <div class="group-login d-flex align-items-center justify-content-between flex-fill gap-4">
        <ul class="list-item">
            <li>
                <a href="#landing" class="item active">الرئيسية</a>
            </li>
            <li>
                <a href="#questions-page" class="item">كيف تعمل منصتنا</a>
            </li>
            <li>
                <a href="{{ route('contact') }}" class="item">تواصل معنا</a>
            </li>
        </ul>
     <div class=" group-btn  d-flex align-items-center  gap-3">
     <div class="dropdown">
  <a class="btn-header btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
  إنشاء عضوية
  </a>

  <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
    <li><a class="dropdown-item" href="{{ route('client.register') }}">تسجيل عميل</a></li>
    <li><a class="dropdown-item" href="{{ setting('register_by_nafath')?route('register.nafath'):route('vendor.register') }}">تسجيل محامي</a></li>
  </ul>
</div>
      <a href="{{ route('login') }}" class="btn-header btn btn-two"> تسجيل الدخول </a>
     </div>
    </div>
  </div>
</header>
<!-- End Header -->
<!-- Start Slide Home -->
<section id="landing" class="landing  ">
<img src="{{asset('front-assets')}}/img/global/bg-landing.svg" alt="" class="bg-landing">
    <div class="container pt-5 pt-md-0 pb-5 pb-md-0">
        <img src="{{asset('front-assets')}}/img/global/photo-home-phone.png" alt="" class="bg-phone">
    <div class="row align-items-center">
      <!-- <div class="col-xl-6">
        <div class="text">
          <div class="d-sm-none d-flex up  align-items-center justify-content-center gap-2 flex-wrap">
            @if(setting('register_new_vendor_individual') or setting('register_new_vendor_company'))
            <a href="{{ setting('register_by_nafath')?route('register.nafath'):route('register') }}" class="btn">
              تسجيل محامي
            </a>
            @endif
            @if(setting('register_new_client_individual') or setting('register_new_client_company'))
            <a href="{{ setting('register_by_nafath')==1?route('register.nafath'):route('register') }}" class="btn">
              تسجيل عميل
            </a>
            @endif
          </div>
          <p class="title-section-home">
            منصة إيثاق
          </p>
          <p class="content-text-home text-end">
            هي منصة سعودية تعمل في مجال البحث وتوفير المحامين المعتمدين والمرخصين وضمان التعاقد بين الاطراف والحقوق
            الماليه الخاصة بهم بشكل آمن ومضمون
          </p>
          <div class="d-none d-sm-flex  mb-3 align-items-center justify-content-center gap-4 gap-lg-2 flex-wrap mt-5">
            <a href="{{ route('login') }}" class="btn">
              <img src="{{asset('front-assets')}}/img/global/Asset 3.svg" alt="" class="btn-i filter-img">
              اطلب استشارتك
            </a>
            @if(setting('register_new_vendor_individual') or setting('register_new_vendor_company'))
            <a href="{{ setting('register_by_nafath')?route('register.nafath'):route('register') }}" class="btn">
              <img src="{{asset('front-assets')}}/img/global/Asset 3.svg" alt="" class="btn-i ">
              تسجيل محامي
            </a>
            @endif
            @if(setting('register_new_client_individual') or setting('register_new_client_company'))
            <a href="{{ setting('register_by_nafath')?route('register.nafath'):route('register') }}" class="btn">
              <img src="{{asset('front-assets')}}/img/global/Asset 3.svg" alt="" class="btn-i filter-img">
              تسجيل عميل
            </a>
            @endif
          </div>
        </div>
      </div> -->
      <div class="col-md-6">
        <div class="text">

          <p class="title-section-home">
            منصة إيثاق
          </p>
          <p class="content-text-home  mb-4 mb-md-5">
            هي منصة سعودية تعمل في مجال البحث وتوفير المحامين المعتمدين والمرخصين وضمان التعاقد بين الاطراف والحقوق
            الماليه الخاصة بهم بشكل آمن ومضمون
          </p>
          <a href="{{ route('login') }}" class="btn-landing">
              أطلب إستشارتك الآن مع إيثاق
              <div class="btn-i">
                <img src="{{asset('front-assets')}}/img/global/vector.svg" alt="">
              </div>
            </a>
        </div>
      </div>
      <div class="d-none d-md-block col-md-6 bg-img">
        <img src="{{asset('front-assets')}}/img/global/photo-home.png" alt="">
      </div>
    </div>
  </div>
</section>
<!-- End Slide Home -->
<!-- Start Service -->
<section class="service pb-5">
    <div class="container">
        <div class="box-title mb-3 mb-md-4">
            <div class="title">
                <span>الخ</span>دمات القانونية
            </div>
            <div class="sub">
                خدماتنا مفتوحة للجميع أفراد وشركات ومؤسسات وربط مع خدمة التحقق الشخصية نفاذ.
            </div>
        </div>
        <div class="boxes-service d-flex flex-column flex-xl-row align-items-center">
        <div class="items-service">
        <div class="item serv-1">
            <img src="{{asset('front-assets')}}/img/global/service-3.svg" alt="" />
            <p>استشارات ودراسات</p>
            <a href="#" class="btn ">
                أطلب آلان
                <i class="fa-solid fa-arrow-left-long"></i>
            </a>
            </div>
            <div class="item serv-2">
            <img src="{{asset('front-assets')}}/img/global/service-2.svg" alt="" />
            <p>صياغة العقود والمذكرات</p>
            <a href="#" class="btn">
                أطلب آلان
                <i class="fa-solid fa-arrow-left-long"></i>
            </a>
            </div>

            <div class="item serv-3">
            <img src="{{asset('front-assets')}}/img/global/service-1.svg" alt="" />
            <p>التمثيل القانوني والقضائي</p>
            <a href="#" class="btn ">
                أطلب آلان
                <i class="fa-solid fa-arrow-left-long"></i>
            </a>
            </div>

        </div>
        </div>
  </div>
</section>
<!-- End Service -->
<!-- Start order-page-home -->
<section class="order-page-home  pb-5 mt-5" id="order">
  <div class="container">
    <div class="box-title text-center mb-3 mb-md-5">
        <div class="title">
        <span>رحل</span>ة إنشاء الطلب
        </div>
    </div>
    <div class="boxes-step">
        <div class="box box-1">

            <img src="{{asset('front-assets')}}/img/home/order-1.png" alt="" class="img-step">
            <div class="info">
                <div class="text">
                <div class="content-front">
                    <div class="title">
                            إنشاء الطلب
                        </div>
                        <div class="sub">
                        بعد تسجيل الدخول عبر بوابة النفاذ الوطني الموحد,
                        يقوم العميل بتعبئة البيانات المتعلقة بالخدمة المطلوبة
                        واختيار طريقة عرض الطلب أمام المحامين.
                        </div>
                        <button class="btn-pop btn" data-active="box-1">
                        تفاصيل أكثر
                        <i class="fas fa-plus"></i>
                        </button>
                </div>
                <div class="content-pop">
                <button class="close">
                <i class="fas fa-xmark"></i>
            </button>
                <div class="title">
                تفاصيل إنشاء الطلب
                        </div>
                        <div class="sub mb-2">
                        تكون بداية إنشاء الطلب من قبل العميل عبر اختيار نوع الخدمة المطلوبة مما يلي:
                        </div>
                        <ol class="list mb-2">
                            <li>الإستشارات</li>
                            <li> دراسة وتحليل</li>
                            <li> المرافقة والمدافعة</li>
                            <li> المراجعة والتدقيق</li>
                        </ol>
                        <div class="sub mb-2">
                            ومن ثم اختيار الأقسام الفرعية لكل مما سبق وعلى سبيل المثال بعد اختيار خدمة الاستشارات (اداري, تجاري, جمركي,...). بعد ذلك ينتقل العميل إلى خطوة التالية لتسجيل الطلب وهي تعبئة بيانات الطلب التي تشمل:
                        </div>
                        <ul class="list-ul">
                            <li>
                                <span class="main-color">عنوان الطلب:</span> وهي الفكرة الرئيسية من الطلب
                            </li>
                            <li>
                                <span class="main-color">موضوع الطلب:</span>
                                هو ذكر جميع ما يتعلق بالطلب بشكل مفصل وواضح و إرفاق
                                ما يلزم من مستندات توضح الطلب لدى المحامي. وذلك باختيار طريقة تقديم الطلب
                                عبر الكتابة النصية أو عبر إرفاق المستندات أو عبر التسجيل الصوتي.
                            </li>
                            <li>
                                <span class="main-color">المدة المقترحة لتنفيذه الخدمة المطلوبة:</span>
                                وهنا يبين العميل المدة التي يحتاج إنهاء
                                الخدمة المطلوبة خلالها ويكون له الخيار في أن يجعلها غير قابلة للتفاوض والتعديل
                                أو متاحة للتفاوض من قبل المحامي. ومن ثم تأتي الخطوة التالية باختيار طريقة
                                العرض على المحامين وذلك بإتاحة اختيار الجميع أو أحدهم أو أكثر من محامي، ويمكن
                                للعميل الاطلاع على الملف الشخصي لكل محامي قبل الاختيار.
                            </li>
                        </ul>
                            <button class="btn-pop btn-next" data-active="box-2">
                            تفاصيل الاختيار والتفاوض
                            <i class="fas fa-angle-left"></i>
                            </button>
                </div>
                </div>
                <img src="{{asset('front-assets')}}/img/home/info-order-1.png" alt="" class="img-info">
            </div>
        </div>
        <div class="box box-2">
            <img src="{{asset('front-assets')}}/img/home/order-2.png" alt="" class="img-step">
            <div class="info">
                <div class="text">
                <div class="content-front">
                    <div class="title">
                    الإختيار والتفاوض
                        </div>
                        <div class="sub">
                        أهم مرحلة للعميل ومقدم الخدمة من خلالها يقوم
                        كل منهما باختيار الأنسب له من خلال الاطلاع على محتوى
                        الخدمة المطلوبة لدى العميل ومن خلال البيانات
                        الشخصية لمقدم الخدمة.
                        </div>
                        <button class="btn-pop btn" data-active="box-2">
                        تفاصيل أكثر
                        <i class="fas fa-plus"></i>
                        </button>
                </div>
                <div class="content-pop">
                <button class="close">
                <i class="fas fa-xmark"></i>
            </button>
                <div class="title">
                تفاصيل الاختيار والتفاوض
                        </div>
                        <div class="sub mb-2">
                        يبدأ الطرفين بالتفاوض بينهم بتقديم العرض من المحامي للعميل، ويقوم العميل بالموافقة عليه أو التفاوض معه حول العرض المقدم، إلى أن يصل الطرفين إلى نتيجة في التفاوض. والمنصة تتيح لهم خيارات متعددة لتسهل عليهم مرحلة الاختيار والتفاوض وذلك من خلال ما يلي:
                        </div>
                        <ul class="list-ul">
                            <li>
                            تحديد الأعمال المطلوبة.
                            </li>
                            <li>
                            تحديد المستندات المهمة.
                            </li>
                            <li>
                            تحديد طريقة التنفيذ لها.
                            </li>
                            <li>
                            تحديد المدة الزمنية لتنفيذها.
                            </li>
                            <li>
                            تحديد القيمة لتنفيذ تلك الخدمات المطلوبة.
                            </li>
                        </ul>
                        <button class="btn-pop btn-next" data-active="box-3">
                            تفاصيل الاختيار والتفاوض
                            <i class="fas fa-angle-left"></i>
                            </button>
                </div>
                </div>
                <img src="{{asset('front-assets')}}/img/home/info-order-2.png" alt="" class="img-info">
            </div>
        </div>
        <div class="box box-3">
            <img src="{{asset('front-assets')}}/img/home/order-3.png" alt="" class="img-step">
            <div class="info">
                <div class="text">
                <div class="content-front">
                    <div class="title">
                    الإتفاق
                        </div>
                        <div class="sub">
                            وصول العميل والمحامي لاتفاق يوثق بعقد
                            يبين فيه الحقوق والإلتزامات بين الطرفين وطريقة
                            تنفيذها.
                        </div>
                        <button class="btn-pop btn" data-active="box-3">
                        تفاصيل أكثر
                        <i class="fas fa-plus"></i>
                        </button>
                </div>
                <div class="content-pop">
                <button class="close">
                <i class="fas fa-xmark"></i>
            </button>
                <div class="title">
                تفاصيل الإتفاق
                        </div>
                        <div class="sub mb-2">
                        يقوم المحامي في هذه المرحلة بإعداد العقد وتعبئة بياناته التي تشتمل على نطاق العمل ببيان حصر الأعمال المطلوب تنفيذها والمستندات التي يحتاجها لتنفيذ تلك الأعمال وطريقة تنفيذها وتسليمها للعميل وبيان مدة التنفيذ وقيمة أتعاب المحاماة ، ولحفظ حقوق الأطراف يتم في هذه المرحلة الاتفاق على محكم يقوم بفض المنازعات التي نشأت بينهما أثناء أو بعد تنفيذ العقد و لأطراف الاتفاقية الحرية في اختيار الشخص المناسب للتحكيم (من المتواجدين على المنصة أو طرف خارجي) و يشترط اتفاق الطرفين على المحكم و من ثم دفع رسوم التحكيم المستحقة له، وبعد أن يتم توقيع العقد وسداد المستحقات المالية فيه يبدأ الأطراف بتنفيذ التزاماتهم عبر المنصة.
                        </div>
                </div>
                </div>
                <img src="{{asset('front-assets')}}/img/home/info-order-3.png" alt="" class="img-info">
            </div>
        </div>
    </div>
</div>
</section>
<!-- Start order-page-home -->
<!-- Start Section questions -->
<section id="questions-page" class="questions-page py-5">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between  ">
      <div class="box-one">
        <img src="{{asset('front-assets')}}/img/home/q.png" alt="" />

      </div>

      <div class="box-two">
      <div class="box-title mb-3 mb-md-4">
            <div class="title">
            <span>الأ</span>سئلة الشائعة
            </div>
        </div>
        @foreach($questions as $q )
        <div class="box-collapse">
          <button class="btn-collapse" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseExample{{$q->id}}" aria-expanded="false" aria-controls="collapseExample">
            {{$q->name}}
            <i class="fa-solid fa-angle-down"></i>
          </button>

          <div class="collapse mt-1" id="collapseExample{{$q->id}}">
            {{$q->result }}
          </div>
        </div>
        @endforeach
        <a href="{{ route('questions') }}" class="btn ">
          تصفح جميع الأسئلة
          <i class="fas fa-arrow-left"></i>
        </a>
      </div>
    </div>
  </div>
</section>
<!-- End Section questions -->
<!-- Start Email -->
<section id="email-page" class="email-page pt-5">
  <div class="container">
    <div class="d-flex align-items-end align-items-md-center flex-column flex-md-row gap-0 gap-md-3 justify-content-between ">
      <div class="box-one">
        <div class="box-title mb-3 mb-md-4">
            <div class="title">
            <span>الق</span>ائمة البريدية
            </div>
            <div class="sub">
            احصل على تحديثات مفيدة حول مكان إلتقاء الحياة والقانون
            </div>
        </div>
            <form class="" method="post" action="">
              <input class="w-100 mb-3 mb-md-4" type="email" name="email" id="" placeholder="أدخل بريدك الألكتروني" />
              <input class="btn-sub" type="submit" value="اشترك الأن" />
            </form>
      </div>
      <div class="box-two">
        <img src="{{asset('front-assets')}}/img/home/email.png" alt="">
      </div>
    </div>
  </div>
</section>
<!-- End Email -->
<!-- Start Social -->
<section class="social py-5">
<img class="bg-social" src="{{asset('front-assets')}}/img/home/bg-footer.png" alt="">
    <div class="container pt-5">
        <div class="box">
        <img class="logo" src="{{asset('front-assets')}}/img/global/ethaq-logo.png" alt="">
        <div class="text">
        تابعونا على
        </div>
        <div class="list-social">
        <a target="_blank" class="item" href="{{ setting('snapchat') }}">
                        <i class="fa-brands fa-snapchat"></i>
                    </a>
                    <a target="_blank" class="item" href="{{ setting('twitter') }}">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a target="_blank" class="item" href="{{ setting('instagram') }}">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a target="_blank" class="item" href="{{ setting('facebook') }}">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>

        <a target="_blank" class="item" href="{{ setting('linkedin') }}">
                        <i class="fab fa-linkedin"></i>
                    </a>



        </div>
        </div>
    </div>
</section>
<!-- End Social -->
<!-- <a href="#!" class="srl-top">
  <i class="i fas fa-arrow-up"></i>
</a> -->
@endsection
