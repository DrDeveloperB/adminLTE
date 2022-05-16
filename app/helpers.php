<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

$resultDefault = array('result' => 'fail', 'mainCode' => '9999', 'subCode' => '9999', 'message' => 'fail',
    'argument' => array(),
);

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
        global $resultDefault;

        $result = $resultDefault;
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
        global $resultDefault;

        $result = $resultDefault;
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
}

