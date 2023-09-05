    <!-- ======= Top Bar ======= -->
    <div id="topbar" class="d-flex align-items-center fixed-top">
        <div class="container d-flex align-items-center justify-content-center justify-content-md-between">
            <div class="align-items-center d-none d-md-flex">
                <i class="bi bi-clock"></i> Senin - Sabtu, 08:00 - 21:00
            </div>
            <div class="d-flex align-items-center">
                <i class="bi bi-phone"></i> Whtastapp 0823 1169 6919
            </div>
        </div>
    </div>
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center">
            <a href="{{ route('landingpage') }}" class="logo me-auto">
                <img src="{{ asset('medicio/assets/img/lmc-l.png') }}" alt="">
            </a>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <h1 class="logo me-auto"><a href="index.html">Medicio</a></h1> -->

            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul>
                    <li><a class="nav-link scrollto " href="{{ route('landingpage') }}">Home</a></li>
                    <li><a class="nav-link scrollto" href="{{ route('landingpage') }}#about">About</a></li>
                    <li><a class="nav-link scrollto" href="{{ route('landingpage') }}#services">Services</a></li>
                    <li><a class="nav-link scrollto" href="{{ route('landingpage') }}#departments">Departments</a></li>
                    <li><a class="nav-link scrollto" href="{{ route('landingpage') }}#doctors">Doctors</a></li>
                    <li><a class="nav-link scrollto" href="{{ route('statusantrian') }}">Status Antrian</a></li>
                    {{-- <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="#">Drop Down 1</a></li>
                            <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i
                                        class="bi bi-chevron-right"></i></a>
                                <ul>
                                    <li><a href="#">Deep Drop Down 1</a></li>
                                    <li><a href="#">Deep Drop Down 2</a></li>
                                    <li><a href="#">Deep Drop Down 3</a></li>
                                    <li><a href="#">Deep Drop Down 4</a></li>
                                    <li><a href="#">Deep Drop Down 5</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Drop Down 2</a></li>
                            <li><a href="#">Drop Down 3</a></li>
                            <li><a href="#">Drop Down 4</a></li>
                        </ul>
                    </li> --}}
                    <li><a class="nav-link scrollto" href="{{ route('landingpage') }}#contact">Contact</a></li>
                    @auth
                        <li><a class="nav-link scrollto" href="{{ route('home') }}">Dashboard</a></li>
                    @else
                        <li><a class="nav-link scrollto" href="{{ route('login') }}">Login</a></li>
                    @endauth
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->
            <a href="{{ route('daftar') }}" class="appointment-btn scrollto"><span class="d-none d-md-inline"></span>
                Daftar</a>
        </div>
    </header><!-- End Header -->
