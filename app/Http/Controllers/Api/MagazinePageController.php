<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use Config;
use DB;
use moum\Http\Controllers\Controller;
use moum\Models\Spread;
use moum\Models\Shop;
use moum\Models\One14;

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
     * @apiSuccess {String} data.name
     * @apiSuccess {String} data.image_url
     * @apiSuccess {String} data.flag 0=没有标记，1=new
     * @apiSuccess {String} data.tel 杂志页关联对象电话号
     * @apiSuccess {String} data.addr 杂志页关联对象地址
     * @apiSuccess {Number} data.lat 杂志页关联对象纬度
     * @apiSuccess {Number} data.lng 杂志页关联对象经度
     * @apiSuccess {Number} data.type 杂志页关联对象类型，1=美食商户,2=114黄页
     * @apiSuccess {String} [data.url] 杂志页关联对象链接为114商户时，有这个字段
     * @apiSuccess {Number} [data.shop_id] 对象类型为美食时，有这个字段
     *
     * @apiSuccessExample {json} Success-response:
     * {
     *  "err_no": 0,
     *  "msg": "",
     *  "data": [
     *    {
     *      "image_url": "http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg",
     *      "flag": 1,
     *      "name": "商户名",
     *      "tel": 186xxxx2432,
     *      "addr": "地址"，
     *      "lat": 124.223,
     *      "lng": 234.532,
     *      "type": 1,
     *      "shop_id": 13,
     *      "url": "www.baidu.com"
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

        $page = $request->input('page', 1);
        $count = $request->input('count', 10);
        $offset = ($page - 1) * $count;

        //按照时间戳，查询最新的杂志页列表
        $spreads = Spread::where('position_id', Spread::POSITION_MAGAZINE_PAGE)
            ->latest()
            ->skip($offset)
            ->take($count)
            ->get();

        $tmp = array();
        foreach ($spreads AS $spread) {
            $tmp[] = array(
                'image_url' => $spread->image_url ? Config::get('app.ossDomain'). $spread->image_url : '',
                'flag' => mt_rand() % 2,
            );

            if ($spread->flag == Spread::FLAG_SHOP) {
                $shop = Shop::find($spread->extra);
                $tmp['name'] = $shop->name;
                $tmp['tel'] = $shop->tel;
                $tmp['addr'] = $shop->addr;
                $tmp['lat'] = $shop->lat;
                $tmp['lng'] = $shop->lng;
                $tmp['type'] = $spread->flag;
                $tmp['shop_id'] = $shop->id;

            } elseif ($spread->flag == Spread::FLAG_ONE14) {
                $one14 = One14::find($spread->extra);
                $tmp['name'] = $one14->name;
                $tmp['tel'] = $one14->tel;
                $tmp['addr'] = $one14->addr;
                $tmp['lat'] = $one14->lat;
                $tmp['lng'] = $one14->lng;
                $tmp['type'] = $spread->flag;
                $tmp['url'] = url('home/one14/profile', [base64_encode($spread->extra)]);
            }
        }

        return $this->successJson( $tmp );
    }
}
