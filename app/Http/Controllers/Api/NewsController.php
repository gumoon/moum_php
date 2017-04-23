<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use Config;
use DB;
use moum\Http\Controllers\Controller;
use moum\Models\News;

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
        $news = News::where('id', '>', 0)
            ->latest()
            ->skip($offset)
            ->take($count)
            ->get();

        $tmp = array();
        foreach ($news AS $v) {
            $tmp[] = array(
                'id' => $v['id'],
                'title' => $v['title'],
                'image_url' => News::$sources[$v['source']].$v['image_url'],
                'created_at' => $v['public_at'],
                'url' => 'http://www.zoglo.net/weixin/index.html?doc_id='.$v['doc_id'],
                'source' => array(
                    'name' => News::$sources[$v['source']]['name'],
                    'logo_url' => News::$sources[$v['source']]['logo_url'],
                ),
            );
        }

        return $this->successJson( $tmp );
    }
}
