@extends('layouts.base')

@section('contents')
    <x-navigator></x-navigator>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <!-- SEARCH FORM -->
                        <form class="w-50">
                            <input type="hidden" id="subMenuCode" name="subMenuCode" value="{{ $subMenuCode }}">
                            <div class="input-group input-group-sm">
                                <input class="form-control bg-light border border-success border-right-0" type="search" id="keyWord" name="keyWord" placeholder="검색" aria-label="Search" value="{{ $keyWord }}">
                                <div class="input-group-append">
                                    <button class="flex btn bg-light border border-success border-left-0 rounded-right" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button id="post_create" class="flex btn bg-gradient-primary ml-3 rounded-pill" type="button" role="button">
                                        글쓰기
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.col -->
                    <!--div class="col-sm-6">
                        <h1 class="m-0 ml-auto float-right">좋은 글</h1>
                    </div><!- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $subMenuName }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6"></div>
                                    <div class="col-sm-12 col-md-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="grid1" class="table table-bordered" role="grid">
                                            <thead>
                                            <tr role="row">
                                                <th class="text-center" style="width: 34px;">번호</th>
                                                <th class="text-center" style="width: 120px;">분류</th>
                                                <th class="text-center" style="width: 108px;">사진</th>
                                                <th class="text-center" style="width: 120px;">날짜</th>
                                                <th class="text-center">제목</th>
                                                <th class="text-center" style="width: 84px;">이동아이콘</th>
                                                <th class="text-center" style="width: 96px;">공유주소</th>
{{--                                                <th class="text-center" style="width: 80px;">공유주소</th>--}}
                                                <th class="text-center" style="width: 80px;">미리보기</th>
                                                <th class="text-center" style="width: 52px;">좋아요</th>
                                                <th class="text-center" style="width: 36px;">댓글</th>
                                                <th class="text-center" style="width: 36px;">공유</th>
                                                <th class="text-center" style="width: 36px;">읽기</th>

                                                <!--th class="text-center" style="width: 70px;">번호</th>
                                                <th class="text-center" style="width: 160px;">분류</th>
                                                <th class="text-center" style="width: 146px;">사진</th>
                                                <th class="text-center" style="width: 162px;">날짜</th>
                                                <th class="text-center">제목</th>
                                                <th class="text-center" style="width: 110px;">이동아이콘</th>
                                                <th class="text-center" style="width: 124px;">공유주소</th>
                                                <th class="text-center" style="width: 110px;">미리보기</th>
                                                <th class="text-center" style="width: 80px;">좋아요</th>
                                                <th class="text-center" style="width: 64px;">댓글</th>
                                                <th class="text-center" style="width: 64px;">공유</th>
                                                <th class="text-center" style="width: 64px;">읽기</th-->
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr role="row">
                                                    <td class="align-middle">
                                                        <div class="text-center">
                                                            <span class="listNum"></span>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="text-center">
                                                            <span class="categoryName"></span>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="text-center">
                                                            <span class="thumbnail"></span>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="text-center">
                                                            <span class="openDate"></span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <span class="pop_edit title" role="button" data-url=""></span>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="text-center" style="line-height: 10px;">
                                                            <p class="bannerIcon"></p>
                                                            <p class="bannerText1"></p>
                                                            <span class="bannerText2"></span>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="text-center">
                                                            <button type="button" class="btn btn-default shareUrl" data-toggle="modal" data-target="#modal-lg" data-idx="">
                                                                주소 보기
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="text-center">
                                                            <button type="button" class="btn btn-default pop_view viewUrl" data-idx="">
                                                                글 보기
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="text-center">
                                                            <span class="po_like"></span>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="text-center">
                                                            <span class="po_comment"></span>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="text-center">
                                                            <span class="po_share"></span>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="text-center">
                                                            <span class="po_read"></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
    </div>

