<?php

namespace moum\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function successJson( $data )
    {
    	$ret = array(
    		'err_no' => 0,
    		'msg' => 'success',
    		'data' => $data
    	);

    	return response()->json( $ret );
    }
}
