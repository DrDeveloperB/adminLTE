<?php

namespace App\Http\Controllers;

use App\Models\test\Post;
use DOMDocument;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\Request as RequestClass;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;

class PostController extends Controller
{
    public function boot()
    {
        Paginator::useBootstrap();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
//        return "test";
//        Log::info('stack test 1');
//        Log::stack(['log_test', 'log_test3'])->emergency('stack test 2');

//        Log::channel('log_test')->emergency('emergency log test');
//        Log::channel('log_test')->alert('alert log test');
//        Log::channel('log_test')->critical('critical log test');
//        Log::channel('log_test')->error('error log test');
//        Log::channel('log_test')->warning('warning log test');
//        Log::channel('log_test')->notice('notice log test');
//        Log::channel('log_test')->info('info log test');
//        Log::channel('log_test')->debug('debug log test');

        // 아침편지 DB 조회
        $db = DB::connection('morningletters');
        $posts = $db->table('po_list')
            ->select('po_idx as id', 'po_title as title', 'po_content as body', 'po_date as created_at')
//            ->where('po_idx', 0)
            ->latest()
//            ->limit(5)->get();
            ->paginate(3);
//            ->first();

//        // 로컬 DB 조회
        $posts = Post::latest()
//            ->limit(5)->get();
            ->paginate(1);
//            ->simplePaginate(1);
//          ->first();

        if (!empty($posts)) {
            foreach ($posts as $k => &$post_v) {
//        ddd($post[0]->body);
                if (!empty($post_v->body)) {
                    // 외부 이미지 깨짐 방지
                    $post_v->body = $this->convertImg($post_v->body, 'http://bhc1909dev.morningletters.kr', '/data/editor/');
                    // 로컬 이미지 url 에 로컬 도메인 연결
                    $post_v->body = $this->setLocalUrlImg($post_v->body, 'editor');
                }
            }
        }
        unset($post_v);

//        Log::channel('log_test2')->info('context log test', ['context' => 'context 1', 'posts' => $posts]);

        return view('test.post-list', ['posts' => $posts]);
        /**
         * 세션 플래시 메세지를 띄우고 다른 페이지로 이동 후 백스페이스 키로 되돌아온 경우
         * 플래시 메세지가 계속 작동하는 현상 방지
         * 원인 : 브라우저 자체에 해당 페이지가 캐시로 저장되어
         * 백스페이스 키로 되돌아오면 해당 캐시 페이지가 로드되면서 기존 플래시 메세지가 계속 노출됨
         * 해결 : 캐시가 사용되지 않도록 설정
         */
//        return response()->view('post-list', ['posts' => $posts])
//            ->withHeaders([
//                'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate',
//                'Pragma' => 'no-cache',
//                'Expires' => 'Sun, 02 Jan 1990 00:00:00 GMT',
//            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('test.post-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        $content = $this->saveImg($request->body, 'editor');

        $post = Post::create([
            'title' => $request->title,
            'body' => $content
        ]);
//        dd($post->toArray()['id']);        // result : DB row data

//        return $this->index();
//        return redirect()->route('teposts.index')->with('message', '등록되었습니다.');
//            ->withHeaders([
//                'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate',
//                'Pragma' => 'no-cache',
//                'Expires' => 'Sun, 02 Jan 1990 00:00:00 GMT',
//            ]);
        /**
         * 세션 플래시 메세지를 띄우고 다른 페이지로 이동 후 백스페이스 키로 되돌아온 경우
         * 플래시 메세지가 계속 작동하는 현상 방지
         * 원인 : 브라우저 자체에 해당 페이지가 캐시로 저장되어
         * 백스페이스 키로 되돌아오면 해당 캐시 페이지가 로드되면서 기존 플래시 메세지가 계속 노출됨
         * 해결 : 이동해야하는 페이지로 이동하기전에 플래시 메세지를 띄우는 전용 페이지로 이동 후 메세지를 노출하고 이동
         */
        $request->session()->flash('message', '등록되었습니다.');
        $request->session()->flash('url', route('teposts.index'));
        return view('flash-message');
//        return view('flash-message')->with('message', '등록되었습니다.');
//        return view('flash-message')->with([
//            'message' => '등록되었습니다.',
//            'url' => route('teposts.index'),
//        ]);

//        $request->session()->flash('message', '등록되었습니다.');
//        return redirect()->route('teposts.index');
//        return response()->view('post-list')
//            ->withHeaders([
//                'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate',
//                'Pragma' => 'no-cache',
//                'Expires' => 'Sun, 02 Jan 1990 00:00:00 GMT',
//            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        return view('test.post-view', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
//        $post = array(
//            'title' => 'title',
//            'body' => 'body'
//        );
//        $request = new RequestClass();
//        $post = $request->replace($post);

//        $prevUrl = URL::previous();      // http://lte.c/posts/10 previous url
//        $prevUrl = url()->previous();      // http://lte.c/posts/10 previous url
//        $prevUrl = $request->header('referer');       // null
//        $prevUrl = $request->server('HTTP_REFERER');       // null
//        $prevUrl = redirect()->getUrlGenerator()->previous();      // http://lte.c/posts/10 previous url
//        $prevUrl = redirect()->back()->getTargetUrl();          // http://lte.c/posts/10 previous url
//        $prevUrl = join('/', request()->segments());        // posts/10/edit
//        ddd($prevUrl);

        return view('test.post-create', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

//        $updateColumn = $request->all();
//        unset($updateColumn['_token'], $updateColumn['_method']);
        $updateColumn = array();
        $updateColumn['title'] = $request->title;
        $updateColumn['body'] = $this->saveImg($request->body, 'editor');

        $result = Post::where('id', $id)->update($updateColumn);
//        ddd($result);        // result : 0, 1

//        return redirect($request->previousUrl)->with('message', '수정되었습니다.');
//        return redirect()->route('teposts.index', ['result', $result]);
        $request->session()->flash('message', '수정되었습니다.');
        $request->session()->flash('url', $request->previousUrl);
        return view('flash-message');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $ids = explode(',', $id);

        // 이미지 삭제
        $posts = Post::select('body')->whereIn('id', $ids)->get();
        foreach ($posts as $post) {
            $this->delImg($post->body);
        }

        // 디비 삭제
        $result = Post::whereIn('id', $ids)->delete();
//        $result = Post::where('id', $id)->delete();
//        ddd($result);        // result : 0, 1

//        return redirect()->route('teposts.index')->with('message', '삭제되었습니다.');
        $request->session()->flash('message', '삭제되었습니다.');
        $request->session()->flash('url', route('teposts.index'));
        return view('flash-message');
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

    public function download(Request $request)
    {
//        ddd($request->file);
        //http://lte.c/posts/down?file=editor/20211025_134542_999A364D5ABB7F1636.jpg
        return Storage::download($request->file, 'downimage.jpg');
//        return Storage::download('editor/20211025_134542_999A364D5ABB7F1636.jpg');
//        return Storage::download('http://lte.c/editor/20211025_134542_999A364D5ABB7F1636.jpg', $name, $headers);
    }
}
