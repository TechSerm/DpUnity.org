<?php

namespace App\Observers;

use App\Models\Image;
use Illuminate\Support\Facades\File;

class ImageObserver
{
    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function created(Image $image) {}

    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Image $image) {}

    public function deleting(Image $image) {}

    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Image $image)
    {
        $filePath = $image->publicPath();
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Image $image)
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function forceDeleted(Image $image)
    {
        //
    }
}
