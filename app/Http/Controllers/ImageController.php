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

        $image = Image::make($basePath);

        // Get the width and height parameters from the URL
        $width = request()->get('width', $image->width());
        $height = request()->get('height', $image->height());

        // Resize the image
        $image->resize($width, $height);

        // Return the resized image as a response
        return $image->response();
    }
}
