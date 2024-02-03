<?php

namespace App\Enums;

use App\Enums\Data\OrderStatusEnumData;
use App\Enums\Traits\OrderStatusEnumTrait;
use BenSampo\Enum\Enum;

final class OrderStatusEnum extends Enum
{

  const PROCESSING = "processing";
  const CONFIRMED = "confirmed";
  const SHIPPED = "shipped";
  const DELIVERED = "delivered";
  const COMPLETED = 'completed';
  const CANCELED = "canceled";

  public function color()
  {
    return OrderStatusEnumData::getStatusData($this->key, 'color');
  }
  
}
