<?php

namespace App\Enums;

use App\Enums\Data\OrderStatusEnumData;
use App\Enums\Traits\OrderStatusEnumTrait;
use BenSampo\Enum\Enum;

final class OrderStatusEnum extends Enum
{

  const PENDING = "pending";
  const APPROVED = "approved";
  const ASSIGN_STORE = "assign_store";
  const RECEIVED_BY_STORE = "received_by_store";
  const PACK_COMPLETE = 'pack_complete';
  const START_DELIVERY = "start_delivery";
  const DELIVERY_COMPLETED = "delivery_completed";
  const VENDOR_PAYMENT_SEND = "vendor_payment_send";
  const VENDOR_PAYMENT_RECEIVED = "vendor_payment_received";
  const CANCELED = "canceled";

  public function bnName()
  {
    return OrderStatusEnumData::getStatusData($this->key, 'bnName');
  }

  public function color()
  {
    return OrderStatusEnumData::getStatusData($this->key, 'color');
  }

  public function name()
  {
    return OrderStatusEnumData::getStatusData($this->key, 'name');
  }
}
