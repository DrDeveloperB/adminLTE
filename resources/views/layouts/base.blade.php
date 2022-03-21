<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ mix('css/fontawesome.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- View STYLES before common -->
    @stack('styles_before')

    <link rel="stylesheet" href="{{ mix('css/common.css') }}">

    <!-- View STYLES after common -->
    @stack('styles_after')
</head>

<body class="layout-top-nav">

<div class="wrapper">

    <!-- Navbar -->
{{--    <x-navigator>--}}
{{--        @php--}}
{{--        $subMenuName = $component->subMenuName;--}}
{{--        @endphp--}}
{{--    </x-navigator>--}}

    {{--  Templet include type 1  --}}
{{--    @include('components.header')--}}

    {{--  Templet include type 2-1  --}}
    {{--  x- 태그 사용  --}}
{{--    <x-header></x-header>--}}

    {{--  Templet include type 2-2  --}}
    {{--  x-slot 의 slot 은 호출되는 컴포넌트에서 명명된 슬롯 변수명과 일치해야함  --}}
{{--    <x-header>--}}
{{--        <x-slot name="titleSlot">--}}
{{--            Server Error--}}
{{--        </x-slot>--}}
{{--        <strong>Whoops!</strong> Something went wrong!--}}
{{--    </x-header>--}}

    {{--  Templet include type 2-3  --}}
    {{--  호출되는 컴포넌트의 메소드 호출  --}}
{{--    <x-header>--}}
{{--        <x-slot name="titleSlot">--}}
{{--            {{ $component->formatAlert('message from component') }}--}}
{{--        </x-slot>--}}
{{--        <strong>Whoops!</strong> Something went wrong!--}}
{{--    </x-header>--}}

    {{--  Templet include type 3-1 : view 호출  --}}
    {{--  @component 지시어 사용  --}}
{{--    @component('components.header')--}}
{{--        <strong>Whoops!</strong> Something went wrong!--}}
{{--    @endcomponent--}}

    {{--  Templet include type 3-2  --}}
    {{--  @slot('slot') 의 slot 은 호출되는 컴포넌트에서 명명된 슬롯 변수명과 일치해야함  --}}
{{--    @component('components.header')--}}
{{--        @slot('slot')--}}
{{--            Whoops! Something went Wrong--}}
{{--        @endslot--}}
{{--    @endcomponent--}}

    {{--  Templet include type 3-3  --}}
    {{--  호출되는 컴포넌트 view 로 파라미터 직접 전달  --}}
{{--    @component('components.header', ['message' => 'retry please~'])--}}
{{--        @slot('slot')--}}
{{--            Whoops! Something went Wrong--}}
{{--        @endslot--}}
{{--    @endcomponent--}}
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    @yield('contents')

    <!-- /.content-wrapper -->

    <!-- Main Footer -->
{{--    <x-footer></x-footer>--}}
{{--    @include('components.footer')--}}
{{--    @yield('footer')--}}

</div>
<!-- ./wrapper -->

<!-- AdminLTE App -->
<script src="{{ mix('js/app.js') }}"></script>

<!-- Bootstrap 4 -->
<script src="{{ mix('js/bootstrap.js') }}"></script>

<!-- View SCRIPTS before common -->
@stack('scripts_before')

<!-- Common SCRIPTS -->
<script src="{{ mix('js/common.js') }}"></script>

<!-- View SCRIPTS after common -->
@stack('scripts_after')

</body>
</html>
