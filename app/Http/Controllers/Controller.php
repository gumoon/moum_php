<?php

namespace moum\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //商户分类
    public $shopCats = array(
        '外卖',
        '美食',
    );

    //商户分类子分类
    /**
     * 炸鸡    치킨.피자 = 0
     * 快餐   한식.분식 = 1
     * 炸猪排  돈까스.일식.회 = 2
     * 盒饭   도시락.중식.죽 = 3
     * 猪蹄   족발.보쌈 = 4
     * 烧烤.羊肉串 꼬치.구이 = 5
     * 特色料理 특색요리 = 6
     * 全部  전체업소 = 99
     * @var array
     */
    public $shopTypes = array(
        array(
            '치킨.피자',
            '한식.분식',
            '돈까스.일식.회',
            '도시락.중식.죽',
            '족발.보쌈',
            '꼬치.구이',
            '특색요리',
        ),//跟分类顺序对应上，此为外卖的子分类
    );

    //房型
    public $houseTypes = array(
        array(
            'id' => 0,
            'name' => '一室'
        ),
        array(
            'id' => 1,
            'name' => '二室'
        ),
        array(
            'id' => 2,
            'name' => '三室'
        ),
        array(
            'id' => 3,
            'name' => '四室'
        )
    );

    //黄页分类
    public $one14Categories = array(
        array(
            'id' => 6,
            'name' => '맛집',
            'types' => array(
                array(
                    'id' => 61,
                    'name' => '한식'
                ),
                array(
                    'id' => 62,
                    'name' => '일식'
                ),
                array(
                    'id' => 63,
                    'name' => '평양요리'
                ),
                array(
                    'id' => 64,
                    'name' => '연변요리'
                ),
                array(
                    'id' => 65,
                    'name' => '분식.도시락'
                ),
                array(
                    'id' => 66,
                    'name' => '치킨'
                ),
                array(
                    'id' => 67,
                    'name' => '떡집.피자'
                )
            )
        ),
        array(
            'id' => 7,
            'name' => '제과.식품',
            'types' => array(
                array(
                    'id' => 71,
                    'name' => '제과점'
                ),
                array(
                    'id' => 72,
                    'name' => '슈퍼마켓'
                ),
                array(
                    'id' => 73,
                    'name' => '생수배달.정수기'
                ),
                array(
                    'id' => 74,
                    'name' => '김치.쌀.정육'
                ),
                array(
                    'id' => 75,
                    'name' => '건강식품'
                )
            )
        ),
        array(
            'id' => 8,
            'name' => '휴식',
            'types' => array(
                array(
                    'id' => 81,
                    'name' => '커피숍'
                ),
                array(
                    'id' => 82,
                    'name' => 'KTV'
                ),
                array(
                    'id' => 83,
                    'name' => 'BAR'
                ),
                array(
                    'id' => 84,
                    'name' => '사우나'
                ),
                array(
                    'id' => 85,
                    'name' => '마사지'
                ),
                array(
                    'id' => 86,
                    'name' => '영화관'
                ),
                array(
                    'id' => 87,
                    'name' => '당구장'
                ),
                array(
                    'id' => 88,
                    'name' => '온천사우나'
                )
            )
        ),
        array(
            'id' => 1,
            'name' => '주숙.여행',
            'types' => array(
                array(
                    'id' => 10,
                    'name' => '자동차판매'
                ),
                array(
                    'id' => 11,
                    'name' => '부동산'
                ),
                array(
                    'id' => 12,
                    'name' => '호텔'
                ), 
                array(
                    'id' => 13,
                    'name' => '민박'
                ),
                array(
                    'id' => 14,
                    'name' => '항공사'
                ), 
                array(
                    'id' => 15,
                    'name' => '여행사.티켓'
                )                                                         
            )
        ),
        array(
            'id' => 3,
            'name' => '라이프스타일',
            'types' => array(
                array(
                    'id' => 31,
                    'name' => '통신.IT컴퓨터'
                ),
                array(
                    'id' => 32,
                    'name' => '안경'
                ),
                array(
                    'id' => 33,
                    'name' => '꽃집'
                ),
                array(
                    'id' => 34,
                    'name' => '디자인.인쇄.판촉물'
                ),
                array(
                    'id' => 35,
                    'name' => '세탁소'
                ),
                array(
                    'id' => 36,
                    'name' => '복장'
                ),
                array(
                    'id' => 37,
                    'name' => '촬영.이벤트'
                ),
                array(
                    'id' => 38,
                    'name' => '번역'
                )
            )
        ),
        array(
            'id' => 2,
            'name' => '병원.치과.안과',
            'types' => array(
                array(
                    'id' => 21,
                    'name' => '병원'
                ),
                array(
                    'id' => 22,
                    'name' => '치과'
                ),
                array(
                    'id' => 23,
                    'name' => '안과'
                ),
                array(
                    'id' => 24,
                    'name' => '침구'
                )
            )
        ),
        array(
            'id' => 4,
            'name' => '학교.학원',
            'types' => array(
                array(
                    'id' => 41,
                    'name' => '음악.댄스학원'
                ),
                array(
                    'id' => 42,
                    'name' => '미술학원'
                ),
                array(
                    'id' => 43,
                    'name' => '유학원'
                ),
                array(
                    'id' => 44,
                    'name' => '초.중.고중학교'
                ),
                array(
                    'id' => 45,
                    'name' => '유치원'
                ),
                array(
                    'id' => 46,
                    'name' => '대학교'
                ),
                array(
                    'id' => 47,
                    'name' => '학습지'
                ),
                array(
                    'id' => 48,
                    'name' => '문구'
                )
            )
        ),
        array(
            'id' => 0,
            'name' => '동호회.법률.물류',
            'types' => array(
                array(
                    'id' => 1,
                    'name' => '한국은행'
                ),
                array(
                    'id' => 2,
                    'name' => '동호회'
                ),
                array(
                    'id' => 3,
                    'name' => '기업.상사'
                ), 
                array(
                    'id' => 4,
                    'name' => '회계.법률'
                ),
                array(
                    'id' => 5,
                    'name' => '자동차판매'
                ),
                array(
                    'id' => 6,
                    'name' => '물류'
                ),
                array(
                    'id' => 7,
                    'name' => '자동차판매'
                )                              
            )
        ),
        array(
            'id' => 5,
            'name' => '한국교민센터.국가기관',
            'types' => array(
                array(
                    'id' => 51,
                    'name' => '긴급전화'
                ),
                array(
                    'id' => 52,
                    'name' => '안내전화'
                ),
                array(
                    'id' => 53,
                    'name' => '정부기관'
                ),
                array(
                    'id' => 54,
                    'name' => '한국교민콜센터'
                ),
                array(
                    'id' => 55,
                    'name' => '한국국가기관'
                )
            )
        )
    );

    //封装成功返回的json
    protected function successJson( $data = null )
    {
    	$ret = array(
    		'err_no' => 0,
    		'msg' => '成功',
    		'data' => $data ? $data : new \stdClass
    	);

    	return response()->json( $ret );
    }

    //封装错误返回的json
    protected function failedJson($msg)
    {
        $ret = array(
            'err_no' => 10010,
            'msg' => trans('errorcode.10010',['param' => $msg]),
            'data' => new \stdClass
        );

        return response()->json( $ret );
    }
}
