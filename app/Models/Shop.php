<?php

namespace moum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
	use SoftDeletes;

	/**
	 * The attributes that should be mutated to dates.
	 * @var array
	 * 
	 */
	protected $dates = ['deleted_at'];
	
    /**
     * Get the comments for the shop.
     */
    public function comments()
    {
    	return $this->hasMany('moum\Models\Comment');
    }
}
