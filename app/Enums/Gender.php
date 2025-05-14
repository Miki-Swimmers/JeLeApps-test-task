<?php

namespace App\Enums;

use App\Traits\Enums\ToArray;

enum Gender: string
{
    use ToArray;

    /**
     * Мужчина
     */
    case MALE = 'MALE';

    /**
     * Женщина
     */
    case FEMALE = 'FEMALE';
}
