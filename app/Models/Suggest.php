<?php

namespace moum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suggest extends Model
{
    use SoftDeletes;

    /**
	 * The attributes that should be mutated to dates.
	 * @var array
	 * 
	 */
	protected $dates = ['deleted_at'];

	/**
     * Get the user that owns the dails.
     */
    public function user()
    {
    	return $this->belongsTo('moum\Models\User');
    }
}
