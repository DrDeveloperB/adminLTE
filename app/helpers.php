<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

if (!function_exists('getSqlWithBindings')) {
    /**
     * full query in binding
     * @param $query : prepare query
     * @return array : binding data
     */
    function getSqlWithBindings($query)
    {
        foreach ($query as $k => $v) {
            $query[$k]['bindingQuery'] = vsprintf(
                str_replace('?', '%s', $v['query']),    // $query->toSql() , $query['query']
                collect($v['bindings'])      // $query->getBindings() , $query['bindings']
                ->map(
                    function ($binding) {
                        return is_numeric($binding) ? $binding : "'{$binding}'";
                    }
                )
                    ->toArray()
            );
        }
        return $query;
    }
}

if (!function_exists('fnPermissionMenu')) {
    /**
     * 메뉴 권한 추출
     * @param array $aPermissionMenu : 메뉴 권한 코드 리스트
     * @param $oCode : 통합권한에서 전달받은 메뉴 권한 객체
     * @return array
     */
    function fnPermissionMenu(array $aPermissionMenu, $oCode)
    {
        $aCode = (array) $oCode;
        if (count($aCode) > 0) {
            foreach ($aCode as $nKey => $oVal) {
                $aVal = (array) $oVal;
                if (isset($aVal['code']) && !empty($aVal['code'])) {
                    array_push($aPermissionMenu, $aVal['code']);
                }

                $aSub = isset($aVal['sub']) ? (array) $aVal['sub'] : array();
                if (count($aSub) > 0) {
                    $aPermissionMenu = fnPermissionMenu($aPermissionMenu, $aSub);
                }
            }
        }

        return $aPermissionMenu;
    }
}

if (!function_exists('getMainMenu')) {
    /**
     * 메인 메뉴 추출
     * @param string $mainCode : 메인 메뉴 코드
     * @return array
     */
    function getMainMenu(string $mainCode) :array
    {
        $menu = config('app.defaultMenu');

        // empty array || searched array
        $mainMenu = array_filter($menu, function ($v) use($mainCode) {
            // 선택된 대메뉴만 추출
            return $v['code'] === $mainCode;
        });

        // null || one value
        $mainMenu = array_shift($mainMenu);
        return is_array($mainMenu) && count($mainMenu) > 0 ? $mainMenu : array();
    }
}

if (!function_exists('getSubMenu')) {
    /**
     * 서브 메뉴 추출
     * @param string $mainCode : 메인 메뉴 코드
     * @param string $subCode : 서브 메뉴 코드
     * @return array
     */
    function getSubMenu(string $mainCode, string $subCode) :array
    {
        $mainMenu = getMainMenu($mainCode);

        $subMenu = array();
        if (isset($mainMenu['sub'])) {
            $subMenu = array_filter($mainMenu['sub'], function ($v) use($subCode) {
                // 선택된 서브메뉴만 추출
                return $v['code'] == $subCode;
            });
            // null || one value
            $subMenu = array_shift($subMenu) ?? array();
        }

        return $subMenu;
    }
}

if (!function_exists('getPostCategory')) {
    /**
     * 포스팅 메뉴 카테고리 목록 추출
     * @return array
     */
    function getPostCategory() :array
    {
        $mainMenu = getMainMenu('posts');

        return $mainMenu['sub'] ?? array();
    }
}

