<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Foundation\Application as AppClass;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use DOMDocument;
use Illuminate\Http\File;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class Posts extends Controller
{
    public $subMenuCode = '';
    public $subMenuName = '전체';
    public $shareUrl = '';
    public $viewUrl = '';
    /**
     * 키워드
     * @var string
     */
    public $keyWord = '';

    /**
     * 입력 값 검증
     * @var string[]
     */
    protected $rules = [
        'po_cate' => 'bail|required',
        'po_title' => 'required',
        'po_content' => 'required',
        'po_date' => 'nullable|date_format:Y-m-d H:i:s',
        'po_icon' => 'nullable|image|mimes:png|max:81920',       // 70kb = 71680, 80kb = 81920
        'po_image' => 'nullable|image|mimes:gif,jpg,jpeg,png',
    ];

    protected $messages = [
        'po_cate.required' => '카테고리를 선택해주세요.',
        'po_title.required' => '제목을 입력해주세요.',
        'po_content.required' => '내용을 입력해주세요.',
        'po_date.date_format' => '등록 시간은 년-월-일 시:분:초 형식으로 입력해주세요.',
        'po_icon.mimes' => '아이콘 이미지는 png 파일을 올려주세요.',
        'po_icon.max' => '아이콘 이미지는 70Kb 이하로 등록해주세요.',
        'po_image.mimes' => '사진은 gif, jpg, jpeg, png 파일만 가능합니다.',
    ];

    public function __construct(Request $request)
    {
        $this->subMenuCode = (string) $request->subMenuCode;
        $subMenu = getSubMenu('posts', $this->subMenuCode);
        if (isset($subMenu['name'])) $this->subMenuName = $subMenu['name'];

        $this->shareUrl = config('app.api_url') . '/land.php?mode=';

        $this->viewUrl = config('app.api_url') . '/app/view.php?idx=';

        if ($request->keyWord) $this->keyWord = $request->keyWord;



//        $this->shareUrl = secure_url('land.php?mode=');
//        $this->shareUrl = config('app.request_scheme') === 'https' ? secure_url('land.php?mode=') : url('land.php?mode=');
//        $this->shareUrl = sprintf('%s://%s/land.php?mode=', config('app.request_scheme'), $_SERVER['HTTP_HOST']);
        // http://dev.morningletters.kr/land.php?mode=3&idx=10010725
//        https://bhc1909dev.morningletters.kr/app/view.php?idx=10010725

//        ddd(
//            array(
////                $_SERVER['REQUEST_SCHEME'],
//                config('app.api_url'),
//                secure_url('land.php?mode='),
//                url('user/profile'),        // http://lte.c/user/profile
//                url('user/profile', [1]),       // set URI : http://lte.c/user/profile/1
//                secure_url('user/profile'),     // https://lte.c/user/profile
//                secure_url('user/profile', [1]),       // set URI : https://lte.c/user/profile/1
//                url()->current(),       // http://lte.c/posts
//                url()->full(),          // http://lte.c/posts?subMenuCode=
//                url()->previous(),      // http://lte.c/posts?subMenuCode=10
//                url('/') . '/data/image/thumb/1617857674m_upload.jpg',      // http://lte.c/data/image/thumb/1617857674m_upload.jpg
//                secure_url('/data/image/thumb/1617857674m_upload.jpg')      // https://lte.c/data/image/thumb/1617857674m_upload.jpg
//            )
//        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $posts = Post::list($this->subMenuCode);

        $data = array(
            'subMenuCode' => $this->subMenuCode,
            'subMenuName' => $this->subMenuName,
            'keyWord' => $this->keyWord,
//            'posts' => array(),
//            'postsCnt' => count($posts),
            'shareUrl' => $this->shareUrl,
            'viewUrl' => $this->viewUrl,
        );

//        return view('layouts.header');
        return view('post-list', $data);
    }

    public function ajax_list()
    {
        $posts = Post::list($this->subMenuCode, ['po_title' => $this->keyWord]);
        $postsCnt = count($posts);

        $postsList = array();
        foreach ($posts as $idx => $item) {
            $listItem = array();
            $listItem['listNum'] = $postsCnt - $idx;
            $listItem['categoryName'] = $item->categoryName;
            $listItem['thumbnail'] = $item->thumbnail;
            $listItem['openDate'] = $item->po_date;
            $listItem['title'] = $item->po_title;
            $listItem['bannerIconInfo'] = $item->bannerIconInfo;
            $listItem['context'] = $item;
            $listItem['context']['editUrl'] = route('posts.edit', $item->po_idx);
            $listItem['context']['viewUrl'] = route('posts.show', $item->po_idx);
            $postsList[$idx] = $listItem;
        }

        $data = array(
            'subMenuName' => $this->subMenuName,
            'posts' => $postsList,
            'shareUrl' => $this->shareUrl,
//            'viewUrl' => $this->viewUrl,      // $listItem['context']['viewUrl'] 값으로 대체
            'postsCnt' => $postsCnt,
            'keyWord' => $this->keyWord,
        );

        return json_encode($data);
//        return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create(Request $request)
    {
//        ddd($request);
        $category = getPostCategory();
        $category[0]['name'] = '카테고리';

        $po_cate = $request->po_cate ?? '';
        $po_title = $request->po_title ?? '';
//        $po_content = $request->po_content ?? '';
        $data = array(
            'category' => $category,
            'po_cate' => $po_cate,
            'po_title' => $po_title,
//            'po_content' => $po_content,
        );

        return view('post-create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $modelPost = new Post();

        $validator = Validator::make($request->all(),
            $this->rules, $this->messages
        );
//        $validator = Validator::make($request->all(),
//            [       // rules
//                'po_cate' => 'bail|required',
//                'po_title' => 'required',
//                'po_content' => 'required',
//                'po_date' => 'nullable|date_format:Y-m-d H:i:s',
//                'po_icon' => 'nullable|image|mimes:png|max:81920',       // 70kb = 71680, 80kb = 81920
//                'po_image' => 'nullable|image|mimes:gif,jpg,jpeg,png',
//            ],
//            [       // message
//                'po_cate.required' => '카테고리를 선택해주세요.',
//                'po_title.required' => '제목을 입력해주세요.',
//                'po_content.required' => '내용을 입력해주세요.',
//                'po_date.date_format' => '등록 시간은 년-월-일 시:분:초 형식으로 입력해주세요.',
//                'po_icon.mimes' => '아이콘 이미지는 png 파일을 올려주세요.',
//                'po_icon.max' => '아이콘 이미지는 70Kb 이하로 등록해주세요.',
//                'po_image.mimes' => '사진은 gif, jpg, jpeg, png 파일만 가능합니다.',
//            ]
//        );

        if ($validator->fails()) {
            $parameter = $request->all();
            // 첨부파일를 가지고 flash-message 로 이동시 오류 발생
            unset($parameter['po_icon'], $parameter['po_image'], $parameter['files'], $parameter['po_content']);
//            return redirect('posts/create')
//                ->withErrors($validator)
//                ->withInput();
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('url', $request->currentUrl);
            $request->session()->flash('request', $parameter);
            return view('flash-message');
        }

        $po_date = $request->po_date ?? date("Y-m-d- H:i:s");
//        $po_image = $request->po_image ?? '';
//        $po_icon = $request->po_icon ?? '';
        $po_icon_use = $request->po_icon_use ?? 0;
        $po_icon_url = $request->po_icon_url ?? '';

        $po_icon = '';
        $fileResult = saveFile($request, 'po_icon', 'post-banner');
        if ($fileResult['result'] === 'success') {
            $po_icon = $fileResult['fileName'];
        }

//        if ($request->hasFile('po_icon')) {
//            $po_icon = $request->file('po_icon');
//            $fileName = $po_icon->getClientOriginalName();
//            $fileName_po_icon = date('Ymd_His_') . $fileName;
//
//            Storage::disk('post-banner')->put($fileName_po_icon, file_get_contents($po_icon));
//            $po_icon = $fileName_po_icon;
////            $po_icon = Storage::disk('post-banner')->url($fileName_po_icon);
//        }

        $po_image = '';
        $fileResult = saveFile($request, 'po_image', 'thumb');
        if ($fileResult['result'] === 'success') {
            $po_image = $fileResult['fileName'];
        }

//        if ($request->hasFile('po_image')) {
////        if (!empty($request->po_image)) {
////            $po_image = $request->po_image;
//            $po_image = $request->file('po_image');
//            $fileExtension = $po_image->extension();
////            $fileMimeType = $po_image->getClientMimeType();
//            $fileName = $po_image->getClientOriginalName();
//            $fileSize = $po_image->getSize();
////            ddd($po_image, $fileExtension, $fileName, $fileSize);
//            // 저장 파일명
//            $fileName_po_image = date('Ymd_His_') . $fileName;
//
//            Storage::disk('thumb')->put($fileName_po_image, file_get_contents($po_image));
//            $po_image = $fileName_po_image;
////            $po_image = Storage::disk('thumb')->url($fileName_po_image);
//        }

        $po_content = $request->po_content;
        if ($request->hasFile('files')) {
//            $po_content = $this->saveImg($request->po_content, 'editor');
            $po_content = saveContentImg($request->po_content, 'editor');
        }

        $data = array(
            'po_cate' => $request->po_cate,
            'po_title' => $request->po_title,
            'po_date' => $po_date,
            'po_content' => $po_content,
            'po_image' => $po_image,
//            'po_regdate' => Carbon::now(),        // 모델 timestamps true
//            'po_moddate' => Carbon::now(),        // 모델 timestamps true
            'po_icon' => $po_icon,
            'po_icon_use' => $po_icon_use,
            'po_icon_url' => $po_icon_url,
            'po_like' => 0,
            'po_comment' => 0,
            'po_share' => 0,
            'po_read' => 0,
            'po_order' => 0,
        );

        /**
         * 엘로퀀트는 enableQueryLog 메소드로 쿼리 로그 확인 불가능
         * app/Providers/AppServiceProvider.php > boot > DB::listen 메소드로 처리
         */
//        DB::enableQueryLog();

        // 아침편지 디비는 MyIsam 이라 트랜잭션 지원이 안됨 OTL
//        DB::beginTransaction();
//        DB::connection('morningletters')->beginTransaction();
        // 이건 쿼리가 실행되서 안되고
        // 트랜잭션을 걸 수 있다면
        // 트랜잭션 > listen > 롤백을 실행하면 쿼리만 확인 가능할거 같다. (테스트 필요)
//        DB::listen(function ($query) {
//            $sql = $query->sql;
//            $bindings = $query->bindings;
//            $queries = array(array('query' => $sql, 'bindings' => $bindings));
//            ddd(getSqlWithBindings($queries));
//        });

        // 이건 구문 자체가 잘못된거 같다.
        // 하지만 예외 오류에서 쿼리문 확인 가능
        // 오류 발생으로 insert 실행 안됨
        // 문자열에 홑따옴표 누락되어있음
//        $builder = DB::table($modelPost->getTable());
//        $sql = $builder->getGrammar()->compileInsert($builder->insert($data));
//        ddd($sql);

        // 이건 그냥 참고용으로 놔둠
////        $builder = DB::connection('morningletters')->table($modelPost->getTable());
//        $sql = $builder->getGrammar()->compileInsert($builder->insert($data));
////        $sql = $builder->getGrammar()->compileDelete($builder->where('po_idx', '<>', 'sdf'));
//        $sql = $modelPost::create($data)->toSql();
//        ddd($sql);

        // 게시물 등록 (save 메소드도 가능)
        $post = $modelPost::create($data);
//        DB::rollBack();
//        DB::connection('morningletters')->rollBack();
        /**
         * insert into `po_list` (`po_cate`, `po_title`, `po_date`, `po_content`, `po_image`, `po_regdate`, `po_moddate`)
         * values (10, 감동 테스트 1, 2020-03-08 11:12:13, 감동 테스트 1, ?, 2022-03-08 11:33:21, 2022-03-08 11:33:21)
         */
//        ddd($post->toArray());        // result : DB row data
//        ddd($post);

        $po_idx = $post->po_idx;
//        $po_idx = $post->toArray()['po_idx'];

//        $modelPost->timestamps = false;           // timestamps 설정 변경 : 값은 변경되나 UPDATED_AT 컬럼이 계속 추가됨
//        $modelPost->setUpdatedAtAttribute(null);  // timestamps 설정 변경 : 작동 안됨
//        $modelPost->setUpdatedAt(null);           // timestamps 설정 변경 : 작동 안됨
//        ddd($modelPost->timestamps);
//        $result = $modelPost::where('po_idx', $po_idx)->update(['po_order' => $po_idx]);
        $result = $modelPost::where('po_idx', $po_idx)->update(['po_order' => $po_idx, 'po_moddate' => $post->po_moddate]);
//      $modelPost->dd();

        $request->session()->flash('message', '등록되었습니다.');
        $request->session()->flash('url', 'close');
        return view('flash-message');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\post  $r
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function show(int $id = null)
    {
        // HTTP 응답이 가능한 코드만 message 기능 사용 가능
        // 라우트 정책에따라 게시물번호가 없는 uri 는 (http://lte.c/posts) 목록으로 이동하므로 abort 정책이 필요 없음
//        abort_if(empty($id), ResponseAlias::HTTP_FORBIDDEN, '조회할 게시물 번호 없음');
        return redirect()->away($this->viewUrl . $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\post  $r
     * @return \Illuminate\Http\Response
     */
    public function edit(post $r)
    {
        /*
        {{--
        po_icon 값이 있고 파일이 존재하면 저장된 이미지 표시 그렇지않으면 no_image 표시
po_icon 값이 있고 micon1.png 와 이름이 같다면 전체(고정) 선택 그렇지않으면 임의 선택
            --}}
        */


        return view('post-create');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\post  $r
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, post $r)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\post  $r
     * @return \Illuminate\Http\Response
     */
    public function destroy(post $r)
    {
        //
    }

    /**
     * 외부 이미지 로드시 url 이 없는 경우 엑박 현상 방지
     * @param $content // 본문
     * @param $externalDomain // 외부 url
     * @return mixed        // 이미지 url 이 수정된 본문
     */
    private function convertImg($content, $externalDomain, $externalPath)
    {
        /**
         * 한글 깨짐 해결
         */
        $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');

        /**
         * loadHtml 메소드 오류 해결
         * Unexpected end tag : p in Entity
         *
         * 또는 @$dom->loadHtml 방법도 가능
         *
         * LIBXML_HTML_NOIMPLIED : html, body 태그를 자동으로 추가하지 않음
         * LIBXML_HTML_NODEFDTD : doctype 태그를 자동으로 추가하지 않음
         */
        libxml_use_internal_errors(true);
        $dom = new DomDocument();       // composer.json -> "require": {"ext-dom": "*"} 추가 필요
        $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $imageFile = $dom->getElementsByTagName('img');
//        $appUrl = 'http://bhc1909dev.morningletters.kr';        // URL::to('/')

        foreach ($imageFile as $item => $image) {
            $data = $image->getAttribute('src');

            // 외부 이미지 경로에 도메인이 없어서 이미지가 깨지는 경우 도메인을 붙여준다.
            if (strpos($data, $externalPath) !== false && strpos($data, $externalDomain) === false) {
                $imgLink = $externalDomain . $data;
                $image->removeAttribute('src');
                $image->setAttribute('src', $imgLink);
            }
        }

        return $dom->saveHTML();
    }

    private function saveImg($content, $disk)
    {
        // 저장 경로
        $storage = Storage::disk($disk);

        /**
         * loadHtml 메소드 오류 해결
         * Unexpected end tag : p in Entity
         *
         * 또는 @$dom->loadHtml 방법도 가능
         */
        libxml_use_internal_errors(true);

        /**
         * base64 url 글자 깨짐 해결
         */
        $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');

        $dom = new DomDocument();
        $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $imageFile = $dom->getElementsByTagName('img');

        foreach ($imageFile as $item => $image) {
            $data = $image->getAttribute('src');

            if (strpos($data, 'data:image') !== false) {
                // 업로드 이미지
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);

                $imgData = base64_decode($data);
                $name = date('Ymd_His_') . Str::random() . '.jpg';

//                ddd($type);
//                $image_info = getimagesize($data);
//                $extension = (isset($image_info["mime"]) ? explode('/', $image_info["mime"] )[1]: "");

//                $f = finfo_open();
//                $mime_type = finfo_buffer($f, $imgData, FILEINFO_MIME_TYPE);

                $storage->put($name, $imgData);
                $imgLink = $storage->url($name);

                $image->removeAttribute('src');
                $image->setAttribute('src', $imgLink);

            } elseif (strpos($data, 'http://') !== false || strpos($data, 'https://') !== false) {

                // 링크 이미지
                // 로컬 이미지가 아니라면 저장
                if (strpos($data, URL::to('/')) === false) {
                    $getContents = file_get_contents($data);
                    $encodeContents = mb_convert_encoding($getContents, 'HTML-ENTITIES', 'UTF-8');
                    // 파일명
                    $getName = substr($data, strrpos($data, '/') + 1);

                    // 확장자
                    $extension = pathinfo(parse_url($encodeContents, PHP_URL_PATH), PATHINFO_EXTENSION);
                    if (empty($extension)) $extension = 'jpg';

                    /**
                     * 파일명에 확장자가 없는 경우 확장자 붙임
                     * https://t1.daumcdn.net/cfile/tistory/999A364D5ABB7F1636
                     */
                    if (strpos($getName, '.') !== false) {
                        $arr = explode('.', $getName);
                        if (end($arr) !== $extension) $getName = $getName . '.' . $extension;
                    } else {
                        $getName = $getName . '.' . $extension;
                    }

                    $name = date('Ymd_His_') . $getName;

                    $storage->put($name, $getContents);
                    $imgLink = $storage->url($name);

                    $image->removeAttribute('src');
                    $image->setAttribute('src', $imgLink);
                    $image->setAttribute('data-filename', $getName);
                }

            } else {

                /**
                 * 첨부 이미지가 (base64 이미지) 아니고
                 * 링크 이미지도 아니라면
                 * 로컬 이미지이거나 저장 불가
                 */
                // 파일명
                $getName = pathinfo(parse_url($data, PHP_URL_PATH), PATHINFO_BASENAME);
//                ddd($getName);
//                ddd($storage->exists($getName));

//                ddd($storage->exists($data));
//                ddd(URL::to('/').$data);
//                ddd($storage->exists(URL::to('/').$data));

            }
        }

        return $dom->saveHTML();
    }

    /**
     * 이미지 url 에 로컬 도메인이 없으면 로컬 도메인 연결
     * @param $content
     * @param $disk
     * @return false|string
     */
    private function setLocalUrlImg($content, $disk)
    {
        // 저장 경로
        $storage = Storage::disk($disk);

        /**
         * loadHtml 메소드 오류 해결
         * Unexpected end tag : p in Entity
         *
         * 또는 @$dom->loadHtml 방법도 가능
         */
        libxml_use_internal_errors(true);

        /**
         * base64 url 글자 깨짐 해결
         */
        $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');

        $dom = new DomDocument();
        $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $imageFile = $dom->getElementsByTagName('img');

        foreach ($imageFile as $item => $image) {
            $data = $image->getAttribute('src');
            $name = pathinfo(parse_url($data, PHP_URL_PATH), PATHINFO_BASENAME);

            // 이미지가 존재하고 이미지 url 에 로컬 도메인이 없으면 로컬 도메인 연결
            if ($storage->exists($name) && strpos($data, URL::to('/')) === false) {

                /**
                 * 이미지 추가 저장
                 */
//                $fullName = $storage->getDriver()->getAdapter()->getPathPrefix() . $name;
////                $fullName = storage_path('app/'.$disk).'/'.$name;
//                // 유니크 파일명 자동 생성
////                $saveFileName = Storage::putFile('public', new File($fullName));
//                // 파일명 지정 : 중복된 파일 존재시 덮어씀
//                $saveFileName = Storage::putFileAs('public', new File($fullName), $name);
//                ddd($saveFileName);

                $imgLink = URL::to('/') . $data;
                $image->removeAttribute('src');
                $image->setAttribute('src', $imgLink);
                $image->setAttribute('path', $data);

                /**
                 * 이미지 클릭시 다운로드 가능하도록 a 태그 추가
                 */
                $download = $dom->createElement('a');
//                $download->setAttribute('href', route('teposts.down') . '?file=' . $data);
                $download->setAttribute('href', $data);
                // a 태그에 다운로드 속성 추가
                $download->setAttribute('download', '');
                // 이미지 부모 태그안에 a 태그 추가
                $image->parentNode->insertBefore($download);
                // 이미지 태그를 a 태그의 자식 노드로 이동
                $download->appendChild($image);
            }
        }

        return $dom->saveHTML();
    }

    private function delImg($content)
    {
        /**
         * loadHtml 메소드 오류 해결
         * Unexpected end tag : p in Entity
         *
         * 또는 @$dom->loadHtml 방법도 가능
         */
        libxml_use_internal_errors(true);

        /**
         * base64 url 글자 깨짐 해결
         */
        $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');

        $dom = new DomDocument();
        $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $imageFile = $dom->getElementsByTagName('img');

        foreach ($imageFile as $item => $image) {
            $data = $image->getAttribute('src');
            $name = pathinfo(parse_url($data, PHP_URL_PATH), PATHINFO_BASENAME);    // testimg.jpg
            $path = pathinfo(parse_url($data, PHP_URL_PATH), PATHINFO_DIRNAME);     // /editor
            if (substr($path, 0, 1) === '/') $path = substr($path, 1);
            // 저장 경로
            $storage = Storage::disk($path);
            if ($storage->exists($name)) $storage->delete($name);
        }
    }

}
