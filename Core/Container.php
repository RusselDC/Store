<?php

namespace Core;
use Exception;
class Container
{
    protected $bindings;
    public function bind($key, $function)
    {
        $this->bindings[$key] = $function;
    }
    public function resolve($key)
    {
        if(!array_key_exists($key,$this->bindings))
        {
            throw new Exception('No matching binding found for your key! '.$key);
        }
        $function = $this->bindings[$key];
        return call_user_func($function);

    }

}
