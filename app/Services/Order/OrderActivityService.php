<?php

namespace App\Services\Order;

use App\Enums\OrderActivityLogEnum;
use App\Helpers\General\CollectionHelper;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderActivityService
{
    private $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function get()
    {
        return $this->order->activities()->with('causer')->orderBy('id', 'desc')->paginate(10);
    }

    public function createShowActivity()
    {
        $isExists = $this->order->activities()->where(function ($q) {
            $q->where([
                'description' => OrderActivityLogEnum::SHOW_ORDER,
                'causer_id' => auth()->user()->id
            ]);
            $q->where('created_at', '>=', Carbon::now()->subHours(5)->format('Y-m-d H:i:s'));
        })->exists();

        if (!$isExists) {
            $this->createCustomActivity(OrderActivityLogEnum::SHOW_ORDER);
            return true;
        }

        return false;
    }

    public function createAddProductActivity($orderProduct)
    {
        $this->createCustomActivity(OrderActivityLogEnum::ADD_PRODUCT, $this->getOrderProductColelction($orderProduct)->toArray());

        return false;
    }


    public function createUpdateProductActivity($orderProduct, $orderProductOld)
    {
        $orderProduct = $this->getOrderProductColelction($orderProduct);
        $orderProductOld = $this->getOrderProductColelction($orderProductOld);

        $diff = array_keys($orderProduct->diffAssoc($orderProductOld)->toArray());

        if(empty($diff))return false;

        $data = [
            'attributes' => $orderProduct->only($diff)->toArray(),
            'old' => $orderProductOld->only($diff)->toArray(),
        ];

        $this->createCustomActivity(OrderActivityLogEnum::UPDATE_PRODUCT, $data);

        return true;
    }

    private function getOrderProductColelction($orderProduct)
    {
        return collect($orderProduct)
            ->only(['product_id', 'name', 'unit', 'unit_quantity', 'quantity', 'price', 'wholesale_price', 'total', 'wholesale_price_total', 'profit', 'delivery_fee', 'vendor_id']);
    }


    public function createCustomActivity($description, $properties = [])
    {
        $activity = activity()->performedOn($this->order);
        if (!empty($this->order)) {
            $activity->withProperties($properties);
        }

        return $activity->log($description);
    }

    public function getProcessLog()
    {
        $logs = $this->order->activities()->with('causer')->orderBy('id', 'desc')->get();

        $data = [];

        foreach ($logs as $log) {
            $changes = "";
            $description = "";
            switch ($log->description) {
                case OrderActivityLogEnum::SHOW_ORDER:
                    $description = "<span class='badge badge-info'>অর্ডারটি দেখেছে</span>";
                    $changes = $this->buildHtmlShowOrder();
                    break;
                case OrderActivityLogEnum::UPDATED:
                    $description = "<span class='badge badge-warning'>অর্ডারটির পরিবর্তন হয়েছে</span>";
                    $changes = $this->buildHtmlUpdateOrder($log);
                    break;
                case OrderActivityLogEnum::CREATED:
                    $description = "<span class='badge badge-success'>অর্ডারটি তৈরী করা হয়েছে</span>";
                    $changes = $this->buildHtmlUpdateOrder($log);
                    break;
                case OrderActivityLogEnum::ADD_PRODUCT:
                    $description = "<span class='badge badge-success'>পণ্য যুক্ত করা হয়েছে</span>";
                    $changes = $this->buildHtmlAddProduct($log);
                    break;
                case OrderActivityLogEnum::UPDATE_PRODUCT:
                    $description = "<span class='badge badge-primary'>পণ্য পরিবর্তন হয়েছে</span>";
                    $changes = $this->buildHtmlUpdateProduct($log);
                    break;
                default:
                    $changes = "";
            }

            if ($description != "") {
                array_push($data, (object)[
                    'created_at' => $log->created_at,
                    'description' => $description,
                    'changes' => $changes,
                    'created_by' => $log->causer ? $log->causer->name : 'Guest',
                ]);
            }
        }

        return collect($data);
    }


    private function buildHtmlShowOrder()
    {
        return '';
    }

    private function buildHtmlAddProduct($log)
    {
        $properties = $log->properties;
        return $this->compareTwoChange($properties, []);;
    }

    private function buildHtmlUpdateProduct($log)
    {
        $oldAttributes = $log->properties['old'] ?? [];
        $attributes = $log->properties['attributes'] ?? [];

        return $this->compareTwoChange($attributes, $oldAttributes);
    }

    private function buildHtmlUpdateOrder($activity)
    {
        $oldAttributes = $activity->changes['old'] ?? [];
        $attributes = $activity->changes['attributes'] ?? [];

        return $this->compareTwoChange($attributes, $oldAttributes);
    }

    private function buildHtmlCreatedOrder($activity)
    {
        $oldAttributes = $activity->changes['old'] ?? [];
        $attributes = $activity->changes['attributes'] ?? [];

        return $this->compareTwoChange($attributes, $oldAttributes);
    }

    private function compareTwoChange($attributes, $oldAttributes, $table = 'order')
    {
        $html = "<table>";
        foreach ($attributes as $key => $value) {

            $oldAttr = $oldAttributes[$key] ?? '';
            $keyValue = $this->translateKeyName($key, $table);
            //$value = is_int($value) ? bnConvert()->number($value) : $value;
            //$oldAttr = is_int($oldAttr) ? bnConvert()->number($oldAttr) : $oldAttr;
            $html .= "<tr><td><span class='marker-info'>{$keyValue}</span></td><td>";
            if ($oldAttr != '') {
                $html .= "<span class='marker-danger'><del>$oldAttr</del></span> <i class='fa fa-arrow-right' aria-hidden='true'></i>";
            }
            $html .= " <span class='marker-success'>{$value}</span></td></tr>";
        }

        $html .= "</table>";

        return $html;
    }

    private function translateKeyName($key, $table)
    {
        $orderKeyValue = [];
        // $orderKeyValue = [
        //     'name' => 'কাস্টমারের নাম',
        //     'address' => 'কাস্টমারের ঠিকানা',
        //     'phone' => 'কাস্টমারের মোবাইল নাম্বার',
        //     'subtotal' => 'পণ্যের মূল্য',
        //     'total' => 'সর্বমোট',
        //     'wholesale_total' => 'সর্বমোট পাইকারি দাম',
        //     'delivery_fee' => 'ডেলিভারি ফী',
        //     'profit' => 'পণ্যে লাভ',
        //     'total_profit' => 'সর্বমোট লাভ',
        //     'is_approved' => 'গ্রহণ করা হয়েছে',
        //     'status' => 'অবস্থা'
        // ];

        $productKeyValue = [];

        $keyValue = $table == 'order' ? $orderKeyValue : $productKeyValue;

        return $keyValue[$key] ?? $key;
    }
}
