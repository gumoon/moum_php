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
    public $shopTypes = array(
        array(
            '炸鸡.披萨',
            '韩食.快餐',
            '炸猪排.寿司',
            '盒饭.中式.粥',
            '猪蹄.菜包饭'
        ),//跟分类顺序对应上，此为外卖的子分类
    );

    //封装成功返回的json
    protected function successJson( $data = null )
    {
    	$ret = array(
    		'err_no' => 0,
    		'msg' => 'success',
    		'data' => $data ? $data : new \stdClass
    	);

    	return response()->json( $ret );
    }
}