{{--  modal  --}}
    <x-modal>
        <x-slot name="modalTitle">
            외부 공유 주소
        </x-slot>
        <x-slot name="modalBody">
            <div class="form-group row">
                <label for="kakao" class="col-sm-2 col-form-label">카카오 스토리</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="kakao" readonly>
                </div>
                <label for="band" class="col-sm-2 col-form-label">네이버 밴드</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="band" readonly>
                </div>
                <label for="facebook" class="col-sm-2 col-form-label">페이스북</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="facebook" readonly>
                </div>
            </div>
        </x-slot>
    </x-modal>
{{--    <div class="modal fade" id="modal-lg" style="display: none;" aria-hidden="true">--}}
{{--        <div class="modal-dialog modal-lg">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h4 class="modal-title">외부 공유 주소</h4>--}}
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true">×</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <div class="form-group row">--}}
{{--                        <label for="kakao" class="col-sm-2 col-form-label">카카오 스토리</label>--}}
{{--                        <div class="col-sm-10">--}}
{{--                            <input type="text" class="form-control" id="kakao" readonly>--}}
{{--                        </div>--}}
{{--                        <label for="band" class="col-sm-2 col-form-label">네이버 밴드</label>--}}
{{--                        <div class="col-sm-10">--}}
{{--                            <input type="text" class="form-control" id="band" readonly>--}}
{{--                        </div>--}}
{{--                        <label for="facebook" class="col-sm-2 col-form-label">페이스북</label>--}}
{{--                        <div class="col-sm-10">--}}
{{--                            <input type="text" class="form-control" id="facebook" readonly>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- /.modal-content -->--}}
{{--        </div>--}}
{{--        <!-- /.modal-dialog -->--}}
{{--    </div>--}}

    <x-footer></x-footer>
@endsection

@push('styles_before')
    <x-component-grid type="styles"></x-component-grid>
@endpush

@push('scripts_before')
    <x-component-grid type="scripts"></x-component-grid>
@endpush

