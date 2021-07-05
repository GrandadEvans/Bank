<nav class="navbar navbar-dark bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="{{ url('/') }}">
        Banking App
    </a>

    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <a class="nav-link" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
    @guest
        <a class="nav-link" href="{{ route('quick_login') }}">Quick Login</a>
    @endguest


    <ul class="navbar-nav px-3">

    @auth
    <li class="nav-item px-3 dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Hi, {{ auth()->user()->name }}, see your Account
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                    <a class="dropdown-item" href="{{ route('get_logout') }}">Logout</a>
                </div>
            </li>
    </ul>
    @endauth
    
    @guest
        <ul class="navbar-nav px-3">

        <li class="nav-item px-3 dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown4" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Login/Register
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                    <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                    <a class="dropdown-item" href="{{ route('register') }}">Register</a>
                </div>
            </li>
        </ul>
        @endguest
</nav>
