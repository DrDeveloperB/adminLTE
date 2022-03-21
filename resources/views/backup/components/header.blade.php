{{--slot test--}}
{{--<span class="alert-title">{{ $titleSlot }}</span>--}}
{{--<div class="alert alert-danger">--}}
{{--    {{ $slot }}--}}
{{--    {{ $message }}--}}
{{--</div>--}}
{{--@php--}}
{{--die;--}}
{{--@endphp--}}

{{--{{ ddd($accessMenu) }}--}}
{{--{{ ddd(route('posts.index')) }}--}}
{{--{{ ddd(route('posts' . '.index')) }}--}}
{{--{{ ddd(Request::segment(1)) }}--}}
{{--{{ ddd($cateCode) }}--}}
{{--
템플릿 생성
slot 사용
파라미터 전달
--}}

<nav id="main_navbar" class="main-header navbar navbar-expand logo_wrapper navbar-light">
    <div class="container-fluid">
        <a href="/" class="navbar-brand">
            <span class="logo">아침편지</span>
        </a>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- navbar links -->
            <ul class="navbar-nav">
                @php
                    foreach($defaultMenu as $k => $menu) {
                        $classDropDown = '';
                        $attributeHref = route($menu['code'] . '.index');
                        $addAttribute = '';
                        $addClass = $menu['code'] === Request::segment(1) ? 'bg-info' : '';
                        $menuName = $menu['name'];
                        $subMenuHtml = '';

                        if (isset($menu['sub'])) {
                            $classDropDown = 'dropdown';
                            $attributeHref = '#';
                            $addAttribute = sprintf('id="dropdownSubMenu%s" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"', $k);
                            $addClass .= ' dropdown-toggle';
                            $subMenuHtml = sprintf('<ul aria-labelledby="dropdownSubMenu%s" class="dropdown-menu border-0 shadow">', $k);
                            $subMenuHtml = <<<EOD
                    <ul aria-labelledby="dropdownSubMenu{$k}" class="dropdown-menu border-0 shadow">
                    EOD;

                            foreach($menu['sub'] as $k2 => $subMenu) {
                                $subAttributeHref = route($menu['code'] . '.index') . '?cateCode=' . $subMenu['code'];

                                $subAddClass = '';
                                if ($subMenu['code'] == $cateCode) {
                                    $subAddClass = 'bg-success';
                                    $subMenuName = $subMenu['name'];
                                }

                                $subMenuHtml .= <<<EOD
                    <li><a href="{$subAttributeHref}" class="dropdown-item {$subAddClass}">{$subMenu['name']}</a></li>
                    EOD;
                            }

                            $subMenuHtml .= '</ul>';
                        }

                        $mainMenuHtml = <<<EOD
                    <li class="nav-item {$classDropDown}">
                        <a href="{$attributeHref}" class="nav-link font-weight-bold {$addClass}" {$addAttribute}>
                            {$menuName}
                        </a>
                        {$subMenuHtml}
                    </li>
                    EOD;

                        echo $mainMenuHtml;
                    }
                @endphp

                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link font-weight-bold dropdown-toggle bg-info">{{ $subMenuName }}</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="#" class="dropdown-item">전체</a></li>
                        <li><a href="#" class="dropdown-item">감동</a></li>
                        <li><a href="#" class="dropdown-item">좋은 글</a></li>
                        <li><a href="#" class="dropdown-item">짧고 좋은 글</a></li>
                        <li><a href="#" class="dropdown-item">유명인</a></li>
                        <li><a href="#" class="dropdown-item">나만 몰랐던 이야기</a></li>
                        <li><a href="#" class="dropdown-item">명화</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link font-weight-bold">
                        포스팅
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link font-weight-bold">
                        댓글
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link font-weight-bold dropdown-toggle">회원</a>
                    <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                        <li><a href="#" class="dropdown-item">회원 관리</a></li>
                        <li><a href="#" class="dropdown-item">탈퇴회원 관리</a></li>
                    </ul>
                </li>
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