if (!function_exists('saveFile')) {
    function saveFile(object $request, string $key, string $disk) :array
    {
        $result = config('app.resultDefault');
        $result['argument'] = array('request' => $request, 'key' => $key, 'disk' => $disk,);
//        $result['files'] = array();

//        $i = 0;
//        $errCnt = 0;
        if ($request->hasFile($key)) {
            $fileInfo = $request->file($key);
            $fileName = $fileInfo->getClientOriginalName();
            $newFileName = date('Ymd_His_') . $fileName;
            $result['fileInfo'] = $fileInfo;
//            $result['files'][$i]['fileInfo'] = $fileInfo;

            try {
                Storage::disk($disk)->put($newFileName, file_get_contents($fileInfo));
                $result['result'] = 'success';
                $result['fileName'] = $newFileName;
//                $result['files'][$i]['result'] = 'success';
//                $result['files'][$i]['fileName'] = $newFileName;

            } catch (Throwable $e) {
//                report($e);
//                return false;

//                $errCnt++;
//                $result['files'][$i]['exception'] = $e;
                $result['exception'] = $e;
            }
//            } catch (Exception $e) {
//                $result['files'][$i]['exception'] = $e;
//            }

//            $po_icon = Storage::disk('post-banner')->url($fileName_po_icon);
        }

//        if ($errCnt === 0) {
//            $result['result'] = 'success';
//        }

        return $result;
    }
}

if (!function_exists('saveFiles')) {
    function saveFiles(object $request, array $keys): array
    {
        $result = config('app.resultDefault');
        $result['argument'] = array('request' => $request, 'keys' => $keys,);
        $result['files'] = array();

        foreach ($keys as $k => $v) {
            $result['files'][$k] = saveFile($request, $v['key'], $v['disk']);
        }

        $result['result'] = 'success';

        return $result;
    }
}

