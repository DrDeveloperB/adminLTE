<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>

<div>
    <a href="{{ route('teposts.index') }}">목록</a>
</div>

<div class="my-2">
    <div class="rounded border shadow p-3 my-2">
        <div class="flex justify-between my-2">
            <div class="flex">
                <p class="font-bold text-lg ">
                    {{ $post->id }} : {{ $post->title }}
                    <a href="{{ route('teposts.edit', $post->id) }}" class="ml-4">
                        수정
                    </a>
                    <button type="button" role="button" onclick="fnDel('{{ route('teposts.destroy', $post->id) }}')" class="ml-4">
                        삭제
                    </button>
                </p>
                <p class="mx-3 py-1 text-xs text-grey-500 font-semibold">
                    {{ $post->created_at }}
                </p>
            </div>
        </div>

        <p class="text-grey-800">
            {!! $post->body !!}
        </p>
    </div>
</div>

<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ mix('js/common.js') }}"></script>

<script>
{{--    @if(session()->has('message'))--}}
{{--    alert('{{ session()->get('message') }}');--}}
//         location.reload();
{{--    @endif--}}

    function fnDel(url)
    {
        if (confirm('삭제하시겠습니까?')) {
            let oFrmConfig = {
                'inHtml': true,
                'method': 'post',
                'action': url
            };
            let oParam = {
                '_method': 'DELETE',
                '_token': document.querySelector('meta[name="csrf-token"]').content,
            }
            let oFrm = fnCreateFrm(oFrmConfig, oParam);
            oFrm.submit();
        }
    }
</script>

</body>
</html>
