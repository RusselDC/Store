<?php
namespace Core;

use DateTime;

class Validator
{
    public static function string($value)
    {
        return strlen(trim($value))==0;
    }

    public static function length($value,$length)
    {
        return strlen($value)>$length;
    }

    public static function email($value)
    {
        $pattern = "/^\S+@\S+\.\S+$/";
        return !preg_match($pattern, $value);
    }
    public static function min($value)
    {
        return strlen(trim($value)) <= 7;
    }
    public static function match($value,$value2)
    {
        return $value != $value2;
    }
    public static function number($value)
    {
        return !is_numeric($value);
    }
    public static function min_quantity($value, $limit)
    {
        return $value < $limit;
    }

    public static function max_quantity($value, $limit)
    {
        return $value > $limit;
    }


    public static function date($date)
    {
        if (DateTime::createFromFormat('Y-m-d', $date) !== false) {
            if ($date !== false) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    

    


}