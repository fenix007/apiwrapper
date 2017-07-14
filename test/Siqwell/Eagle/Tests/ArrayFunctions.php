<?php

namespace Siqwell\Eagle\Tests;

use Illuminate\Support\Arr;

trait ArrayFunctions
{
    protected function excludeArrayOrSubArrayFields(array $arr, array $fields) : array
    {
        if (Arr::isAssoc($arr)) {
            return Arr::except($arr, $fields);
        }

        array_walk($arr, function (&$subArr) use ($fields) {
            $subArr = Arr::except($subArr, $fields);
        });

        return $arr;
    }
}
