<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Mixed_;

class Post extends Model
{
    use HasFactory;

    /**
     * 접속 디비
     * @var string
     */
    protected $connection = 'morningletters';
    /**
     * 사용 테이블
     * @var string
     */
    protected $table = 'po_list';
    /**
     * 테이블 기본키
     * @var string
     */
    protected $primaryKey = 'po_idx';
    /**
     * insert, update 시 등록일, 수정일 컬럼에 자동으로 현재 시간 입력
     */
//    public $timestamps  = false;
    const CREATED_AT = 'po_regdate';        // 데이터 생성일시 컬럼 지정
    const UPDATED_AT = 'po_moddate';        // 데이터 수정일시 컬럼 지정

    // 입력 허용할 데이터 필드
    protected $fillable = [
        'po_cate',      // 카테고리
        'po_title',     // 제목
        'po_date',      // 글 게시 일시
        'po_content',   // 본문
        'po_image',     // 썸네일
        'po_regdate',   // 작성 일시
        'po_moddate',   // 수정 일시
        'po_icon',          // 아이콘 배너
        'po_icon_use',      // 아이콘 배너 사용 여부
        'po_icon_url',      // 아이콘 배너 링크
        'po_like',      // 좋아요
        'po_comment',   // 댓글
        'po_share',     // 공유
        'po_read',      // 뷰 카운트
        'po_order',     // 순위
//        'po_state',
//        'po_status',
    ];

    // Observers & Database Transactions
    public $afterCommit = true;

    /**
     * Set the value of the "updated at" attribute.
     *
     * @param  mixed  $value
     * @return void
     */
//    public function setUpdatedAt(string $value)
//    {
//        $this->{static::UPDATED_AT} = $value;
//    }
//    public function setUpdatedAtAttribute($value) {
//        $this->attributes['updated_at'] = $value;
//    }

//    public static function all($columns = ['*'])
//    {
//        return static::query()->get(
//            is_array($columns) ? $columns : func_get_args()
//        );
//    }
    /**
     * 게시물 목록 추출
     * @param string $cateCode : 카테고리 코드
     * @return object
     */
    public static function list(string $cateCode, array $where) :object
    {
        $po_title = $where['po_title'] ?? '';
//        $po_content = $po_title . ' 6';
//        $po_content = '';
//        $po_title = '';

        return static::select(
            'po_idx', 'po_cate', 'po_title', 'po_image', 'po_date', 'po_like', 'po_comment', 'po_share', 'po_read', 'po_icon_use', 'po_icon', 'po_icon_url'
        )
            ->where('po_status', 0)
            ->when($cateCode, function ($query, $cateCode) {
                return $query->where('po_cate', $cateCode);
            })
            // 검색 : grid 기능으로 대체 불가 (내용 검색 안됨)
            ->when($po_title, function ($query, $po_title) {
                // 하위 조건절을 소괄호로 묶음
                $query->where(function($query) use ($po_title) {
                    $query->where('po_title', 'like', '%'. $po_title .'%')
                        ->orWhere('po_content', 'like', '%'. $po_title .'%');
                });
            })

//            ->when($po_title, function ($query, $po_title) {
//                return $query->where('po_title', 'like', '%'. $po_title .'%');
//            })
//            ->where(function($query) use ($po_title) {
//                $query->where('po_title', 'like', '%'. $po_title .'%')
//                    ->orWhere('po_content', 'like', '%'. $po_title .'%');
//            })

//                // 소괄호로 묶으면서 when 메소드에 여러개의 파라미터 사용하기
//                // 리턴되는 쿼리가 없으면 해당 조건절은 생성되지 않음 ($po_title, $po_content 가 모두 빈 값인 경우)
//            ->where(function($query) use ($po_title, $po_content) {
//                $query->when($po_title, function ($query, $po_title) {
//                    $query->where('po_title', 'like', '%'. $po_title .'%');
//                });
//                $query->when($po_content, function ($query, $po_content) {
//                    $query->where('po_content', 'like', '%'. $po_content .'%');
//                });
//            })

            ->orderBy('po_date', 'desc')
            ->get();
    }

    /**
     * 게시물 썸네일 추출
     * @return string
     */
    public function getThumbnailAttribute() :string
    {
        $storage = Storage::disk('thumb');
        if (!empty($this->po_image)) {
            if ($storage->exists($this->po_image)) {
                return $storage->url($this->po_image);
            } else {
//            return config('app.request_scheme') . '://'. $_SERVER['HTTP_HOST'] .'/data/image/thumb/' . $this->po_image;
//            return 'http://bhc1909dev.morningletters.kr/data/image/thumb/' . $this->po_image;
                return sprintf('%s%s%s', config('app.image_url'), config('app.storage_old.img_po_thumb'), $this->po_image);
            }
        }

        return '';
    }

