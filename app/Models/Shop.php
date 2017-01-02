<?php

namespace moum\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
	
    /**
     * Get the comments for the shop.
     */
    public function comments()
    {
    	return $this->hasMany('moum\Models\Comment');
    }
}
