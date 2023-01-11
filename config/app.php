<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),
    'admin_url' => env('ADMIN_URL', 'http://localhost'),
    'api_url' => env('API_URL', 'http://localhost'),
    'image_url' => env('IMAGE_URL', 'http://localhost'),
    'login_url' => env('LOGIN_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL', null),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'Asia/Seoul',        // UTC      Asia/Seoul

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'ko',       // en   ko

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

    'faker_locale' => 'ko_KR',      // en_US    ko_KR

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Arr' => Illuminate\Support\Arr::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'Date' => Illuminate\Support\Facades\Date::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Http' => Illuminate\Support\Facades\Http::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'RateLimiter' => Illuminate\Support\Facades\RateLimiter::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        // 'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'Str' => Illuminate\Support\Str::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,

    ],

    'request_scheme' => isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] === 443 ? 'https' : 'http',     // $_SERVER['REQUEST_SCHEME']
    'banner_post_view' => '{{_BANNER_}}',           // 포스트 상세 띠배너 코드

    'defaultMenu' => [
        [
            'code' => 'posts',
            'name' => '포스팅',
            'sub' => [
                [
                    'code' => '',
                    'name' => '전체',
                ],
                [
                    'code' => '10',
                    'name' => '감동',
                ],
                [
                    'code' => '20',
                    'name' => '좋은 글',
                ],
                [
                    'code' => '25',
                    'name' => '짧고 좋은 글',
                ],
                [
                    'code' => '30',
                    'name' => '유명인',
                ],
                [
                    'code' => '40',
                    'name' => '나만 몰랐던 이야기',
                ],
                [
                    'code' => '50',
                    'name' => '명화',
                ],
            ]
        ],
        [
            'code' => 'comments',
            'name' => '댓글',
            'sub' => [
                [
                    'code' => '',
                    'name' => '전체',
                ],
                [
                    'code' => '1',
                    'name' => '일반',
                ],
                [
                    'code' => '2',
                    'name' => '숨김',
                ],
                [
                    'code' => '3',
                    'name' => '삭제',
                ],
                [
                    'code' => '4',
                    'name' => '차단',
                ],
            ]
        ],
        [
            'code' => 'notice',
            'name' => '공지사항',
        ],
        [
            'code' => 'qna',
            'name' => '고객센터',
        ],
        [
            'code' => 'visit_hour',
            'name' => '시간별',
        ],
        [
            'code' => 'visit_day',
            'name' => '일별',
        ],
        [
            'code' => 'visit_month',
            'name' => '월별',
        ],
        [
            'code' => 'push_set',
            'name' => '푸시 설정',
        ],
        [
            'code' => 'push_log',
            'name' => '푸시 결과',
        ],
        [
            'code' => 'member',
            'name' => '회원',
            'sub' => [
                [
                    'code' => 'member_list',
                    'name' => '회원 관리',
                ],
                [
                    'code' => 'member_withdraw',
                    'name' => '탈퇴 회원 관리',
                ],
            ]
        ],
        [
            'code' => 'intro',
            'name' => '인트로 설정',
        ],
        [
            'code' => 'setting',
            'name' => '설정',
        ],
        [
            'code' => 'banner',
            'name' => '배너 관리',
            'sub' => [
                [
                    'code' => 'banner_end',
                    'name' => '종료 배너 관리',
                ],
                [
                    'code' => 'banner_end_manager',
                    'name' => '종료 배너 (기본 / 예약 관리)',
                ],
                [
                    'code' => 'banner_main',
                    'name' => '띠배너 관리 (홈메인)',
                ],
                [
                    'code' => 'banner_view',
                    'name' => '띠배너 관리 (상세)',
                ],
            ]
        ],
    ],

    /**
     * 아침편지 구버전 파일 경로
     */
    'storage_old' => [
        'img_po' => '/data/image/',                         // 기타 이미지 경로 : 게시물 이동아이콘
        'img_po_thumb' => '/data/image/thumb/',             // 게시물 이미지 썸네일 경로
        'img_editor' => '/data/editor/',                    // 네이버 스마트 에디터 이미지 경로
        'img_banner' => '/data/banner/',                    // 배너 이미지 경로
        'img_push' => '/data/noti/',                        // 푸시 이미지 경로
        'img_profile' => '/data/profile/',                  // 프로필 이미지 경로
        'img_profile_thumb' => '/data/profile/thumb/',      // 프로필 이미지 썸네일 경로
        'img_cmt' => '/data/cmt/',                          // 관리자 댓글 이미지 경로
    ],

    'resultDefault' => [
        'result' => 'fail', 'mainCode' => '9999', 'subCode' => '9999', 'message' => 'fail',
        'argument' => [],
    ],
];
