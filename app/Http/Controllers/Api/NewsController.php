<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use Config;
use DB;
use moum\Http\Controllers\Controller;

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
     * @apiSuccess {Number} data.id
     * @apiSuccess {String} data.title
     * @apiSuccess {String} data.image_url
     * @apiSuccess {String} data.created_at
     * @apiSuccess {Object} data.source
     * @apiSuccess {String} data.source.name
     * @apiSuccess {String} data.source.logo_url
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

        $tmp = array();
        for ($i = 0; $i <= 5; $i++) {
            $tmp[] = array(
                'id' => 1,
                'title' => "新闻标题新闻标题",
                'image_url' => "http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg",
                'created_at' => "10分钟前",
                'source' => array(
                    'name' => '望京通',
                    'logo_url' => 'http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg'
                )
            );
        }

        return $this->successJson( $tmp );
    }

    /**
     * @api {get} /news/show 单个新闻详情
     * @apiName NewsShow
     * @apiGroup News
     *
     * @apiParam {Number} news_id 新闻ID
     *
     * @apiSuccess {Number} err_no 错误码
     * @apiSuccess {String} msg 错误信息
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.id 新闻ID
     * @apiSuccess {String} data.title 新闻标题
     *
     * @apiSuccessExample {json} Success-response:
     * {
     *  "err_no": 0,
     *  "msg": "",
     *  "data": {
     *    "id": 10,
     *    "title": "新闻标题",
     *    "content": "新闻内容",
     *    "image_url": "http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg",
     *    "created_at": "5小时前",
     *    "source":
     *     {
     *        "name": "望京通",
     *        "logo_url": "http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg"
     *     }
     *  }
     * }
     */
    public function show(Request $request)
    {
        $this->validate($request, [
            'news_id' => 'bail|required'
        ]);

        $newsId = $request->input('news_id');
        $uuid = $request->header('uuid');
        if( empty($uuid) )
        {
            return $this->failedJson('uuid');
        }

//        $shop = Shop::findOrFail( $shopId );
        //添加一条设备访问商户的记录。

        $data = array(
            'id' => 1,
            'title' => "新闻标题新闻标题",
            'content' => '新闻内容，新闻内容',
            'image_url' => "http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg",
            'created_at' => "10分钟前",
            'source' => array(
                'name' => '望京通',
                'logo_url' => 'http://www.6681.com/uploads/allimg/160321/51-160321164625.jpg'
            )
        );

        return $this->successJson( $data );
    }
}
