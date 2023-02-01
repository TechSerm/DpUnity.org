<?php

namespace App\Services\Image;

use App\Helpers\Constant;
use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image as ImageLib;

class ImageService
{
    private $image;

    public function __construct(Image $image = null)
    {
        $this->image = $image;
    }

    public function src()
    {
        return url($this->getImagePath());
    }

    private function getImagePath()
    {
        return Constant::IMAGE_DIR . ($this->image ? $this->image->name : Constant::DEFAULT_IMAGE);
    }

    public function create($imageFile)
    {
        if (!request()->hasFile($imageFile)) return null;

        $imageFile = request()->file($imageFile);
        $image = ImageLib::make($imageFile)->resize(800, 800);

        $image->text('BibiSena.Com', 70, 30, function ($font) {
            $font->file(public_path('fonts/OpenSans-Regular.ttf'));
            $font->size(10);
            $font->color('#aaaaaa');
            $font->align('center');
            $font->angle(10);
        });

        $imageName = $this->getImageName($imageFile);
        File::put(public_path(Constant::IMAGE_DIR . $imageName), $image->stream());
        $image = Image::create([
            'name' => $imageName
        ]);

        return $image;
    }

    public function createAndReplace($imageFile)
    {
        $this->delete();
        return $this->create($imageFile);
    }

    private function getImageName($imageFile)
    {
        $extension = pathinfo($imageFile->getClientOriginalName(), PATHINFO_EXTENSION);
        $imageName = Str::random(40) . "." . $extension;
        return $imageName;
    }

    public function delete()
    {
        if ($this->image) {
            File::delete(public_path($this->getImagePath()));
            $this->image->delete();
        }
    }
}