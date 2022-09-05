<?php

namespace Woo\Traits;

trait WooModelHelperTrait
{
    public function getWooId()
    {
        return $this->ormModel->woo_id ?? null;
    }

    public function getOrmModelId()
    {
        return $this->ormModel->id;
    }

    public function getUrl()
    {
        return $this->wooSlug . "/" . $this->getWooId();
    }

    public function getNameOfModel()
    {
        return static::class;
    }
}
