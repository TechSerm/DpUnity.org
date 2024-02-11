<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderPaymentStatusEnum extends Enum
{

  const PAID = "paid";
  const DUE = "due";

  public function color()
  {
    return $this->value === self::PAID ? "#16a085" : "#c0392b";
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
