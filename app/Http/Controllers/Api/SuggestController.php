<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;

class SuggestController extends Controller
{
	/**
	 * @api {post} /suggest/create 用户给APP提反馈建议
	 * 
	 * @apiName SuggestCreate
	 * @apiGroup Suggest
	 *
	 * @apiParam {Number} [tel]
	 * @apiParam {String} content
	 * 
	 * @apiSuccess {Number} err_no 
	 * @apiSuccess {String} msg
	 * @apiSuccess {Object} data
	 * @apiSuccessExample {json} Success-response: 
	 * {
	 *  "err_no": 0,
	 *  "msg": "success",
	 *  "data": {}
	 * }
	 */
	public function create(Request $request)
	{
		$this->validate($request, [
			'content' => 'required'
		]);

		$userId = $request->user()->id;
		$clientId = $request->user()->token()->client_id;
		$uuid = $request->header('uuid');
		$tel = $request->input('tel');
		$content = $request->input('content');

		// $suggest = new Suggest;
		// $suggest->user_id = $userId;
		// $suggest->client_id = $clientId;
		// $suggest->tel = $tel;
		// $suggest->uuid = $uuid;
		// $suggest->content = $content;

		// $suggest->save();

		return $this->successJson();
	}
	
}
