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

  public function friendlyName()
  {
    return self::getFriendlyName($this->key);
  }

  public function badge()
  {
    $color = $this->color();
    $name = $this->friendlyName();
    return "
    <span class='badge' style='background: $color; color: #ffffff'>
      $name
    </span>
    ";
  }
}