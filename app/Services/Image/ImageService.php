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
    private $height;
    private $width;
    private $imageText;

    public function __construct(Image $image = null)
    {
        $this->image = $image;
        $this->height = "";
        $this->width = "";
        $this->imageText = "BibiSena.Com";
    }

    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    public function setText($text)
    {
        $this->imageText = $text;
        return $this;
    }

    public function src()
    {
        return url($this->getImagePath());
    }

    public function getDomainPath()
    {
        return env('DOMAIN_URL') . $this->getImagePath();
    }

    public function getImagePath()
    {
        return Constant::IMAGE_DIR . ($this->image ? $this->image->name : Constant::DEFAULT_IMAGE);
    }

    public function create($imageFile)
    {
        if (!request()->hasFile($imageFile)) return null;

        $imageFile = request()->file($imageFile);
        $image = ImageLib::make($imageFile);

        if ($this->width != "" && $this->height != "") {
            $image->resize($this->width, $this->height);
        }

        if ($this->imageText != "") {
            $image->text($this->imageText, 70, 30, function ($font) {
                $font->file(public_path('fonts/OpenSans-Regular.ttf'));
                $font->size(10);
                $font->color('#aaaaaa');
                $font->align('center');
                $font->angle(10);
            });
        }

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

    public function response()
    {
        return route('image', ['filename' => $this->image ? $this->image->name : Constant::DEFAULT_IMAGE, 'height' => 300, 'width' => 300]);
    }
}
