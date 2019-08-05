<?php

namespace App\Helpers;

abstract class Functions
{
    public static function getStatus($index, $values = [])
    {
        return $values[$index];
    }
}
