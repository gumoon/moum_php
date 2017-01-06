<?php

namespace moum\Models;

use Illuminate\Database\Eloquent\Model;

class AccessShop extends Model
{
    public $timestamps = false;

    /**
     * Get the shop that owns the dials.
     */
    public function shop()
    {
    	return $this->belongsTo('moum\Models\Shop');
    }    
}
