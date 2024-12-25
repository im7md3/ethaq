<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>تحديد العضوية</title>
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
  <script src="{{ asset('js/axios.js') }}"></script>
</head>

<body>
  <div id="register-page">
    <section class="height-section-footer section-register bg-brand py-4">
      <div class="container mb-2">
        <div class="d-flex align-items-center mb-3">
          <a href="/" class="btn-icon">
            <div class="icon">
              <img src="{{asset('front-assets')}}/img/global/i-home.png" alt="">
            </div>
            الرئيسية
          </a>
        </div>
      </div>
      <div class="container">
        <form action="">
          <!-- start step one -->
          <div v-show="step == 1">
            <div class="row">
              <div class="col-md-11 col-lg-9 col-xl-8 m-auto">
                <h6 class="mb-4">اختر نوع العضوية <span class="text-danger">*</span></h6>
                <div class="row row-gap-24 text-center">
                  <label class="col-md-6  " for="client">
                    <div class="card-user active memberships">
                      <input class="inp-hidd par-inp" id="client" ref="autoCheckClient" @click="checkUser($event)"
                        type="radio" v-model="user" name="type" value="client">
                      <div class="icon-holder mb-3">
                        <i class="fa-solid fa-user"></i>
                      </div>
                      <div class="title">
                        عميل
                      </div>
                      <div class="group-type-user" v-show="chosen">
                        <div class="card-type-user">
                          <input class="inp-hidd child-inp" @click="checkMembership($event)" type="radio"
                            v-model="membership" name="membership" value="individual" id="">
                          فرد
                        </div>
                        <div class="card-type-user">
                          <input class="inp-hidd child-inp" @click="checkMembership($event)" type="radio"
                            v-model="membership" name="membership" value="company" id="">
                          شركات
                        </div>
                      </div>
                    </div>
                  </label>
                  <label for="vendor" class=" col-md-6  ">
                    <div class="card-user memberships">
                      <input class="inp-hidd par-inp" @click="checkUser($event)" type="radio" v-model="user" name="type"
                        value="vendor" id="vendor">
                      <div class="icon-holder mb-3">
                        <i class="fa-solid fa-user-tie"></i>
                      </div>
                      <div class="title">
                        محامي
                      </div>
                      <div class="group-type-user" v-show="chosen">
                        <div class="card-type-user">
                          <input class="inp-hidd child-inp" @click="checkMembership($event)" type="radio"
                            v-model="membership" name="membership" value="individual" id="">
                          فرد
                        </div>
                        <div class="card-type-user">
                          <input class="inp-hidd child-inp" type="radio" @click="checkMembership($event)"
                            v-model="membership" name="membership" value="company" id="">
                          شركات
                        </div>
                      </div>
                    </div>
                  </label>
                </div>
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
          </div>
          <!-- end step one -->
        </form>

      </div>
    </section>
    <!-- Start Footer -->
    <footer class="main-footer">
      <div class="container d-flex align-items-center justify-content-center justify-content-between gap-5 flex-column flex-md-row">
        <div class="d-flex align-items-center gap-3">
          <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
            <a href="">سياسة الأستخدام و الخصوصية</a>
            <a href="{{ route('contact') }}">أتصل بنا</a>
            <a href="#">من إيثاق؟</a>
          </div>
        </div>
        <div class="d-flex align-items-center gap-3 flex-column">
          <b>جميع الحقوق محفوظة إيثاق 2022</b>
          <div class="social d-flex align-items-center gap-2 justify-content-center">
            <a class="item" href="#">
              <i class="fa-brands fa-facebook-f"></i>
            </a>
            <a class="item" href="#">
              <i class="fa-brands fa-twitter"></i>
            </a>
            <a class="item" href="#">
              <i class="fa-brands fa-instagram"></i>
            </a>
            <a class="item" href="#">
              <i class="fa-brands fa-snapchat"></i>
            </a>
            <a class="item" href="#">
              <i class="fa-brands fa-linkedin-in"></i>
            </a>
          </div>
        </div>
        <div class="second-logo-holder">
          <a href="https://maroof.sa/249827">
            <img src="{{asset('front-assets')}}/img/global/Image-cr.webp" alt="marof-logo" width="110">
          </a>
        </div>
      </div>
    </footer>
    <!-- End Footer -->
  </div>
  <!-- Js Files -->
  <script src="{{asset('js/vue.js')}}"></script>
  <script>
  let registerPage = new Vue({
    el: "#register-page",
    data: {
      step: 1,
      agree: '',
      user: 'user',
      membership: '',
      errors: [],
      chosen: false
    },
    methods: {
      checkUser(evt) {
        var inpUser = evt.target;
        var cards = document.querySelectorAll(".card-user");
        cards.forEach(card => {
          card.classList.remove("active")
        });
        inpUser.closest(".card-user").classList.add("active")
        var childCards = document.querySelectorAll(".card-type-user");
        childCards.forEach(card => {
          card.classList.remove("active")
        });
        if (inpUser.parentElement.querySelector(`.card-type-user input[value="${this.membership}"]`)) {
          inpUser.parentElement.querySelector(`.card-type-user input[value="${this.membership}"]`).parentElement
            .classList.add("active")
        }
      },
      checkMembership(evt) {
        var inp = evt.target;
        var cards = document.querySelectorAll(".card-type-user");
        cards.forEach(card => {
          card.classList.remove("active")
        });
        inp.closest(".card-type-user").classList.add("active")
        var parentCards = document.querySelectorAll(".card-user");
        parentCards.forEach(card => {
          card.classList.remove("active")
        });
        inp.closest(".card-user").classList.add("active")
        this.user = inp.closest(".card-user").querySelector(".par-inp").value;
      },
      increaseStep() {
        this.errors = []
        if (!this.user) {
          this.errors.push('يجب تحديد نوع حساب المستخدم')
        }
        if (!this.membership) {
          this.errors.push('يجب تحديد نوع عضوية المستخدم')
        }
        // if (this.errors.length == 0) {
        //   this.step++
        // }
      }
    },
  });
  </script>
  <!--Start of Tawk.to Script-->
  <!-- <script type="text/javascript">
  var Tawk_API = Tawk_API || {},
    Tawk_LoadStart = new Date();
  (function() {
    var s1 = document.createElement("script"),
      s0 = document.getElementsByTagName("script")[0];
    s1.async = true;
    s1.src = 'https://embed.tawk.to/62da651254f06e12d88ac6ff/1g8ihlk8d';
    s1.charset = 'UTF-8';
    s1.setAttribute('crossorigin', '*');
    s0.parentNode.insertBefore(s1, s0);
  })();
  </script> -->
  <!--End of Tawk.to Script-->
  <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('js/main.js')}}"></script>
  <script src="{{asset('js/all.min.js')}}"></script>
</body>

</html>
