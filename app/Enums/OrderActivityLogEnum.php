<?php

namespace App\Enums;

use App\Enums\Data\OrderStatusEnumData;
use BenSampo\Enum\Enum;

final class OrderActivityLogEnum extends Enum
{

  const SHOW_ORDER = "show_order";
  const CREATED = 'created';
  const UPDATED = 'updated';
  const ADD_PRODUCT = 'added_product';
  const UPDATE_PRODUCT = 'update_product';

}
