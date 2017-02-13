<?php

namespace moum\Models;

use Illuminate\Database\Eloquent\Model;

class Dial extends Model
{
    public $timestamps = false;

    /**
     * Get the user that owns the dails.
     */
    public function user()
    {
    	return $this->belongsTo('moum\Models\User');
    }

    /**
     * Get the shop that owns the dials.
     */
    public function shop()
    {
    	return $this->belongsTo('moum\Models\Shop');
    }

    /**
     * Get the one14 that owns the dials.
     */
    public function one14()
    {
        return $this->belongsTo('moum\Models\One14');
    }
}
