<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use Config;
use DB;
use moum\Http\Controllers\Controller;

class MagazinePageController extends Controller
{
    /**
     * @api {get} /magazine_page/timeline 最新杂志页列表
     * @apiName MagazinePageTimeline
     * @apiGroup MagazinePage
     *
     * @apiParam {Number} [page=1]
     * @apiParam {Number} [count=10]
     *
     * @apiSuccess {Number} err_no
     * @apiSuccess {String} msg
     * @apiSuccess {Object[]} data
     * @apiSuccess {Number} data.id
     * @apiSuccess {String} data.title
     * @apiSuccess {String} data.image_url
     * @apiSuccess {String} data.flag 0=没有标记，1=new
     *
     * @apiSuccessExample {json} Success-response:
     * {
     *  "err_no": 0,
     *  "msg": "",
     *  "data": [
     *    {
     *      "id": 0,
     *      "title": "杂志页标题",
     *      "image_url": "http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg",
     *      "flag": 1,
     *    }
     *    ...
     *  ]
     * }
     */
    public function timeline(Request $request)
    {
        $this->validate($request, [
            'page' => 'bail|filled|integer|min:1',
            'count' => 'bail|filled|integer|min:1'
        ]);

//        $page = $request->input('page', 1);
//        $count = $request->input('count', 10);
//        $offset = ($page - 1) * $count;

        //按照时间戳，查询最新的商户列表
//        $shops = Shop::where('id', '>', 0)
//            ->latest()
//            ->skip($offset)
//            ->take($count)
//            ->get();

        $tmp = array();
        for ($i = 0; $i <= 5; $i++) {
            $tmp[] = array(
                'id' => 1,
                'title' => "杂志页名称",
                'image_url' => "http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg",
                'flag' => mt_rand() % 2,
            );
        }

        return $this->successJson( $tmp );
    }

    /**
     * @api {get} /magazine_page/show 单个杂志页详情
     * @apiName MagazinePageShow
     * @apiGroup MagazinePage
     *
     * @apiParam {Number} magazine_page_id 杂志页ID
     *
     * @apiSuccess {Number} err_no 错误码
     * @apiSuccess {String} msg 错误信息
     * @apiSuccess {Object} data
     * @apiSuccess {String} data.image_url 图片链接
     * @apiSuccess {Number} data.id 杂志页关联对象ID
     * @apiSuccess {String} data.name 杂志页关联对象name
     * @apiSuccess {String} data.tel 杂志页关联对象电话号
     * @apiSuccess {String} data.addr 杂志页关联对象地址
     * @apiSuccess {Number} data.lat 杂志页关联对象纬度
     * @apiSuccess {Number} data.lng 杂志页关联对象经度
     * @apiSuccess {Number} data.type 杂志页关联对象类型，0=美食商户,1=114商户
     * @apiSuccess {String} data.url 杂志页关联对象链接，如果有链接的话
     *
     *
     * @apiSuccessExample {json} Success-response:
     * {
     *  "err_no": 0,
     *  "msg": "",
     *  "data": {
     *    "id": 10,
     *    "name": "商户名",
     *    "tel": "18600562137",
     *    "image_url": "http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg",
     *    "lat": 39.996794,
     *    "lng": 116.48105,
     *    "type": 0,
     *    "url": "http://www.baidu.com"
     *  }
     * }
     */
    public function show(Request $request)
    {
        $this->validate($request, [
            'magazine_page_id' => 'bail|required'
        ]);

        $uuid = $request->header('uuid');
        if( empty($uuid) )
        {
            return $this->failedJson('uuid');
        }

//        $shop = Shop::findOrFail( $shopId );
        //添加一条设备访问商户的记录。

        $data = array(
            'image_url' => "http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg",
            'id' => 10,
            'name' => "商户名商户名",
            'tel' => '18600562137',
            'addr' => '北京市朝阳区望京SOHO',
            'lat' => 39.996794,
            'lng' => 116.48105,
            'type' => mt_rand() % 2,
            'url' => 'http://www.baidu.com',
        );

        return $this->successJson( $data );
    }
}
