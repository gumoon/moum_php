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
        '外卖'
    );

    //商户分类子分类
    /**
     * 炸鸡    치킨.피자 
     * 快餐   한식.분식
     * 炸猪排  돈까스.일식.회
     * 盒饭   도시락.중식.죽
     * 猪蹄   족발.보쌈
     * 全部  전체업소
     * @var array
     */
    public $shopTypes = array(
        array(
            '치킨.피자',
            '한식.분식',
            '돈까스.일식.회',
            '도시락.중식.죽',
            '족발.보쌈'
        ),//跟分类顺序对应上，此为外卖的子分类
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
}
