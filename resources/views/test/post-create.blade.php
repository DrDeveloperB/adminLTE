<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel Summernote Editor Image Upload Example</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    {{--<link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">--}}
    {{--<link href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" rel="stylesheet">--}}
    {{--<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">--}}
    {{--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">--}}
    {{--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">--}}
{{--    <link rel="stylesheet" href="{{ mix('css/bootstrap.css') }}">--}}

    {{--<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">--}}
    {{--<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">--}}
    <link rel="stylesheet" href="{{ mix('css/summernote.css') }}">
</head>

<body>
<div class="container mt-5">
    <h1>Laravel Summernote Editor Image Upload Example - ItSolutionStuff.com</h1>
    <form method="post" action="{{ isset($post) ? route('teposts.update', $post->id) : route('teposts.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" value="{{ isset($post) ? 'PUT' : 'POST' }}">
        <input type="hidden" name="previousUrl" value="{{ request()->headers->get('referer') }}">
        <input type="hidden" name="currentUrl" value="{{ join('/', request()->segments()) }}">
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ isset($post) ? $post->title : '' }}" />
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea id="summernote" name="body">
                {{ isset($post) ? $post->body : '' }}
            </textarea>
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-success btn-block">{{ isset($post) ? '수정' : '등록' }}</button>
            <button type="button" onclick="history.back();" class="btn btn-cancle btn-block">취소</button>
        </div>
    </form>
</div>

<script src="{{ mix('js/app.js') }}"></script>
{{--<script src="{{ mix('js/app.js') }}" defer></script>--}}
<script src="{{ mix('js/common.js') }}"></script>

{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>--}}

{{--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>--}}

{{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>--}}
<script src="{{ mix('js/bootstrap.js') }}"></script>

{{--<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>--}}
<script src="{{ mix('js/summernote.js') }}"></script>
<script src="{{ mix('js/summernote-ko-KR.js') }}"></script>

<script type="text/javascript">
    console.log($.summernote)
    $(document).ready(function () {
        var fontList = ['맑은 고딕', '굴림', '궁서', '돋움', '바탕'];
        $('#summernote').summernote({
            height: 450,
            lang: 'ko-KR',
            fontNames: fontList,
            fontNamesIgnoreCheck: fontList,
        });
    });

</script>
</body>
</html>
