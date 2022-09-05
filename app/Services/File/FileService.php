<?php

namespace App\Services\File;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class FileService
{
    public function imageStore($name)
    {
        if (!request()->hasFile($name)) return;

        $imageFile = request()->file($name);
        $imageName = $this->getImageName($imageFile);

        $image = Image::make($imageFile)->resize(300, 300)->encode('jpg');

        $image->text('BibiSena.Com', 70, 30, function ($font) {
            $font->file(public_path('fonts/OpenSans-Regular.ttf'));
            $font->size(10);
            $font->color('#aaaaaa');
            $font->align('center');
            $font->angle(10);
        });

        $path = Storage::put($imageName, $image->stream());
        $url = Storage::url($imageName);

        return $url;
    }

    public function getImageName($imageFile)
    {
        $extension = pathinfo($imageFile->getClientOriginalName(), PATHINFO_EXTENSION);
        $imageName = "images/" . Str::random(40) . ".jpg";
        return $imageName;
    }
}
