@extends('layouts.base')

@section('contents')
    <nav class="d-flex flex-row border-bottom bg-success fixed-top" style="min-width: 1200px;">
        <div class="card-header border-bottom-0">
            <span style="font-size: 20px;">포스팅</span>
        </div>
        <div class="p-2 ml-auto">
            <button type="button" id="btn_submit" class="btn btn-primary">{{ isset($post) ? '수정' : '등록' }}</button>
        </div>
        <div class="p-2">
            <button type="button" onclick="window.close();" class="btn btn-default">취소</button>
        </div>
    </nav>

    <div class="container-fluid" style="margin-top: 60px; min-width: 1200px;">
        <div class="card card-info">

        {{--        <div class="d-flex flex-row border-bottom bg-success fixed-top">--}}
        {{--            <div class="card-header border-bottom-0">--}}
        {{--                <span style="font-size: 20px;">포스팅</span>--}}
        {{--            </div>--}}
        {{--            <div class="p-2 ml-auto">--}}
        {{--                <button type="button" class="btn btn-primary">{{ isset($post) ? '수정' : '등록' }}</button>--}}
        {{--            </div>--}}
        {{--            <div class="p-2">--}}
        {{--                <button type="button" onclick="window.close();" class="btn btn-default">취소</button>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        <!-- /.card-header -->

            <!-- form start -->
            <form id="frm" method="post" action="{{ isset($post) ? route('posts.update', $post->po_idx) : route('posts.store') }}" enctype="multipart/form-data" class="form-horizontal">
                @csrf
                <input type="hidden" name="_method" value="{{ isset($post) ? 'PUT' : 'POST' }}">
                <input type="hidden" name="previousUrl" value="{{ request()->headers->get('referer') }}">
                <input type="hidden" name="currentUrl" value="{{ join('/', request()->segments()) }}">
                <input type="hidden" name="po_idx" value="{{ isset($post) ? $post->po_idx : '' }}">
                <div class="card-body">

                    @if(isset($post))
                        <div class="form-group row align-items-center">
                            <label for="po_idx" class="col-sm-2 col-form-label">게시물 번호</label>
                            <div class="col-sm-10">
                                <input type="hidden" class="form-control" id="po_idx">
                                <span>{{ isset($post) ? $post->po_idx : '' }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="po_order" class="col-sm-2 col-form-label">인기순서</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="po_order" name="po_order" placeholder="인기순서" value="{{ isset($post) ? $post->po_order : '' }}">
                            </div>
                        </div>
                    @endif

                    <div class="form-group row">
                        <label for="po_cate" class="col-sm-2 col-form-label">카테고리</label>
                        <div class="col-sm-10">
                            <select id="po_cate" name="po_cate" class="custom-select">
                                @foreach($category as $v)
                                    <option value="{{ $v['code'] }}" {{ $po_cate == $v['code'] || (isset($post) && $post->po_cate == $v['code']) ? 'selected' : '' }}>{{ $v['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="po_title" class="col-sm-2 col-form-label">제목</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="po_title" name="po_title" placeholder="제목" value="{{ !empty($po_title) ? $po_title : (isset($post) ? $post->title : '') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="po_date" class="col-sm-2 col-form-label">등록 시간</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="po_date" name="po_date" placeholder="2000-01-01 00:00:00" value="{{ isset($post) ? $post->po_date : '' }}">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="po_icon_url" class="col-sm-2 col-form-label">이동 아이콘</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="po_icon_url" name="po_icon_url" placeholder="게시물번호 or url(http포함)" value="{{ isset($post) ? $post->po_icon_url : '' }}">
                        </div>
                    </div>

                    <div class="form-group row">

                        <div class="offset-sm-2 col-sm-10 row">
                            <div class="form-control d-flex justify-content-center p-1 border-bottom-0" style="width: 120px; height: 70px; border-radius: 4px 4px 0 0;">
                                <img src="{{ config('app.image_url') . config('app.storage_old.img_po') }}micon1.png" class="align-self-center" style="width: 80px;" alt="">
                            </div>
                            <div class="form-control d-flex justify-content-center p-1 border-bottom-0 ml-2" style="width: 120px; height: 70px; border-radius: 4px 4px 0 0;">
                                <input type="hidden" id="icon_default" value="{{ isset($post) ? $post->po_icon : asset('storage/no_image.png') }}">
                                <img src="{{ asset('storage/no_image.png') }}" id="icon_selected" class="align-self-center" style="width: 80px; height: 53px;" alt="">
                            </div>

                            <div class="form-control d-flex p-1 ml-2 flex-column" style="width: 695px; height: 70px; border-radius: 4px 4px 4px 4px;">
                                <div class="row">
                                    <label for="po_icon" class="col-sm-2 col-form-label">아이콘</label>
                                    <div class="col-sm-10">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="po_icon" name="po_icon">
                                            <label class="custom-file-label" for="po_icon">아이콘 선택</label>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <span style="font-size: 14px;">( ※ 70 KB 이하 png 파일만 등록 가능합니다. / 적정 이미지 사이즈 150*150 이하 )</span>
                                </div>
                            </div>
                        </div>

                        {{--
                        po_icon 값이 있고 파일이 존재하면 저장된 이미지 표시 그렇지않으면 no_image 표시
                        po_icon 값이 있고 micon1.png 와 이름이 같다면 전체(고정) 선택 그렇지않으면 임의 선택
                        --}}
                        <div class="offset-sm-2 col-sm-10 row">
                            <div class="form-control d-flex justify-content-center p-1 border-top-0" style="width: 120px; height: 36px; border-radius: 0 0 4px 4px;">
                                <div class="custom-control custom-radio text-center">
                                    <input class="custom-control-input" type="radio" id="icon_fix" name="icon_type" checked="">
                                    <label for="icon_fix" class="custom-control-label">전체(고정)</label>
                                </div>
                            </div>
                            <div class="form-control d-flex justify-content-center p-1 border-top-0 ml-2" style="width: 120px; height: 36px; border-radius: 0 0 4px 4px;">
                                <div class="custom-control custom-radio text-center">
                                    <input class="custom-control-input" type="radio" id="icon_select" name="icon_type">
                                    <label for="icon_select" class="custom-control-label">임의</label>
                                </div>
                            </div>


                            <div class="row ml-2">
                                <div class="form-control d-flex justify-content-center p-1" style="width: 120px; height: 36px;">
                                    <div class="custom-control custom-checkbox text-center">
                                        <input class="custom-control-input" type="checkbox" id="customCheckbox1" name="po_icon_use" value="1">
                                        <label for="customCheckbox1" class="custom-control-label">보임 여부</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <span class="col-sm-2 col-form-label" style="cursor: default;">사진</span>
                        <div class="col-sm-10 row">
                            <div class="form-control d-flex justify-content-center p-1 ml-2" style="width: 120px; height: 70px; border-radius: 4px 4px 4px 4px;">
                                <input type="hidden" id="image_default" value="{{ isset($post) ? $post->po_image : asset('storage/no_image.png') }}">
                                <img src="{{ isset($post) ? $post->po_image : asset('storage/no_image.png') }}" id="image_selected" class="align-self-center" style="width: 80px; height: 53px;" alt="">
                            </div>

                            <div class="custom-file ml-2" style="width: 822px; margin-right: -0.5rem !important;">
                                <input type="file" class="custom-file-input" id="po_image" name="po_image">
                                <label class="custom-file-label" for="po_image">썸네일 선택</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="banner_tag" class="col-sm-2 col-form-label">태그 복사</label>
                        <div class="col-sm-10">
                        <span>
                            ※ 내용에 태그
                            <input type="text" id="banner_tag" value="{{ config('app.banner_post_view') }}" class="border-0" style="width: 98px;" readonly>
                            입력시 해당 위치에 띠배너 노출 됩니다.
                        </span>
                            <span class="ml-1"><button type="button" class="copy_text_input btn btn-info">태그복사</button></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="summernote" class="col-sm-2 col-form-label">내용</label>
                        <div class="col-sm-10">
                            <textarea id="summernote" name="po_content">{{ isset($post) ? $post->body : '' }}</textarea>
{{--                            <textarea id="summernote" name="po_content">{{ !empty($po_content) ? $po_content : (isset($post) ? $post->body : '') }}</textarea>--}}
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer" style="margin-top: -40px;">
                    {{--                <button type="submit" class="btn btn-info">Sign in</button>--}}
                    {{--                <button type="submit" class="btn btn-default float-right">Cancel</button>--}}
                </div>
                <!-- /.card-footer -->
            </form>
        </div>

    </div>
@endsection

@push('styles_before')
    <x-component-summernote type="styles"></x-component-summernote>
    {{--    @php($type = 'css')--}}
    {{--    <x-summernote :type2="$type"></x-summernote>--}}
    {{--
    slot 에 파라미터 전달시 array 형태 전달 불가

    type="css" :
        파라미터명 : type
        파라미터값 : css (string)

    :msg="$message"
        파라미터명 : msg
        파라미터값 : $message
            파라미터값에 문자열 직접 입력 불가, 반드시 변수에 담아서 변수를 입력해야함
    --}}
    {{--    @php ($message = '안녕 라라벨')--}}
    {{--    <x-summernote-css type="css" :msg="$message"></x-summernote-css>--}}
    {{--<x-summernote-css></x-summernote-css>--}}
@endpush

{{--@push('styles_after')--}}
{{--    <style>--}}
{{--        /*.dark-mode select {*/--}}
{{--        /*    background: #fff url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='rgb(256,256,256)' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E") right 0.75rem center/8px 10px no-repeat;*/--}}
{{--        /*}*/--}}
{{--        /*body {font-family: '맑은 고딕','Malgun Gothic','돋움','Dotum','Helvetica','AppleGothic','Sans-serif'; font-size: 13px;  color:#555; line-height: 150%; background-color:#ffffff;}*/--}}
{{--    </style>--}}
{{--@endpush--}}

@push('scripts_before')
    <x-component-summernote type="scripts"></x-component-summernote>
    <x-component-validate type="scripts"></x-component-validate>
    {{--    <x-summernote-css type="script"></x-summernote-css>--}}
    {{--    <x-summernote-script></x-summernote-script>--}}
@endpush

@push('scripts_after')
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            // custom-file-input
            bsCustomFileInput.init();

            // 입력 값 검증 - jQuery Validation
// console.log($.validator.defaults)
            $.validator.setDefaults({
                onkeyup: false,
                onclick: false,
                onfocusout: false,
                showErrors: function (errorMap, errorList) {
                    if (this.numberOfInvalids()) {
                        alert(errorList[0].message);
                    }
                },
                // submitHandler: function () {
                //     alert( "Form successful submitted!" );
                // },
            });
// console.log($('#frm').validate())
            $('#frm').validate({
                rules: {
                    po_cate: {
                        required: true,
                    },
                    po_title: {
                        required: true,
                    },
                    // po_content: {
                    //     required: true,
                    // },
                },
                messages: {
                    po_cate: {
                        required: "카테고리를 선택해주세요.",
                    },
                    po_title: {
                        required: "제목을 입력해주세요.",
                    },
                    // po_content: {
                    //     required: "내용을 입력해주세요.",
                    // },
                },
                submitHandler: function(){
                    // form 전송
                    // var textareaValue = $('#summernote').summernote('code');
                    if($('#summernote').summernote('isEmpty')) {
                        alert('내용을 입력해주세요.');
                        // cancel submit
                        e.preventDefault();
                    }
                    else {
                        document.forms['frm'].submit();
                    }
                },

                // 오류 div 컨트롤
                // errorElement: 'span',
                // errorPlacement: function (error, element) {
                //     console.log(error)
                //     error.addClass('invalid-feedback');
                //     element.closest('.form-group').append(error);
                // },
                // highlight: function (element, errorClass, validClass) {
                //     $(element).addClass('is-invalid');
                // },
                // unhighlight: function (element, errorClass, validClass) {
                //     $(element).removeClass('is-invalid');
                // },
            });

            // 등록, 수정 - jQuery 버전
            $('#btn_submit').on('click', function () {
                $('#frm').submit();
            });

            // 등록, 수정
            {{--document.querySelector('.btn_submit').addEventListener('click', function(event) {--}}
            {{--    console.log(document.querySelector('#po_cate').value)--}}
            {{--    if(document.querySelector('#po_cate').value === '') {--}}
            {{--        alert('카테고리를 선택해주세요.');--}}
            {{--        return false;--}}
            {{--    }--}}

            {{--    if(confirm('{{ isset($post) ? '수정' : '등록' }}하시겠습니까?')) {--}}
            {{--        document.forms['frm'].submit();--}}
            {{--    }--}}
            {{--});--}}

            // summernote
            var fontList = ['맑은 고딕', '굴림', '궁서', '돋움', '바탕'];
            $('#summernote').summernote({
                height: 320,
                lang: 'ko-KR',
                fontNames: fontList,
                fontNamesIgnoreCheck: fontList,
                // fontName: 'Arial',
            });
            {{--$('#summernote').summernote('code', '{{ isset($post) ? $post->body : '' }}');--}}
            // $('#summernote').summernote('fontName', 'Arial');

            // 텍스트 복사
            document.querySelector('.copy_text_input').addEventListener('click', function(event) {
                copy_text_input('banner_tag', '');
            });

            // 아이콘 이미지 화면 표시
            document.getElementById('po_icon').addEventListener('change', function(event) {
                fnDrawImg(this.files[0], 'icon_default', 'icon_selected');
            });

            // 썸네일 이미지 화면 표시
            document.getElementById('po_image').addEventListener('change', function(event) {
                fnDrawImg(this.files[0], 'image_default', 'image_selected');
            });

        });

    </script>
@endpush
