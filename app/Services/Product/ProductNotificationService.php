<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Models\PushNotification;
use App\Services\HomePageProduct\HomePageProductService;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ProductNotificationService
{
    private $cacheKey = "product_notification";
    private $productNotificationData;

    public function __construct()
    {
        $this->productNotificationData = $this->getCacheNotificationData();
    }

    public function sendNotification()
    {
        $product = $this->getNotificationProduct();

        if (!empty($product)) {
            $this->sendPushNotification($product);
            $this->addProductInCache($product);
        }
    }

    public function getNotificationProduct($type = "top", $cnt = 0, $init = true)
    {
        if ($cnt >= 6) return [];

        $dataNext = [
            'top' => 'latest',
            'latest' => 'random',
            'random' => 'top'
        ];

        $notifyTime = [
            "top" => [8, 10, 15],
            "latest" => [9, 12, 18],
            "random" => [11, 14, 16]
        ];

        $currentTime = Carbon::now();
        $hour = $currentTime->hour;

        if (!in_array($hour, array_merge($notifyTime['top'], $notifyTime['latest'], $notifyTime['random']))) {
            return;
        }

        if ($init) {
            if (in_array($hour, $notifyTime['top'])) $type = "top";
            if (in_array($hour, $notifyTime['latest'])) $type = "latest";
            if (in_array($hour, $notifyTime['random'])) $type = "random";
        }

        if ($type == "top" || in_array($hour, $notifyTime['top'])) {
            $product = $this->getTopNotificaitonProduct();
        }

        if ($type == "latest" || in_array($hour, $notifyTime['latest'])) {
            $product = $this->getLatestUpdateNotificationProduct();
        }

        if ($type == "random" || in_array($hour, $notifyTime['random'])) {
            $product = $this->getRandomNotificationProduct();
        }

        if (empty($product)) return $this->getNotificationProduct($dataNext[$type], $cnt + 1, false);

        return $product;
    }

    private function getTopNotificaitonProduct()
    {
        $products = (new HomePageProductService())->getPopularProducts();

        $idList = $this->getIdList(10);
        $products = $products->whereNotIn('id', $idList);

        return $products->first();
    }

    private function getLatestUpdateNotificationProduct()
    {
        $products = Product::where(['status' => 'publish', 'has_stock' => true])->OrderBy('updated_at', 'desc')->get();

        $idList = $this->getIdList(2);
        $products = $products->whereNotIn('id', $idList);

        $products = $products->filter(function ($product) {
            if ($this->productNotificationData->pluck('id')->contains($product->id)) {
                $price = $this->productNotificationData->where('id', $product->id)->value('price');
                return $product->price != $price;
            }
            return true;
        });

        return $products->first();
    }

    private function getRandomNotificationProduct()
    {
        $queryProducts = Product::where(['status' => 'publish', 'has_stock' => true])->get();
        $idList = $this->productNotificationData->pluck('id')->all();
        $products = $queryProducts->whereNotIn('id', $idList);

        if (empty($product)) {
            $idList = $this->getIdList(15);
            $products = $queryProducts->whereNotIn('id', $idList);
        }

        return empty($product) ? [] : $products->random();
    }

    private function getIdList($ignoreDays)
    {
        return $this->productNotificationData->filter(function ($item) use ($ignoreDays) {
            return Carbon::parse($item['time'])->gte(Carbon::now()->subDays($ignoreDays));
        })->pluck('id')->all();
    }

    private function getCacheNotificationData()
    {
        return collect(cache()->get($this->cacheKey, []));
    }

    private function updateCacheNotificationData()
    {
        cache()->put($this->cacheKey, $this->productNotificationData->toArray(), 2628000);
    }

    private function addProductInCache(Product $product)
    {
        $this->productNotificationData = $this->productNotificationData->reject(function ($item) use ($product) {
            return $item['id'] === $product->id;
        });

        $this->productNotificationData->push([
            'id' => $product->id,
            'price' => $product->price,
            'time' => Carbon::now()
        ]);
        echo $product->name;
        echo $product->id;
        //print_r($this->productNotificationData->pluck('id')->toArray());

        $this->updateCacheNotificationData();
    }

    private function sendPushNotification(Product $product)
    {

        $pushNotification = PushNotification::create([
            'uuid' => Str::uuid(),
            'title' => $this->getTitle($product),
            'body' => $this->getBody($product),
            'url' => env('DOMAIN_URL')."product/".$product->id,
            'image' => $product->imageSrv()->getDomainPath(),
        ]);

        $totalSuccessfullySend = $pushNotification->notifyAdmin();
    }

    private function getTitle(Product $product)
    {
        return $product->name;
    }

    private function getBody(Product $product)
    {
        $body = bnConvert()->number($product->quantity) . " ";
        $body .= bnConvert()->unit($product->unit) . " - " . bnConvert()->number($product->price) . " টাকা";
        return $body;
    }
}
