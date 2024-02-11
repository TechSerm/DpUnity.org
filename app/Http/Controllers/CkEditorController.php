<?php

namespace App\Http\Controllers;

use App\Services\Image\ImageService;
use Illuminate\Http\Request;

class CkEditorController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $image = (new ImageService())->create('upload');
        }

        $url = $image ? $image->src() : '';

        $CKEditorFuncNum = $request->input('CKEditorFuncNum');
        $msg = 'Image successfully uploaded';
        $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
        
        @header('Content-type: text/html; charset=utf-8');

        echo $re;
    }
}
