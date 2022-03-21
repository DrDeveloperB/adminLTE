<div class="flex justify-center">
    @if($paginator->hasPages())
        {{--        Showing 28 to 30 of 41 results--}}
        {{--        <div>--}}
        {{--            <p class="text-sm text-gray-700 leading-5">--}}
        {{--                <span>{!! __('Showing') !!}</span>--}}
        {{--                <span class="font-medium">{{ $paginator->firstItem() }}</span>--}}
        {{--                <span>{!! __('to') !!}</span>--}}
        {{--                <span class="font-medium">{{ $paginator->lastItem() }}</span>--}}
        {{--                <span>{!! __('of') !!}</span>--}}
        {{--                <span class="font-medium">{{ $paginator->total() }}</span>--}}
        {{--                <span>{!! __('results') !!}</span>--}}
        {{--            </p>--}}
        {{--        </div>--}}

        <div class="w-3/4">
            <nav class="flex justify-between">
                {{--            이전 버튼 시작--}}
                @if($paginator->onFirstPage())
                    <span class="w-16 px-2 py-1 text-center rounded border bg-gray-100">
{{--                        replace test--}}
                        {{--                        {!! str_replace('이전', '이전2', __('pagination.previous')) !!}--}}
                        {!! __('pagination.previous') !!}
                    </span>
                @else
                    <button onclick="location.href = '{{ $paginator->previousPageUrl() }}';" class="w-16 px-2 py-1 text-center rounded border shadow bg-white cursor-pointer">
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
                                    <span class="page-item active" aria-current="page">
                                        {{ $page }}
                                    </span>
                                @elseif ($page === $paginator->currentPage() + 1 || $page === $paginator->currentPage() + 2 || $page === $paginator->currentPage() - 1 || $page === $paginator->currentPage() - 2)
                                    <button onclick="location.href = '{{ $url }}';" class="x-2 w-10 px-2 py-1 text-center rounded border shadow bg-white cursor-pointer">
                                        {{ $page }}
                                    </button>
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
                    <button onclick="location.href = '{{ $paginator->nextPageUrl() }}';" class="w-16 px-2 py-1 text-center rounded border shadow bg-white cursor-pointer">
                        {!! __('pagination.next') !!}
                    </button>
                @else
                    <span class="w-16 px-2 py-1 text-center rounded border bg-gray-100">
                        {!! __('pagination.next') !!}
                    </span>
                @endif
                {{--            다음 버튼 종료--}}
            </nav>
        </div>
    @endif
</div>



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
