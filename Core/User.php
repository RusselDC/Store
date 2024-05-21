<?php

namespace Core;


class User
{
    protected static $user = null; 

    public static function Auth($user)
    {
        self::$user = $user;
        return $user;
    }

    public static function user()
    {
        return self::$user;
    }
}