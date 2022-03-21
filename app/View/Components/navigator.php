<?php

namespace App\View\Components;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\View\Component;

class navigator extends Component
{

    // 메뉴
    public $defaultMenu = array();
    public $subMenuCode = '';
    public $mainMenuCode = '';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
//        $application = Application::getInstance();
//        ddd($application->isLocal());
//        ddd(app()->isLocal());

        // 모든 url scheme 에 ssl 적용
        if (app()->isProduction()) {
            URL::forceScheme('https');
        }

        $this->defaultMenu = config('app.defaultMenu');
        $this->subMenuCode = (string) $request->subMenuCode;
        $this->mainMenuCode = $request->segment(1);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $accessMenu = $this->defaultMenu;
        foreach($accessMenu as $k => &$mainMenu) {
            $mainMenu['mainClass'] = $mainMenu['code'] === $this->mainMenuCode ? 'bg-info' : '';

            if (isset($mainMenu['sub'])) {
                foreach($mainMenu['sub'] as $k2 => &$subMenu) {
                    $subMenu['subClass'] = $mainMenu['code'] === $this->mainMenuCode && $subMenu['code'] === $this->subMenuCode ? 'bg-success' : '';
                }
            }
        }
        unset($mainMenu, $subMenu);

        $data = array(
//            'defaultMenu' => $this->defaultMenu,
            'accessMenu' => $accessMenu,
        );
        return view('components.navigator', $data);
    }

//    public function formatAlert($message)
//    {
//        return strtoupper($message);
//    }
}
