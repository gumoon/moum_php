<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use Config;
use DB;
use moum\Http\Controllers\Controller;
use GuzzleHttp\Client;

class NewsController extends Controller
{
    /**
     * @api {get} /news/timeline 最新新闻列表
     * @apiName NewsTimeline
     * @apiGroup News
     *
     * @apiParam {Number} [page=1]
     * @apiParam {Number} [count=10]
     *
     * @apiSuccess {Number} err_no
     * @apiSuccess {String} msg
     * @apiSuccess {Object[]} data
     * @apiSuccess {Number} data.id 新闻ID
     * @apiSuccess {String} data.title 新闻标题
     * @apiSuccess {String} data.image_url 新闻图片
     * @apiSuccess {String} data.created_at 发布时间
     * @apiSuccess {String} data.url 新闻详情页
     * @apiSuccess {Object} data.source
     * @apiSuccess {String} data.source.name 新闻来源名
     * @apiSuccess {String} data.source.logo_url 新闻来源logo链接
     *
     * @apiSuccessExample {json} Success-response:
     * {
     *  "err_no": 0,
     *  "msg": "",
     *  "data": [
     *    {
     *      "id": 0,
     *      "title": "新闻标题标题",
     *      "image_url": "http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg",
     *      "created_at": "5小时前",
     *      "url": "http://www.baidu.com/",
     *      "source":
     *       {
     *          "name": "望京通",
     *          "logo_url": "http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg"
     *       }
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

        //按照时间戳，查询最新的商户列表
//        $shops = Shop::where('id', '>', 0)
//            ->latest()
//            ->skip($offset)
//            ->take($count)
//            ->get();

        $client = new Client();
        $url = "http://www.zoglo.net/stand/getMobileJson/1/board/m_photo_news/0/0/0/{$count}/x/0/0/0/0/last_update";
        $res = $client->request('get', $url);
        $res = json_decode($res->getBody(), true);
        $tmp = array();
        foreach ($res AS $v) {
            $tmp[] = array(
                'id' => $v['doc_id'],
                'title' => $v['title'],
                'image_url' => 'http://www.zoglo.net/'.$v['img1'],
                'created_at' => $v['datetime'],
                'url' => 'http://www.zoglo.net/weixin/index.html?doc_id='.$v['doc_id'],
                'source' => array(
                    'name' => $v['username'],
                    'logo_url' => 'http://www.zoglo.net/weixin/images/logo1.gif',
                ),
            );
        }

        return $this->successJson( $tmp );
    }
}
