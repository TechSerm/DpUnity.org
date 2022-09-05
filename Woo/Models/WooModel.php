<?php

namespace Woo\Models;

use App\Models\WooQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Woo\Queue\WooQueueService;
use Woo\Traits\WooModelHelperTrait;

class WooModel
{
    use WooModelHelperTrait;

    public $ormModel;
    public $wooId;
    public $wooSlug;
    public $wooData;
    public $ormModelId;
    public $wooQueueService;

    public function __construct(Model $ormModel = null)
    {
        $this->wooData = $ormModel ? $this->getWooData($ormModel) : [];
        $this->ormModel = $ormModel ? $ormModel : $this->getOrmClass();
        $this->wooQueueService = new WooQueueService();
    }

    public function create()
    {
        $this->addWooQueue('create');
    }

    public function update()
    {
        $this->addWooQueue('update');
    }

    public function delete()
    {
        $this->wooData = [];
        if ($this->getWooId()) $this->addWooQueue('delete');
    }

    public function sync()
    {
        $this->wooData = [];
        $this->addWooQueue('sync');
    }

    public function addWooQueue($method)
    {
        if ($method == 'update' && empty($this->wooData)) return;

        $queueData = [
            'slug' => $this->getUrl(),
            'data' => $this->wooData,
            'method' => $method,
            'woo_model' => $this->getNameOfModel(),
            'woo_id' => $this->getWooId(),
            'orm_model_id' => $this->getOrmModelId()
        ];

        $this->wooQueueService->create($queueData);
        $this->added($queueData);
    }

    public function added($queueData)
    {
    }

    public function updateOrmData($ormModelId, $wooData)
    {
        $ormModel = $this->ormModel->find($ormModelId);
        if ($ormModel) $ormModel->update($this->getOrmData($wooData));
    }

    public function updateWooId($ormModelId, $wooId)
    {
        $ormModel = $this->ormModel->find($ormModelId);
        if ($ormModel) $ormModel->update([
            'woo_id' => $wooId
        ]);
    }
}
