
<nav id="main_navbar" class="main-header navbar navbar-expand logo_wrapper navbar-light">
    <div class="container-fluid">
        <a href="/" class="navbar-brand">
            <span class="logo">아침편지</span>
        </a>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- navbar links -->
            <ul class="navbar-nav">
                @foreach($accessMenu as $k => $mainMenu)
                    @if(isset($mainMenu['sub']))
                        {{-- 드롭다운 메뉴 --}}
                        <li class="nav-item dropdown">
                            <a id="dropdownSubMenu{{ $k }}" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link font-weight-bold dropdown-toggle {{ $mainMenu['mainClass'] }}">{{ $mainMenu['name'] }}</a>
                            <ul aria-labelledby="dropdownSubMenu{{ $k }}" class="dropdown-menu border-0 shadow">
                                @foreach($mainMenu['sub'] as $k2 => $subMenu)
                                    <li><a href="{{ route($mainMenu['code'] . '.index') . '?subMenuCode=' . $subMenu['code'] }}" class="dropdown-item {{ $subMenu['subClass'] }}">{{ $subMenu['name'] }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        {{-- 단일 메뉴 --}}
                        <li class="nav-item">
                            <a href="{{ route($mainMenu['code'] . '.index') }}" class="nav-link font-weight-bold {{ $mainMenu['mainClass'] }}">
                                {{ $mainMenu['name'] }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>

            <!-- dark mode slider -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-none d-sm-inline-block">
                    <span class="nav-link px-0 font-weight-bold">Dark Mode</span>
                </li>
                <li class="nav-item">
                    <div class="theme-switch-wrapper nav-link pl-1">
                        <label class="theme-switch" for="dark_mode_switch">
                            <input type="checkbox" id="dark_mode_switch">
                            <span class="slider round"></span>
                        </label>
                    </div>
                </li>
            </ul>

        </div>

    </div>
</nav>
