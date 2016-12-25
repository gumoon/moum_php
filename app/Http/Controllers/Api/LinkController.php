<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;


class LinkController extends Controller
{
    /**
     * @api {get} /discover/links 发现模块的常用链接
     * @apiName DiscoverLinks
     * @apiGroup Discover
     *
     * 
     * 
     */
	public function all(Request $request)
	{
		for ($i=0; $i < 10; $i++) 
		{ 
			$tmp1[] = array(
				'icon' => '',
				'name' => '百度',
				'url' => 'http://www.baidu.com'
			);
		}

		for ($i=0; $i < 10; $i++) 
		{ 
			$tmp2[] = array(
				'icon' => '',
				'name' => '新浪',
				'url' => 'http://www.sina.com.cn'
			);
		}
		
		$links = array(
			'china' => $tmp1,
			'korea' => $tmp2
		);

		$ret = array(
			'err_no' => 0,
			'msg' => 'success',
			'data' => $links,
		);

		return response()->json($ret);
	}
}
