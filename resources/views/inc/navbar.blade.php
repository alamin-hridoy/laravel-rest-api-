<!-- Static navbar -->
<nav class="navbar navbar-default navbar-static-top">
    <div class="col-md-96 col-md-offset-2">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('storage/icon/Brand-Icon.png') }}" id="brand-icon"></a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
        <li><a href="/news"><i class="fa fa-newspaper-o fa-2x" aria-hidden="true"></i></a></li>
        @if(Auth::guest())
        <li><a href="{{ url('/') }}"><i class="fa fa-home fa-2x" aria-hidden="true"></i></a></li>
        <li><a href="/register"><i class="fa fa-registered fa-2x" aria-hidden="true"></i></a></li>
        <li><a href="/login"><i class="fa fa-sign-in fa-2x" aria-hidden="true"></i></a></li>
        @else
        <li><a href="/dashboard"><i class="fa fa-user-circle-o fa-2x" aria-hidden="true"></i></a></li>
        <li><a href="{{ url('/news/create') }}"><i class="fa fa-id-card-o fa-2x" aria-hidden="true"></i></a></li>
        @endif
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down fa-2x" aria-hidden="true"></i></a>
            <ul class="dropdown-menu">
                <!-- Authentication Links -->
                @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endguest
            </ul>
        </li>
        @if(!Auth::guest() && Auth::user()->admin)
        <li>
            <form class="navbar-form navbar-right">
                <input type="text" class="form-control" placeholder="Find Users">
            </form>
        </li>
        @endif
        @if(!Auth::guest())
        <li><a href="#"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i></a></li>
        <li><a href="#"><i class="fa fa-calendar fa-2x" aria-hidden="true"></i></a></li>
        <li><a href="#"><i class="fa fa-bell-o fa-2x" aria-hidden="true"></i></a></li>
        <li><a href="#"><i class="fa fa-comments-o fa-2x" aria-hidden="true"></i></a></li>
        <li><a href="#"><i class="fa fa-cog fa-2x" aria-hidden="true"></i></a></li>
        <li><a href="#"><i class="fa fa-users fa-2x" aria-hidden="true"></i></a></li>
        <li><a href="#"><i class="fa fa-clock-o fa-2x" aria-hidden="true"></i></a></li>
        <li><a href="#"><i class="fa fa-calculator fa-2x" aria-hidden="true"></i></a></li>
        <li><a href="#"><i class="fa fa-graduation-cap fa-2x" aria-hidden="true"></i></a></li>
        <li><a href="#"><i class="fa fa-pie-chart fa-2x" aria-hidden="true"></i></a></li>
        @endif
        </ul>
        <!-- Right Side Of Navbar -->
        <ul class="nav navbar-nav navbar-right">
            <li><img src="{{ asset('storage/icon/General-Logo.png') }}" class="logo"></li>
        </ul>
    </div><!--/.nav-collapse -->
    </div>
</nav>
