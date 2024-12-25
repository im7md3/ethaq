<header class="main-header-login">
    <div class="container py-3 text-start d-flex align-items-center justify-content-center justify-content-md-between">
        <div class="group-logo d-flex align-items-center justify-content-between gap-5">
            <img class="head-logo" src="{{asset('front-assets')}}/img/global/ethaq-logo.png" alt="" srcset="" />
        </div>

        <div class="d-flex align-items-center gap-3">
            <div class="dropdown menu-header">
                <a hrev="#" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img class="img-user d-none d-lg-block" src="{{ asset(display_file(auth()->user()->photo)) }}"
                        alt="" />
                    <span class="d-none d-lg-block">{{ auth()->user()->first_name }}</span>
                </a>
                <a data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample"
                    class="tog-list d-lg-none">
                    <i class="fas fa-bars"></i>
                </a>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
                    aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header">
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div class="slide-user">
                            <div class="card-slide">
                                    <a href=""><img class="img-user" src="{{ display_file(auth()->user()->photo) }}"
                                            alt="" /></a>
                                <h6 class="">
                                    {{ auth()->user()->name }}
                                </h6>
                            </div>
                            <div class="card-slide box-item mt-3">
                                <form action="{{route('logout')}}" method="post" id="logout-form">
                                    @csrf
                                    <button class="btn-icon justify-content-between">
                                        خروج
                                        <div class="icon">
                                            <i class="fas fa-angle-left"></i>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{route('logout')}}" method="post" id="logout-form">
                @csrf
                <button class="btn-icon">
                    <div class="icon">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </div>
                </button>
            </form>
        </div>
    </div>
</header>
