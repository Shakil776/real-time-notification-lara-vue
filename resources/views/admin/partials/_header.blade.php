<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon" data-feather="menu"></i></a></li>
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ml-auto">
            <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon" data-feather="moon"></i></a></li>
        
            <li class="nav-item dropdown dropdown-notification mr-25"><a class="nav-link" href="javascript:void(0);" data-toggle="dropdown"><i class="ficon" data-feather="bell"></i><span class="badge badge-pill badge-danger badge-up">5</span></a>
            </li>
            
            <li class="nav-item dropdown dropdown-user">

                <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none text-center">
                        <span class="user-name font-weight-bolder">@if(Auth::check()) {{ Auth::user()->name }} @endif</span>
                        <span class="user-status">{{ str_replace(['["','"]'], '', Auth::user()->roles->pluck('name')) }}</span>
                    </div>
                    <span class="avatar" id="headerProfilePohotoID">
                        @if(Auth::check() && !empty(Auth::user()->image))
                            <img class="round" src="{{ asset('uploads/profileImage/'.Auth::user()->image) }}" alt="avatar" height="40" width="40">
                            <span class="avatar-status-online"></span>
                        @else
                            <img class="round" src="{{ asset('admin/assets/img/default.png') }}" alt="avatar" height="40" width="40">
                            <span class="avatar-status-online"></span>
                        @endif
                    </span>

                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="{{ route('profile') }}"><i class="mr-50" data-feather="user"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item"  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="mr-50" data-feather="power"></i> Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>