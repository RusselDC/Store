<?php

namespace Core\Middleware;

class Middleware
{
    const ROLES =
        [
            'guest'=>Guest::class,
            'auth'=>Auth::class,
            'seller'=>Seller::class,
        ];

    public static function resolve($key)
    {
        if(!isset($key))
        {
            return;
        }
        $mw = static::ROLES[$key] ?? false;
        if(!isset($mw))
        {
            throw new \Exception('NO MATCHING MIDDLEWARE FOUND FOR KEY '.$key);
        }
        (new $mw)->handle();
    }
}
