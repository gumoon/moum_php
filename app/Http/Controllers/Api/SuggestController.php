<?php

namespace moum\Http\Controllers\Api;

use Illuminate\Http\Request;
use moum\Http\Controllers\Controller;
use moum\Models\Suggest;

class SuggestController extends Controller
{
	/**
	 * @api {post} /suggest/create 用户给APP提反馈建议
	 * 
	 * @apiName SuggestCreate
	 * @apiGroup Suggest
	 *
	 * @apiHeader {String} authorization Authorization value.
	 * @apiHeader {String} uuid
	 * 
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
		$content = $request->input('content');

		$suggest = new Suggest;
		$suggest->user_id = $userId;
		$suggest->client_id = $clientId;
		$suggest->uuid = $uuid;
		$suggest->content = $content;

		$suggest->save();

		return $this->successJson();
	}
	
}
