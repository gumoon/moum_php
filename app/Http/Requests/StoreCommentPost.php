<?php

namespace moum\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 验证登录用户是否有权限更新资源
     * @return bool
     */
    public function authorize()
    {
        //返回true表示有权限
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'shop_id' => 'required',
            'content' => 'required',
        ];
    }
}
