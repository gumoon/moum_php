<?php

namespace moum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    protected $table = 'news';

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     * @var array
     *
     */
    protected $dates = ['deleted_at'];

    const NEWS_SOURCE_ZOGLO = 'zoglo';
    public static $sources = array(
        //抓取来源
        //http://www.zoglo.net/stand/getMobileJson/1/board/m_photo_news/0/0/0/20/x/0/0/0/0/last_update
        //http://www.zoglo.net/stand/getMobileContent/308218
        'zoglo' => array(
            'name' => '潮歌网',
            'logo_url' => 'http://www.zoglo.net/weixin/images/logo1.gif',
            'base_url' => 'http://www.zoglo.net/'
        )
    );
}
