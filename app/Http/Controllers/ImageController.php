<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function resize($filename)
    {
        $basePath = public_path('images/' . $filename);

        if (!File::exists($basePath)) {
            abort(404);
        }

        $width = request()->get('width');
        $height = request()->get('height');

        $path = "images/";
       // if($width)$path .= $width."/";
        if($height)$path .= $height."/";

        $cachedImagePath = public_path($filename);

        return response()->file($cachedImagePath);
        

        $image = Image::make($basePath);
        $image->resize($width, $height);
        $image->save($cachedImagePath);

        return $image->response();
    }

    private function getImage($basePath, $filename)
    {
        $cacheKey = 'resized_' . $filename . '_' . request('width', 'default') . '_' . request('height', 'default');

        return cache()->remember($cacheKey, now()->addYear(), function () use ($basePath, $filename) {
            $image = Image::make($basePath);

            $width = request()->get('width', $image->width());
            $height = request()->get('height', $image->height());

            $image->resize($width, $height);

            return $image->response();
        });
    }
}
