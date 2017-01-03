<?php

namespace moum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     * @var array
     * 
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the shop that owns the comments.
     */
    public function shop()
    {
    	return $this->belongsTo('moum\Models\Shop');
    }

    /**
     * Get the user that owns the comments.
     */
    public function user()
    {
    	return $this->belongsTo('moum\Models\User');
    }
}