    /**
     * 게시물 카테고리 추출
     * @return string
     */
    public function getCategoryNameAttribute() :string
    {
        $subMenu = getSubMenu('posts', $this->po_cate);
        return $subMenu['name'] ?? '';
    }

    /**
     * 게시물 이동 아이콘 정보
     * @return string[]
     */
    public function getBannerIconInfoAttribute() :array
    {
        // 저장 경로
        $storage = Storage::disk('post-banner');

        // 반환 배열
        $bannerIconInfo = array(
            'bannerIcon' => '',
            'bannerText1' => '감춤',
            'bannerText2' => '',
        );

        // po_icon_use = 1 : 이동 아이콘 보임
        if ($this->po_icon_use === 1) {
            // 이동 아이콘 이미지가 있으면 해당 이미지 표시
            if (!empty($this->po_icon)) {
                if ($storage->exists($this->po_icon)) {
                    $bannerIconInfo['bannerIcon'] = $storage->url($this->po_icon);
                } else {
                    $bannerIconInfo['bannerIcon'] = sprintf('%s%s%s', config('app.image_url'), config('app.storage_old.img_po'), $this->po_icon);
                }
            }

            $bannerIconInfo['bannerText1'] = '보임';

            // 이동 아이콘 주소가 url 이라면
            if (!empty($this->po_icon_url) && strpos($this->po_icon_url, 'http') !== false) {
                $bannerIconInfo['bannerText2'] = 'url';
            } else {
                $bannerIconInfo['bannerText2'] = '게시물';
            }
        }

        return $bannerIconInfo;
    }




    public function getBannerIconAttribute() :array
    {
        $bannerIcon = 'icon_fix';

        // 저장 경로
        $storage = Storage::disk('post-banner');

        /*
        {{--
        po_icon 값이 있고 파일이 존재하면 저장된 이미지 표시 그렇지않으면 no_image 표시
po_icon 값이 있고 micon1.png 와 이름이 같다면 전체(고정) 선택 그렇지않으면 임의 선택
            --}}
        */

        if (!empty($this->po_icon) && $storage->exists($this->po_icon)) {




            $bannerIconUrl = sprintf('%s%s%s', config('app.image_url'), config('app.storage_old.img_po'), $this->po_icon);
//                $bannerIcons['bannerIcon'] = sprintf('<img src="%s" style="width: 100%;">', $bannerIconUrl);
            $bannerIcons['bannerIcon'] = $bannerIconUrl;
        }

        if ($this->po_icon_use === 1) {
            if (!empty($this->po_icon)) {
                $bannerIconUrl = sprintf('%s%s%s', config('app.image_url'), config('app.storage_old.img_po'), $this->po_icon);
//                $bannerIcons['bannerIcon'] = sprintf('<img src="%s" style="width: 100%;">', $bannerIconUrl);
                $bannerIcons['bannerIcon'] = $bannerIconUrl;
            }

            $bannerIcons['bannerText1'] = '보임';

            if (!empty($this->po_icon_url) && strpos($this->po_icon_url, 'http') !== false) {
                $bannerIcons['bannerText2'] = 'url';
            } else {
                $bannerIcons['bannerText2'] = '게시물';
            }
        }

        return $bannerIcons;
    }

//    public function getBannerIconTypeAttribute() :array
//    {
//        $bannerIconType = 'icon_fix';
//
//        // 저장 경로
//        $storage = Storage::disk('icon');
//        /*
//        {{--
//        po_icon 값이 있고 파일이 존재하면 저장된 이미지 표시 그렇지않으면 no_image 표시
//po_icon 값이 있고 micon1.png 와 이름이 같다면 전체(고정) 선택 그렇지않으면 임의 선택
//            --}}
//        */
//
//        if (!empty($this->po_icon) && $storage->exists($this->po_icon)) {
//
//
//
//
//            $bannerIconUrl = sprintf('%s%s%s', config('app.image_url'), config('app.storage_old.img_po'), $this->po_icon);
////                $bannerIcons['bannerIcon'] = sprintf('<img src="%s" style="width: 100%;">', $bannerIconUrl);
//            $bannerIcons['bannerIcon'] = $bannerIconUrl;
//        }
//
//        if ($this->po_icon_use === 1) {
//            if (!empty($this->po_icon)) {
//                $bannerIconUrl = sprintf('%s%s%s', config('app.image_url'), config('app.storage_old.img_po'), $this->po_icon);
////                $bannerIcons['bannerIcon'] = sprintf('<img src="%s" style="width: 100%;">', $bannerIconUrl);
//                $bannerIcons['bannerIcon'] = $bannerIconUrl;
//            }
//
//            $bannerIcons['bannerText1'] = '보임';
//
//            if (!empty($this->po_icon_url) && strpos($this->po_icon_url, 'http') !== false) {
//                $bannerIcons['bannerText2'] = 'url';
//            } else {
//                $bannerIcons['bannerText2'] = '게시물';
//            }
//        }
//
//        return $bannerIcons;
//    }

}
