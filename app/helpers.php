<?php

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
