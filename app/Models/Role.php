<?php

namespace moum\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The users that belong to the role.
     */
    public function users()
    {
    	return $this->belongsToMany('moum\Models\User', 'role_user', 'role_id', 'user_id');
    }
}
