@if($paginator->hasPages())
    <style>
        .w-80px {
            width: 80px;
        }
        .w-54px {
            width: 54px;
        }
    </style>
    <div class="container">
        <div class="row justify-content-around">
            <nav class="pagination">
                {{--            이전 버튼 시작--}}
                @if($paginator->onFirstPage())
                    <span class="px-2 py-1 text-center rounded border w-80px">
                        {!! __('pagination.first') !!}
                    </span>
                    <span class="px-2 py-1 text-center rounded border w-80px">
    {{--                        replace test--}}
                        {{--                        {!! str_replace('이전', '이전2', __('pagination.previous')) !!}--}}
                        {!! __('pagination.previous') !!}
                    </span>
                @else
                    <button onclick="location.href = '{{ $paginator->url(1) }}';" class="px-2 py-1 text-center rounded border shadow bg-white cursor-pointer w-80px">
                        {!! __('pagination.first') !!}
                    </button>
                    <button onclick="location.href = '{{ $paginator->previousPageUrl() }}';" class="px-2 py-1 text-center rounded border shadow bg-white cursor-pointer w-80px">
                        {!! __('pagination.previous') !!}
                    </button>
                @endif
                {{--            이전 버튼 종료--}}

                {{--            페이지번호 버튼 시작--}}
                @if(isset($elements) && is_array($elements))
                    @foreach($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        {{--                    @if (is_string($element))--}}
                        {{--                        <span aria-disabled="true">--}}
                        {{--                            <span class="mx-2 w-16 px-2 py-1 text-center rounded border shadow bg-white">--}}
                        {{--                                {{ $element }}--}}
                        {{--                            </span>--}}
                        {{--                        </span>--}}
                        {{--                    @endif--}}

                        @if(is_array($element))
                            @foreach($element as $page => $url)
                            <!--  Show active page two pages before and after it.  -->
                                @if ($page == $paginator->currentPage())
                                    <span class="px-2 py-1 text-center rounded border bg-primary w-54px" aria-current="page">
                                        {{ $page }}
                                    </span>
                                @elseif (
                                    // 페이지번호 리스트가 항상 5개가 표시되도록 고정
                                    // 1 ~ 3 페이지, 2 ~ 4 페이지로 노출되는 페이지번호를 1 ~ 5 페이지까지 노출되도록 고정
                                    (($paginator->currentPage() === 1 || $paginator->currentPage() === 2) && $page <= 5)
                                    // 현재 페이지번호가 항상 페이지번호 리스트 중앙에 오도록 함
                                    || ($page === $paginator->currentPage() + 1 || $page === $paginator->currentPage() + 2 || $page === $paginator->currentPage() - 1 || $page === $paginator->currentPage() - 2)
                                    // (마지막 페이지 - 3) ~ 마지막 페이지, (마지막 페이지 - 2) ~ 마지막 페이지로 노출되는 페이지번호를 (마지막 페이지 - 4) ~ 마지막 페이지까지 노출되도록 고정
                                    || (($paginator->currentPage() === ($paginator->lastPage() - 1) || $paginator->currentPage() === $paginator->lastPage()) && $page >= ($paginator->lastPage() - 4))
                                )
                                    <button onclick="location.href = '{{ $url }}';" class="px-2 py-1 text-center rounded border shadow bg-white cursor-pointer w-54px">
                                        {{ $page }}
                                    </button>
{{--                                @elseif ($page === $paginator->currentPage() + 1 || $page === $paginator->currentPage() + 2 || $page === $paginator->currentPage() - 1 || $page === $paginator->currentPage() - 2)--}}
{{--                                    <button onclick="location.href = '{{ $url }}';" class="px-2 py-1 text-center rounded border shadow bg-white cursor-pointer">--}}
{{--                                        {{ $page }}--}}
{{--                                    </button>--}}
{{--                                @elseif (($paginator->currentPage() === ($paginator->lastPage() - 1) || $paginator->currentPage() === $paginator->lastPage()) && $page >= ($paginator->lastPage() - 4))--}}
{{--                                    <button onclick="location.href = '{{ $url }}';" class="px-2 py-1 text-center rounded border shadow bg-white cursor-pointer">--}}
{{--                                        {{ $page }}--}}
{{--                                    </button>--}}
                                @endif

                                {{--                            @if($page == $paginator->currentPage())--}}
                                {{--                                <span class="mx-2 w-10 px-2 py-1 text-center rounded border shadow bg-blue-500 text-white">--}}
                                {{--                                    {{ $page }}--}}
                                {{--                                </span>--}}
                                {{--                            @else--}}
                                {{--                                <button wire:click="gotoPage({{ $page }})" class="mx-2 w-10 px-2 py-1 text-center rounded border shadow bg-white cursor-pointer">--}}
                                {{--                                    {{ $page }}--}}
                                {{--                                </button>--}}
                                {{--                            @endif--}}
                            @endforeach
                        @endif

                    @endforeach
                @endif
                {{--            페이지번호 버튼 종료--}}

                {{--            다음 버튼 시작--}}
                @if($paginator->hasMorePages())
                    <button onclick="location.href = '{{ $paginator->nextPageUrl() }}';" class="px-2 py-1 text-center rounded border shadow bg-white cursor-pointer w-80px">
                        {!! __('pagination.next') !!}
                    </button>
                    <button onclick="location.href = '{{ $paginator->url($paginator->lastPage()) }}';" class="px-2 py-1 text-center rounded border shadow bg-white cursor-pointer w-80px">
                        {!! __('pagination.last') !!}
                    </button>
                @else
                    <span class="px-2 py-1 text-center rounded border w-80px">
                        {!! __('pagination.next') !!}
                    </span>
                    <span class="px-2 py-1 text-center rounded border w-80px">
                        {!! __('pagination.last') !!}
                    </span>
                @endif
                {{--            다음 버튼 종료--}}
            </nav>
        </div>
    </div>
@endif



{{--
ul li 태그로 작성시 click 오류 발생
Uncaught TypeError: Cannot read properties of null (reading 'match')
/js/util/wire-directives.js:86
--}}
{{--        <ul class="flex justify-between">--}}
{{--            @if($paginator->onFirstPage())--}}
{{--                <li class="w-16 px-2 py-1 text-center rounded border bg-gray-100">Prev</li>--}}
{{--            @else--}}
{{--                <li wire:click="previousPage" class="w-16 px-2 py-1 text-center rounded border shadow bg-white cursor-pointer">Prev</li>--}}
{{--            @endif--}}

{{--            @if($paginator->hasMorePages())--}}
{{--                <li wire:click="nextPage" class="w-16 px-2 py-1 text-center rounded border shadow bg-white cursor-pointer">Next</li>--}}
{{--            @else--}}
{{--                <li class="w-16 px-2 py-1 text-center rounded border bg-gray-100">Next</li>--}}
{{--            @endif--}}
{{--        </ul>--}}
