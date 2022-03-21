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
{{--    <link rel="stylesheet" href="{{ mix('css/bootstrap.css') }}">--}}

</head>
<body>

<div class="mt-4 ml-4">
    <input type="file">
    <a href="{{ route('teposts.create') }}">글쓰기</a>
    <input type="checkbox" id="select-all" class="ml-4"> 전체선택
    <button type="button" role="button" onclick="fnCheckedDel('{{ route('teposts.destroy', 'delUrl') }}')" class="ml-4">
        선택삭제
    </button>
</div>

<div class="my-2">
    @foreach($posts as $post)
        <div class="rounded border shadow p-3 my-2">
            <div class="flex justify-between my-2">
                <div class="flex">
                    <p class="font-bold text-lg ">
                        <input type="checkbox" name="ids" value="{{ $post->id }}">
                        <a href="{{ route('teposts.show', $post->id) }}" class="ml-4">
                            {{ $post->id }} : {{ $post->title }}
                        </a>
                        <a href="{{ route('teposts.edit', $post->id) }}" class="ml-4">
                            수정
                        </a>
{{--                        <a href="{{ route('teposts.destroy', $post->id) }}" class="ml-4">--}}
{{--                            삭제--}}
{{--                        </a>--}}
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
        <hr>
    @endforeach
</div>

@if($posts)
{{--    {{ $posts->links() }}--}}
    {{ $posts->links('paginate.paging4') }}
@endif



<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ mix('js/common.js') }}"></script>

<script>
{{--    @if(session()->has('message'))--}}
{{--        alert('{{ session()->get('message') }}');--}}
//         location.reload();
{{--    @endif--}}

    document.addEventListener("DOMContentLoaded", function(){
        document.getElementById('select-all').onclick = function() {
            let checkboxes = document.querySelectorAll('input[name="ids"]');
            for (let checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        }

        let ids = document.querySelectorAll('input[name="ids"]');
        for (let id of ids) {
            id.onclick = function() {
                let checkboxes = document.querySelectorAll('input[name="ids"]');
                let checkedAll = checkboxes[0].checked;
                let checkedCompare = checkboxes[0].checked;
                for (let checkbox of checkboxes) {
                    if (checkedCompare !== checkbox.checked) checkedAll = false;
                }
                document.getElementById('select-all').checked = checkedAll;
            }
        }
    });

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

    function fnCheckedDel(url)
    {
        let checkboxes = document.querySelectorAll('input[name="ids"]');
        let arr = [];
        for (let checkbox of checkboxes) {
            if (checkbox.checked) arr.push(checkbox.value);
        }

        if (arr.length === 0) {
            alert('삭제할 게시물을 선택해주세요.');
            return false;
        }

        fnDel(url.replace('delUrl', arr.join(',')));
    }
</script>

</body>
</html>