@push('scripts_after')
    <script>
        /**
         * Dom 로드 후 실행
         */
        document.addEventListener("DOMContentLoaded", function () {
            // XMLHttpRequest parameter
            const parameter = fnGetParam();

            // 그리드
            fnGrid(parameter);

            // 모달
            $('#modal-lg').on('show.bs.modal', function (e) {
                let $modal = $(this),
                    idx = e.relatedTarget.dataset.idx,
                    url = '{{ $shareUrl }}';

                $modal.find('#kakao').val(url + '3&idx=' + idx);
                $modal.find('#band').val(url + '4&idx=' + idx);
                $modal.find('#facebook').val(url + '5&idx=' + idx);
            });

            // 팝업 - 포스트 작성
            const pop_create_url = '{{ route('posts.create') }}';
            document.getElementById('post_create').addEventListener('click', function(event) {
                let pop = window.open(
                    pop_create_url,
                    'pop_create',
                    'scrollbars=yes, toolbar=0, location=0, directories=0, status=1, menubar=0, copyhistory=0, width=1200, height=1000, resizable=1'
                );
                pop.focus();
            });

        });

        /**
         * 폼 전송 parameter
         {{--* @returns {{}}--}}
        */
        function fnGetParam()
        {
            let parameter = {};
            parameter['subMenuCode'] = document.getElementById('subMenuCode').value;
            parameter['keyWord'] = document.getElementById('keyWord').value;

            return parameter;
        }

        /**
         * 그리드 row 데이터 생성
         * @param td
         * @param item : object XMLHttpRequest 를 통해 전송받은 posts
         * @returns {*}
         */
        function fnSetGridTd(td, item)
        {
            const bannerIconInfo = item['bannerIconInfo'];
            const context = item['context'];
            let img = '';

            td.eq(0).find('.listNum').text(fnComma(item['listNum']));
            td.eq(1).find('.categoryName').text(item['categoryName']);

            if(item['thumbnail']) {
                img = $('<img>');
                img.attr('alt', '');
                img.attr('src', item['thumbnail']);
                td.eq(2).find('.thumbnail').html(img);
                // td.eq(2).find('.thumbnail').html('<img src="'+ item['thumbnail'] +'" alt="">');
            }

            td.eq(3).find('.openDate').text(item['openDate']);

            // td.eq(4).find('.title').dataset.url = 'aaa';
            // td.eq(4).find('.title').data('aaass', 'dfsdfsd');
            td.eq(4).find('.title').attr('data-url', context['url']);
            td.eq(4).find('.title').text(item['title']);

            if(bannerIconInfo['bannerIcon']) {
                img = $('<img>');
                img.attr('alt', '');
                img.attr('src', bannerIconInfo['bannerIcon']);
                td.eq(5).find('.bannerIcon').html(img);
            }
            td.eq(5).find('.bannerText1').text(bannerIconInfo['bannerText1']);
            td.eq(5).find('.bannerText2').text(bannerIconInfo['bannerText2']);

            td.eq(6).find('.shareUrl').attr('data-idx', context['po_idx']);

            td.eq(7).find('.viewUrl').attr('data-idx', context['po_idx']);

            td.eq(8).find('.po_like').text(fnComma(context['po_like']));
            td.eq(9).find('.po_comment').text(fnComma(context['po_comment']));
            td.eq(10).find('.po_share').text(fnComma(context['po_share']));
            td.eq(11).find('.po_read').text(fnComma(context['po_read']));

            return td;
        }

        /**
         * XMLHttpRequest 를 통해 전송받은 데이터로 grid 에 사용할 데이터 생성
         * @param posts : object XMLHttpRequest 를 통해 전송받은 데이터
{{--         * @returns {{listColumns: (*|jQuery|HTMLElement|void), postsList: *[]}}--}}
        */
        function fnSetGridData(posts)
        {
            const _posts = $(posts);
            const defaultTr = $('#grid1').children('tbody').html();
            const listColumns = $([
                'listNum', 'categoryName', 'thumbnail', 'openDate', 'title', 'bannerIconInfo', 'shareUrl', 'viewUrl', 'po_like', 'po_comment', 'po_share', 'po_read',
            ]);

            let postsList = [];
            _posts.each(function (index, item) {
                let tr = $(defaultTr);
                let td = tr.children('td');

                let setTd = fnSetGridTd(td, item);

                let listItem = {};
                listColumns.each(function (list_index, list_item) {
                    listItem[list_item] = setTd.eq(list_index).html();
                });

                postsList[index] = listItem;
            });

            return {"postsList":postsList, "listColumns":listColumns};
        }

        /**
         * 그리드 옵션 생성
         * @param response : object 그리드에 사용할 수 있도록 가공된 데이터
{{--         * @returns {{data, pageLength: number, columns, ordering: boolean, searching: boolean, paging: boolean, language: {paginate: {next: string, previous: string, last: string, first: string}}, autoWidth: boolean, processing: boolean, pagingType: string, lengthChange: boolean, columnDefs: [{orderable: boolean, targets: number[]},{type: string, targets: number[]},{orderData: number[], targets: number[]},{className: string, targets: number[]}], info: boolean, order: (number|string)[]}}--}}
         */
        function fnSetGridConfig(response)
        {
            const config = {
                "processing": true,
                "data": response['postsList'],
                "columns": response['gridColumns'],
                //     [
                //     {"data":"listNum"},
                //     {"data":"categoryName"},
                //     {"data":"thumbnail"},
                //     {"data":"openDate"},
                //     {"data":"title"},
                //     {"data":"bannerIconInfo"},
                //     {"data":"shareUrl"},
                //     {"data":"viewUrl"},
                //     {"data":"po_like"},
                //     {"data":"po_comment"},
                //     {"data":"po_share"},
                //     {"data":"po_read"},
                // ],

                "paging": true,
                "pagingType": "full_numbers",
                "pageLength": 10,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "order": [0, 'desc'],     // 정렬 기준 : 컬럼 순번은 0부터 시작, asc 또는 desc
                "columnDefs": [
                    {"orderable": false, "targets": [2, 5, 6, 7]},     // 정렬 기준에서 제외
                    {
                        "type": "currency",         // currency, numeric-comma
                        "targets": [1, 4]
                    },
                    {       // 멀티 정렬
                        targets: [3],//when sorting age column
                        orderData: [0] //sort by age then by salary
                    },
                    // {"width": '1370px', "targets": 4},
                    {       // td 에 class 추가
                        "className": "align-middle",
                        "targets": [
                            0, 1, 2, 3,
                            5, 6, 7, 8, 9, 10, 11,
                        ]
                        // "targets": "_all"
                    },
                ],
                "language": {
                    "paginate": {
                        "first": "처음",
                        "previous": "이전",
                        "next": "다음",
                        "last": "마지막",
                    }
                },

                // "scrollX": true,
                // "scrollY": "100%",
                // scrollCollapse : true,
                // responsive: false,

                // 헤더 고정
                // "fixedHeader" : {
                //     header : true,
                //     footer : false,
                //     headerOffset: 0
                // },
                // fixedColumns: {
                //     leftColumns: 1,
                // },
            }

            return config;
        }

        /**
         * 그리드 생성 및 그리드에 적용할 이벤트 생성
         * @param config : object 그리드 옵션
         */
        function fnCreateGrid(config)
        {
            let grid1 = $('#grid1').DataTable(config);

            // 팝업
            const pop_view_url = '{{ $viewUrl }}';
            $('#grid1 tbody').on('click', 'tr td', function (index, item) {
                // 팝업 - 포스트 수정
                if (this.querySelectorAll('.pop_edit').length > 0) {
                    let pop = window.open(
                        this.querySelectorAll('.pop_edit')[0].dataset.url,
                        'pop_edit',
                        'scrollbars=yes, toolbar=0, location=0, directories=0, status=1, menubar=0, copyhistory=0, width=600, height=800, resizable=1'
                    );
                    pop.focus();
                }
                // 팝업 - 미리보기
                else if (this.querySelectorAll('.pop_view').length > 0) {
                    let pop_view = window.open(
                        pop_view_url + this.querySelectorAll('.pop_view')[0].dataset.idx,
                        'pop_view',
                        'scrollbars=yes, toolbar=0, location=0, directories=0, status=1, menubar=0, copyhistory=0, width=600, height=800, resizable=1'
                    );
                    pop_view.focus();
                }
            });

            // // 팝업 - 포스트 수정
            // $('#grid1 tbody').on('click', 'tr td .pop_edit', function () {
            //     let pop = window.open(
            //         this.dataset.url,
            //         'pop_edit',
            //         'scrollbars=yes, toolbar=0, location=0, directories=0, status=1, menubar=0, copyhistory=0, width=600, height=800, resizable=1'
            //     );
            //     pop.focus();
            // });
            // const buttons_pop_edit = document.querySelectorAll(".pop_edit");
            // for (const button of buttons_pop_edit) {
            //     button.addEventListener('click', function(event) {
            //         let pop = window.open(
            //             this.dataset.url,
            //             'pop_edit',
            //             'scrollbars=yes, toolbar=0, location=0, directories=0, status=1, menubar=0, copyhistory=0, width=600, height=800, resizable=1'
            //         );
            //         pop.focus();
            //     });
            // }

            // // 팝업 - 미리보기
            // $('#grid1 tbody').on('click', 'tr td .pop_view', function () {
            //     let pop_view = window.open(
            //         pop_view_url + this.dataset.idx,
            //         'pop_view',
            //         'scrollbars=yes, toolbar=0, location=0, directories=0, status=1, menubar=0, copyhistory=0, width=600, height=800, resizable=1'
            //     );
            //     pop_view.focus();
            // });
            // const buttons_pop_view = document.querySelectorAll(".pop_view");
            // for (const button of buttons_pop_view) {
            //     button.addEventListener('click', function(event) {
            //         let pop_view = window.open(
            //             pop_view_url + this.dataset.idx,
            //             'pop_view',
            //             'scrollbars=yes, toolbar=0, location=0, directories=0, status=1, menubar=0, copyhistory=0, width=600, height=800, resizable=1'
            //         );
            //         pop_view.focus();
            //     });
            // }

        }

        /**
         * 그리드 생성을 위한 데이터 통신
         * 그리드 옵션 ajax 를 사용하지 않고 axios 사용 (Promise)
         * axios 장점 :
         *  토큰 전송을 위한 헤더 수정 불필요
         *  확장성 있는 옵션
         *  편리한 디버깅
         * @param parameter
         * @returns {Promise<{data, pageLength: number, columns, ordering: boolean, searching: boolean, paging: boolean, language: {paginate: {next: string, previous: string, last: string, first: string}}, autoWidth: boolean, processing: boolean, pagingType: string, lengthChange: boolean, columnDefs: [{orderable: boolean, targets: number[]},{type: string, targets: number[]},{orderData: number[], targets: number[]},{className: string, targets: number[]}], info: boolean, order: (number|string)[]}>}
         */
        function fnGrid(parameter)
        {
            // https://inpa.tistory.com/entry/AXIOS-%F0%9F%93%9A-%EC%84%A4%EC%B9%98-%EC%82%AC%EC%9A%A9
            return axios({
                url: 'posts/ajax_list',    // 통신할 웹문서
                // method: 'get',             // 요청방식. (get이 디폴트)
                // params: {
                //     foo: 'diary'
                // },                          // URL 파라미터 ( ?key=value 로 요청하는 url get방식을 객체로 표현한 것)
                method: 'post',          // 통신할 방식
                data: parameter,                       // 요청 방식이 'PUT', 'POST', 'PATCH' 해당하는 경우 body에 보내는 데이터
                // withCredentials: true,      // cross-site access-control 요청을 허용 유무. 이를 true로 하면 cross-origin으로 쿠키값을 전달 할 수 있다.
                // headers: {'X-Requested-With': 'XMLHttpRequest'},     // 요청 헤더
            })
                .then(function (response) {
                    const data = response['data'] ?? [];
                    return data['posts'] ?? [];
                })
                .then(function(posts) {
                    return fnSetGridData(posts);
                })
                .then(function (response) {
                    const listColumns = response['listColumns'] ?? [];

                    let gridColumns = [];
                    listColumns.each(function (index, item) {
                        gridColumns[index] = {"data": item};
                    });
                    response['gridColumns'] = gridColumns;

                    return response;
                })
                .then(function (response) {
                    return fnSetGridConfig(response);
                })
                .then(function (config) {
                    fnCreateGrid(config);
                })
                .catch(function (error) {
                    if (error.response) {
                        // 요청이 전송되었고, 서버는 2xx 외의 상태 코드로 응답했습니다.
                        console.log(error.response.data);
                        console.log(error.response.status);
                        console.log(error.response.headers);
                    } else if (error.request) {
                        // 요청이 전송되었지만, 응답이 수신되지 않았습니다.
                        // 'error.request'는 브라우저에서 XMLHtpRequest 인스턴스이고,
                        // node.js에서는 http.ClientRequest 인스턴스입니다.
                        console.log(error.request);
                    } else {
                        // 오류가 발생한 요청을 설정하는 동안 문제가 발생했습니다.
                        console.log('Error', error.message);
                    }
                    console.log(error.config);
                });
        }

        // 그리드 생성 : axios 로 대체
        // function fnGrid(parameter)
        // {
        //     const defaultTr = $('#grid1').children('tbody').html();
        //     const listColumns = $(['listNum', 'categoryName', 'thumbnail', 'openDate', 'title', 'bannerIconInfo', 'shareUrl', 'viewUrl', 'po_like', 'po_comment', 'po_share', 'po_read',]);
        //     let gridColumns = [];
        //     listColumns.each(function (index, item) {
        //         gridColumns[index] = {"data": item};
        //     });
        //
        //     let grid1 = $('#grid1').DataTable({
        //         "processing": true,
        //         "ajax": {
        //             "url": "posts/ajax_list",
        //             "type": "POST",
        //             "data": parameter,
        //             // set header
        //             'beforeSend': function (request) {
        //                 const token = $('meta[name="csrf-token"]').attr('content');
        //                 // required type post
        //                 request.setRequestHeader("X-CSRF-TOKEN", token);
        //             },
        //             "dataSrc": function ( responseData ) {
        //                 let postsList = [];
        //                 const posts = responseData['posts'] ? $(responseData['posts']) : [];
        //
        //                 posts.each(function (index, item) {
        //                     let tr = $(defaultTr);
        //                     let td = tr.children('td');
        //
        //                     let setTd = fnSetGridTd(td, item);
        //
        //                     let listItem = {};
        //                     listColumns.each(function (list_index, list_item) {
        //                         listItem[list_item] = setTd.eq(list_index).html();
        //                     });
        //
        //                     // listItem['listNum'] = td.eq(0).html();
        //                     // listItem['categoryName'] = td.eq(1).html();
        //                     // listItem['thumbnail'] = td.eq(2).html();
        //                     // listItem['openDate'] = '';
        //                     // listItem['title'] = '';
        //                     // listItem['bannerIconInfo'] = '';
        //                     // listItem['shareUrl'] = '';
        //                     // listItem['viewUrl'] = '';
        //                     // listItem['po_like'] = '';
        //                     // listItem['po_comment'] = '';
        //                     // listItem['po_share'] = '';
        //                     // listItem['po_read'] = '';
        //                     postsList[index] = listItem;
        //                 });
        //
        //                 return postsList;
        //             },
        //         },
        //
        //         "columns": gridColumns,
        //         //     [
        //         //     {"data":"listNum"},
        //         //     {"data":"categoryName"},
        //         //     {"data":"thumbnail"},
        //         //     {"data":"openDate"},
        //         //     {"data":"title"},
        //         //     {"data":"bannerIconInfo"},
        //         //     {"data":"shareUrl"},
        //         //     {"data":"viewUrl"},
        //         //     {"data":"po_like"},
        //         //     {"data":"po_comment"},
        //         //     {"data":"po_share"},
        //         //     {"data":"po_read"},
        //         // ],
        //
        //         "paging": true,
        //         "pagingType": "full_numbers",
        //         "pageLength": 10,
        //         "lengthChange": false,
        //         "searching": false,
        //         "ordering": true,
        //         "info": false,
        //         "autoWidth": false,
        //         "order": [0, 'desc'],     // 정렬 기준 : 컬럼 순번은 0부터 시작, asc 또는 desc
        //         "columnDefs": [
        //             {"orderable": false, "targets": [2, 5, 6, 7]},     // 정렬 기준에서 제외
        //             {
        //                 "type": "currency",         // currency, numeric-comma
        //                 "targets": [1, 4]
        //             },
        //             {       // 멀티 정렬
        //                 targets: [3],//when sorting age column
        //                 orderData: [0] //sort by age then by salary
        //             },
        //             // {"width": '1370px', "targets": 4},
        //             {       // td 에 class 추가
        //                 "className": "align-middle",
        //                 "targets": [
        //                     0, 1, 2, 3,
        //                     5, 6, 7, 8, 9, 10, 11,
        //                 ]
        //                 // "targets": "_all"
        //             },
        //         ],
        //         "language": {
        //             "paginate": {
        //                 "first": "처음",
        //                 "previous": "이전",
        //                 "next": "다음",
        //                 "last": "마지막",
        //             }
        //         },
        //
        //         // "scrollX": true,
        //         // "scrollY": "100%",
        //         // scrollCollapse : true,
        //         // responsive: false,
        //
        //         // 헤더 고정
        //         // "fixedHeader" : {
        //         //     header : true,
        //         //     footer : false,
        //         //     headerOffset: 0
        //         // },
        //         // fixedColumns: {
        //         //     leftColumns: 1,
        //         // },
        //     });
        //
        // }

    </script>
@endpush
