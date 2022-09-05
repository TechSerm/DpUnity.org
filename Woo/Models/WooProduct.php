<?php

namespace Woo\Models;

use App\Models\Product;
use Woo\Models;
use Illuminate\Support\Carbon;

class WooProduct extends WooModel
{
    public $wooSlug = "products";

    /**
     * Get orm model.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getOrmClass()
    {
        return new Product();
    }

    /**
     * Get woo data from orm data.
     *
     * @return array<string, string>
     */
    public function getWooData(Product $product)
    {
        $rangeTime = Carbon::now()->subSeconds(10)->toDateTimeString();
        $lastActivity = $product->activities()->where('created_at', '>=', $rangeTime)->orderBy('id', 'desc')->first();

        if (!$lastActivity) return [];
        $changes = $lastActivity->changes['attributes'];

        $data = [];
        if (isset($changes['name'])) $data['name'] = $changes['name'];
        if (isset($changes['price'])) $data['regular_price'] = (string) $changes['price'];
        if (isset($changes['status'])) $data['status'] = (string) $changes['status'];
        if (isset($changes['image'])) {
            $data['images'] = [
                (object) ['src' => $product->image]
            ];
        }

        $categories = $product->categories()->select('woo_id')->get();

        $data['categories'] = [];

        foreach($categories as $category){
            array_push($data['categories'], (object)[
                'id' => $category->woo_id
            ]);
        }

        return $data;
    }

    /**
     * Get orm data from woo data.
     *
     * @return array<string, string>
     */
    public function getOrmData($wooData)
    {
        $ormData = [
            'name' => $wooData->name,
            'price' => (int)$wooData->regular_price ?? 0
        ];
        $images = $wooData->images;
        if(isset($images[0]))$ormData['image'] = $images[0]->src;
        return $ormData;
    }

    public function added($queueData)
    {
        if (isset($queueData['data']) && isset($queueData['data']['images']) && $this->getWooId()) {
            $this->sync();
        }
    }
}
