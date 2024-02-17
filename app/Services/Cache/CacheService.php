<?php

namespace App\Services\Cache;

abstract class CacheService
{
    protected $cacheKey = "temp";
    protected $cacheTime = 525600; //1 year

    public function update()
    {
        $data = $this->data();
        cache()->put($this->cacheKey, $data);

        return $data;
    }

    public function get()
    {
        return cache()->remember($this->cacheKey, $this->cacheTime, function () {
            return $this->data();
        });
    }

    abstract protected function data();
}
