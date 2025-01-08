<?php

namespace App\Enums;

use App\Enums\Traits\EnumToArray;

enum PropertyStatus: int
{
    use EnumToArray;

    case Active = 1;
    case Inactive = 2;
}
