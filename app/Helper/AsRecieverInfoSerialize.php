<?php

namespace App\Helper;


class AsRecieverInfoSerialize
{
    public static function pro_unserialize(string $str): ?array
    {
        if (PHP_VERSION > 7.2) {
            if (strpos($str, 'r:') !== false) {
                $arr =   explode(':{', $str);
                $text = trim($arr[1], '}');
                $arr2 = array_filter(explode(';', $text));
                $keys = [];
                $values = [];
                foreach ($arr2 as $k => $v) {
                    if ($k % 2 === 0) {
                        array_push($keys, $v);
                    } else {
                        array_push($values, $v);
                    }
                }
                $newStr = '';
                foreach ($values as  $key => $val) {
                    if (strpos($val, 'r:') !== false) {
                        $arrs =  explode('r:', $val);
                        $pos = $arrs[1] - 2;
                        $val = $values[$pos];
                    }
                    $newStr .= $keys[$key] . ';' . $val . ';';
                }
                $str = $arr[0] . ':{' . $newStr . '}';
            }
        }
        return  unserialize($str);

    }
}
