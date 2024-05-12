<?php

require __DIR__.'/../vendor/autoload.php';
use Illuminate\Support\Collection;


$numbers = new Collection([
    5,2,3,10,5
]);


function jake($var)
{
    if($var==5)
    {
        return 1000;
    };
    return $var;
}


echo $numbers->filter(function ($number){
    return $number < 10;
});