if (!function_exists('saveContentImg')) {
    function saveContentImg(string $content, string $disk) :string
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

    if (!function_exists('str_starts_with')) {
        function str_starts_with($str, $start) {
            return (@substr_compare($str, $start, 0, strlen($start))==0);
        }
    }

    if (!function_exists('findPHPDefine')) {
        /**
         * PHP 상수 찾기
         * @param string $word
         * @param bool $flip
         * @return array
         */
        function findPHPDefine(string $word, bool $flip) :array
        {
            $searchWord = array(
                'curl' => array('CURLOPT'),
            );

            $searchKey = '';
            foreach ($searchWord as $k => $v) {
                if (in_array($word, $v)) {
                    $searchKey = $k;
                    break;
                }
            }
            if (empty($searchKey)) return array();

            $defineContents = get_defined_constants(true);
            $searchDefine = $defineContents[$searchKey];
            $filterDefine = array_filter($searchDefine, function($k) use ($word) {
                return str_starts_with($k, $word);
            }, ARRAY_FILTER_USE_KEY);

            if ($flip) $filterDefine = array_flip($filterDefine);
            return $filterDefine;
        }
    }

    if (!function_exists('callCurl')) {
        /**
         * curl 전송
         * @param string $url
         * @param array $opt
         * @return array
         */
        function callCurl(string $url, array $opt) :array
        {
            // Open connection
            $ch = curl_init();

            // Set the url, number of POST vars, POST data
            $options = array(
                CURLOPT_URL => $url,        // 10002
                CURLOPT_RETURNTRANSFER => $opt['CURLOPT_RETURNTRANSFER'] ?? true,         // (19913 true) REQUEST 타입 설정 : true (curl_exec 함수로 리턴), false (direct view)
                CURLOPT_POST => $opt['CURLOPT_POST'] ?? false,                            // (47 true) 전송 메소드 설정 : true (POST), false (GET)
                CURLOPT_SSL_VERIFYPEER => $opt['CURLOPT_SSL_VERIFYPEER'] ?? false,        // (64 false) 원격지 인증서 유효성 검사
                CURLOPT_CONNECTTIMEOUT => $opt['CURLOPT_CONNECTTIMEOUT'] ?? 10,           // (78) 연결 대기 시간 (초) : 0 무제한
                CURLOPT_TIMEOUT => $opt['CURLOPT_TIMEOUT'] ?? 10,                         // (13) 응답 대기 시간 (초)
                CURLOPT_HTTPHEADER => $opt['CURLOPT_HTTPHEADER'] ?? array(),              // (10023) 헤더 정보 (array('Accept: */*', 'Content-Type: application/json'))
                //                CURLOPT_POSTFIELDS => $opt['CURLOPT_POSTFIELDS'] ?? '[]',                   // (10015) POST data (array to json_encode)
                CURLOPT_HEADER => $opt['CURLOPT_HEADER'] ?? false,                      // (42 false) 응답에 헤더 정보 포함 여부
                CURLOPT_NOBODY => $opt['CURLOPT_NOBODY'] ?? false,                      // (44 false) 응답에서 바디 부분 제외 여부
                CURLOPT_FAILONERROR => $opt['CURLOPT_FAILONERROR'] ?? true,             // (45 true) HTTP 응답이 400 이상일 때 응답 내용을 가져오지 않고 실패로 취급
                CURLOPT_FOLLOWLOCATION => $opt['CURLOPT_FOLLOWLOCATION'] ?? true,      // (52 true) 서버에서 Location: 헤더를 응답했을때 재요청 여부
                CURLOPT_MAXREDIRS => $opt['CURLOPT_MAXREDIRS'] ?? 20,      // (68 20회) 서버에서 Location: 헤더를 응답했을때 (redirections) 재요청 (추적) 횟수 : 무제한 -1, 0 재요청 안함
                CURLOPT_USERAGENT => $opt['CURLOPT_USERAGENT'] ?? '',      // 10018 정상적인 브라우저의 요청에만 응답하는 url 의 경우 user agent 프로필 필요
                // user agent 예시 : "Mozilla/5.0 (Windows NT 6.0) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1"
            );
            /**
             * 10015 POST data (array to json_encode)
             * 배열을 전달하면 CURLOPT_POSTFIELDS데이터가 multipart/form-data 로 인코딩되고 URL 인코딩 문자열을 전달하면 데이터가 application/x-www-form-urlencoded 로 인코딩 됩니다.
             * 한글, 특수문자 인코딩
             * http_build_query($opt['CURLOPT_POSTFIELDS'])
             * json_encode($opt['CURLOPT_POSTFIELDS'])
             */
            if ($options[CURLOPT_POST] && !empty($opt['CURLOPT_POSTFIELDS'])) {
                $options[CURLOPT_POSTFIELDS] = is_array($opt['CURLOPT_POSTFIELDS']) ? json_encode($opt['CURLOPT_POSTFIELDS']) : $opt['CURLOPT_POSTFIELDS'];
            }
            /**
             * 파일 다운로드일때 해당 데이터를 작성할 파일 지정
             */
            if (isset($opt['CURLOPT_FILE']) && !empty($opt['CURLOPT_FILE'])) {
                $options[CURLOPT_FILE] = $opt['CURLOPT_FILE'];
            }
            curl_setopt_array($ch, $options);

            // Execute post
            $sResult = curl_exec($ch);       // 결과 (response body)
            $aResult_Status = curl_getinfo($ch);    // 모든 상태 정보
            $nResult_ErrNo = curl_errno($ch);       // 오류 코드
            $sResult_ErrMsg = curl_error($ch);       // 오류 메세지

            // Close connection
            curl_close($ch);

            // 옵션 키값 문자로 변환
            $findDefine = findPHPDefine('CURLOPT', true);
            $optionsDefine = array();
            foreach ($options as $k => $v) {
                $optionsDefine[$findDefine[$k]] = $v;
            }
            // 응답
            $aCurlResult = array(
                'ErrNo' => $nResult_ErrNo ?? 0,
                'ErrMsg' => $sResult_ErrMsg ?? '',
                'Result' => $sResult,
                //                'Result' => $sResult === false ? false : json_decode($sResult, true),
                'Status' => $aResult_Status ?? array(),
                'Options' => $optionsDefine,
            );

            return $aCurlResult;
        }
    }

    if (!function_exists('chkUrl')) {
        /**
         * url 확인
         * @param string $url
         * @return bool
         */
        function chkUrl(string $url) :bool
        {
            $opt = array(
                'CURLOPT_CONNECTTIMEOUT' => 100,
                'CURLOPT_TIMEOUT' => 100,
                'CURLOPT_NOBODY' => true,
            );
            $result = callCurl($url, $opt);

            if (empty($result['ErrNo']) && $result['Status']['http_code'] === 200) {
                return true;
            }

            return false;
        }
    }

}

