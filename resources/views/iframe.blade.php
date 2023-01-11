@extends('layouts.base')

@section('contents')
    <x-navigator></x-navigator>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    @if($result)
                        <iframe id="frm" src="{{ $url }}" style="width: 1900px; height: 800px;"></iframe>
                    @else
                        <div class="text-center mt-5 form-control-lg">wait</div>
                        <div id="timer" class="text-center"></div>
                    @endif
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
    </div>
@endsection

@push('styles_before')
@endpush

@push('styles_after')
    <style>
    </style>
@endpush

@push('scripts_before')
@endpush

@push('scripts_after')
    @unless($result)
        <script>
            /**
             * Dom 로드 후 실행
             */
            document.addEventListener("DOMContentLoaded", function () {
                {{--let i = 3;--}}
                {{--let timerId = setInterval(() => {--}}
                {{--    document.querySelector('#timer').innerText = i;--}}
                {{--    i--;--}}
                {{--}, 1000);--}}

                {{--setTimeout(function() {--}}
                {{--    clearInterval(timerId);--}}
                {{--    window.location.href = "{{ route('posts.chkUrl') }}"--}}
                {{--}, i*1000);--}}
            });
        </script>
    @endif
@endpush
