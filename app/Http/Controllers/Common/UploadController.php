<?php

namespace moum\Http\Controllers\Common;

use Illuminate\Http\Request;
use moum\Services\OSS;
use moum\Http\Controllers\Controller;

class UploadController extends Controller
{
	//上传图片
	public function image(Request $request)
	{
		$file = $request->file('image_url');

		$path = $file->path();
		$filename = $file->hashName();

		OSS::upload($filename, $path);

		$url = OSS::getUrl($filename);
		
		$data = array(
			'url' => $url,
			'filename' => $filename
		);
		
		return $this->successJson( $data );
	}

	//上传图片(ckeditor)
	public function ckimage(Request $request)
	{
		$file = $request->file('upload');

		$path = $file->path();
		$filename = $file->hashName();

		OSS::upload($filename, $path);

		$url = OSS::getUrl($filename);
		
		$data = array(
			'url' => $url,
			'filename' => $filename
		);
		
		return $this->successJson( $data );
	}
}
