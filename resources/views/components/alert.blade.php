@props(['type' => 'info', 'message' => 'msg'])

<div {{ $attributes->merge(['class' => 'alert alert-'.$type]) }}>
    {{ $message }}
</div>


{{--<!-- summernote - for Bootstrap 4 -->--}}
{{----}}
{{--$type : 값을 직접 입력한 파라미터 (type="css")--}}
{{--$msg : 값에 변수를 입력한 파라미터 (:msg="$message")--}}

{{--@props : 변수 선언 지시어 (컴포넌트 전용, 전달받는 값이 없을 경우를 대비해 초기값 지정 가능)--}}
{{----}}
{{--@props(['type' => 'css', 'msg' => 'props 변수 선언'])--}}
{{--@if($type === 'css')--}}
{{--    {{ $msg }}--}}
{{--    <link rel="stylesheet" href="{{ mix('css/summernote.css') }}">--}}
{{--@endif--}}

{{--@if($type === 'script')--}}
{{--    <!-- summernote - for Bootstrap 4 -->--}}
{{--    <script src="{{ mix('js/summernote.js') }}"></script>--}}
{{--    <script src="{{ mix('js/summernote-ko-KR.js') }}"></script>--}}

{{--    <!-- Bootstrap 4 - custom-file-input -->--}}
{{--    --}}{{-- 에디터 영역외 첨부파일 추가시 사용 : 썸네일 추가 --}}
{{--    <script src="{{ mix('js/bs-custom-file-input.js') }}"></script>--}}

{{--@endif--}}
