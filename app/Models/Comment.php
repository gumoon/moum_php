<?php

namespace moum\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
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
