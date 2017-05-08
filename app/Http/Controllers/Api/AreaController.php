<?php
/**
 * Created by PhpStorm.
 * User: gumoon
 * Date: 2017/5/8
 * Time: 22:29
 */

namespace moum\Http\Controllers\Api;


use moum\Http\Controllers\Controller;

class AreaController extends Controller
{
    /**
     * @api {get} /area/get_all 全部城市
     * @apiName AreaGetAll
     * @apiGroup Area
     *
     * @apiSuccess {Number} err_no 错误码
     * @apiSuccess {String} msg 错误信息
     * @apiSuccess {Object[]} data
     * @apiSuccess {String} data.name 地区名
     * @apiSuccess {Number} data.area_id 地区ID
     *
     * @apiSuccessExample {json} Success-Response:
        {
            "err_no": 0,
            "msg": "成功",
            "data": [
                {
                    "name": "北京",
                    "area_id": 1
                },
                {
                    "name": "燕郊",
                    "area_id": 2
                }
            ]
        }
     */
    public function getAll()
    {
        return $this->successJson( $this->areas );
    }
}