<?php

namespace FikenSDK\Support;

class Compare
{
    public static function arrayDiffAssoc(array $array1, array $array2)
    {
        $diff = [];

        foreach ($array1 as $key => $val) {
            if (!isset($array2[$key])) {
                $diff[$key] = $val;
            } elseif (is_array($val)) {
                if (is_array($array2[$key])) {
                    $recursiveDiff = self::arrayDiffAssoc($val, $array2[$key]);

                    if (!empty($recursiveDiff)) {
                        $diff[$key] = $recursiveDiff;
                    }
                } else {
                    $diff[$key] = $val;
                }
            } elseif (static::areDifferent($val, $array2[$key])) {
                $diff[$key] = $val;
            }
        }

        return $diff;
    }

    protected static function areDifferent($val1, $val2)
    {
        return $val1 !== $val2;
    }

    public static function stringCompare($string1, $string2)
    {
        return mb_strtolower(str_replace(' ', '', $string1), 'UTF-8')
            === mb_strtolower(str_replace(' ', '', $string2), 'UTF-8');
    }
}