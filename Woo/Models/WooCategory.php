<?php

namespace Woo\Models;

use App\Models\Category;
use Woo\Models;
use Illuminate\Support\Carbon;

class WooCategory extends WooModel
{
    public $wooSlug = "products/categories";

    /**
     * Get orm model.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getOrmClass()
    {
        return new Category();
    }

    /**
     * Get woo data from orm data.
     *
     * @return array<string, string>
     */
    public function getWooData(Category $category)
    {
        $rangeTime = Carbon::now()->subSeconds(10)->toDateTimeString();
        $lastActivity = $category->activities()->where('created_at', '>=', $rangeTime)->orderBy('id', 'desc')->first();

        if (!$lastActivity) return [];
        $changes = $lastActivity->changes['attributes'];

        $data = [];

        if (isset($changes['name'])) $data['name'] = $changes['name'];
        if (isset($changes['image'])) {
            $data['image'] = [
                'src' => $category->image
            ];
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
            'image' => $wooData->image->src
        ];
        return $ormData;
    }

    public function added($queueData)
    {
        if (isset($queueData['data']) && isset($queueData['data']['image']) && $this->getWooId()) {
            $this->sync();
        }
    }
}
