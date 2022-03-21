<?php

namespace App\Http\Controllers;

use App\Models\Po_list;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class TestController extends Controller
{

    public function index()
    {
//        $db = Po_list::class;
//        $db = new Po_list;
//        $db->setConnection('mysql');
//        ddd($db);

        // 아침편지 DB 조회
        $posts = Po_list::select(
            'po_idx', 'po_cate', 'po_title', 'po_image', 'po_date', 'po_icon_use', 'po_like', 'po_comment', 'po_share', 'po_read'
        )
//            ->where('po_idx', 0)
            ->orderBy('po_idx', 'desc')
//            ->latest()
//            ->limit(5)
            ->get();
//            ->paginate(3);
//            ->first();

//        $posts = (new Po_list())->on('morningletters')->get();
//        ddd($posts);

//        if (!empty($posts)) {
//            foreach ($posts as $k => &$post_v) {
////        ddd($post[0]->body);
//                if (!empty($post_v->body)) {
//                    // 외부 이미지 깨짐 방지
//                    $post_v->body = $this->convertImg($post_v->body, 'http://bhc1909dev.morningletters.kr', '/data/editor/');
//                    // 로컬 이미지 url 에 로컬 도메인 연결
//                    $post_v->body = $this->setLocalUrlImg($post_v->body, 'editor');
//                }
//            }
//        }
//        unset($post_v);

//        Log::channel('log_test2')->info('context log test', ['context' => 'context 1', 'posts' => $posts]);

        $data = array(
            'posts' => $posts,
            'postsCnt' => count($posts),
        );

        return view('test.test', $data);
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
//                $download->setAttribute('href', route('posts.down') . '?file=' . $data);
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

}
