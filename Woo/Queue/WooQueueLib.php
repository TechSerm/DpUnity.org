<?php

namespace Woo\Queue;

use App\Models\WooQueue;
use App\Services\WooCommerce\WooCommerceService;

class WooQueueLib
{

    protected $wooQueue;
    protected $wooModel;
    protected $ormModelId;
    protected $wooData;
    protected $slug;
    protected $method;
    protected $woocommerce;

    public function __construct(WooQueue $wooQueue)
    {
        $this->wooQueue = $wooQueue;
        $this->wooModel = $this->wooModel();
        $this->ormModelId = $wooQueue->orm_model_id;
        $this->wooData = json_decode($wooQueue->data, true);
        $this->slug = $wooQueue->slug;
        $this->method = $wooQueue->method;
        $this->woocommerce = WooCommerceService::connect();
    }

    public function wooModel()
    {
        return new $this->wooQueue->woo_model();
    }

    public function release()
    {
        $woocommerce = WooCommerceService::connect();
        switch ($this->method) {
            case "sync":
                $this->sync();
                break;
            case "create":
                $this->create();
                break;
            case "update":
                $this->update();
                break;
            case "delete":
                $this->delete();
                break;
            default:
                return [];
        }

        $this->wooQueue->delete();

        return [
            'success' => true
        ];
    }

    public function sync()
    {
        $woocommerceData = $this->woocommerce->get($this->slug);
        $this->wooModel->updateOrmData($this->ormModelId, $woocommerceData);
    }

    public function update()
    {
       // dd($this->wooData);
        $woocommerceData = $this->woocommerce->put($this->slug, $this->wooData);
    }

    public function create()
    {
        $woocommerceData = $this->woocommerce->post($this->slug, $this->wooData);
        $this->wooModel->updateWooId($this->ormModelId, $woocommerceData->id);
        $this->wooModel->updateOrmData($this->ormModelId, $woocommerceData);
    }

    public function delete()
    {
        $this->woocommerce->delete($this->slug, ['force' => true]);
    }
}
