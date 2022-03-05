<nav class="nav navbar navbar-dark bg-dark flex-md-nowrap p-0 shadow">
    <a class="nav-link navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="{{ url('/') }}">Banking App</a>

    {{--    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse"--}}
    {{--            data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">--}}
    {{--        <span class="navbar-toggler-icon"></span>--}}
    {{--    </button>--}}

    <a class="nav-link" href="{{ route('home') }}">Home</a>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown button
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
        </ul>
    </div>
    @auth
        <ul class="navbar-nav px-3">
            <li class="nav-item px-3 dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Hi, {{ auth()->user()->name }}, see your Account
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                    <a class="dropdown-item" href="{{ route('get_logout') }}">Logout</a>
                </div>
            </li>
        </ul>
    @endauth

    @guest
        <li class="nav-item dropdown">
            <button class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-bs-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">Login/Register</button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item register-link" href="{{ route('register') }}">Register</a></li>
                <li><a class="dropdown-item login-link" href="{{ route('login') }}">Login</a></li>
            </ul>
        </li>
    @endguest
</nav>
