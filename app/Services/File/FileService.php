<?php

namespace App\Services\File;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
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

        //$file-> move(public_path('public/Image'), $filename);
        //$path = Storage::put($imageName, $image->stream());
        //$url = Storage::url($imageName);
        File::put("images/".$imageName, $image->stream());

        return $imageName;
    }

    public function getImageName($imageFile)
    {
        $extension = pathinfo($imageFile->getClientOriginalName(), PATHINFO_EXTENSION);
        $imageName = Str::random(40) . ".jpg";
        return $imageName;
    }
}
