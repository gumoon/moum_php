<?php

namespace moum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spread extends Model
{
    use SoftDeletes;

    /**
	 * The attributes that should be mutated to dates.
	 * @var array
	 * 
	 */
	protected $dates = ['deleted_at'];

	//外卖商户推荐位置ID
    const POSITION_RECOMMEND_SHOP = 0;
    //启动页位置ID
    const POSITION_BOOT_PAGE = 1;
    //首页主题列表位置ID
    const POSITION_INDEX_TOPIC = 2;
	//杂志页位置ID
	const POSITION_MAGAZINE_PAGE = 3;

	//链接对象类型 网址
    const FLAG_WEBSITE = 0;
    //链接对象类型 商户
    const FLAG_SHOP = 1;
    //链接对象类型 114
    const FLAG_ONE14 = 2;
}
