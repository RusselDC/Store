<?php

test('Container', function () {
    $container = new \Core\Container();


    $container->bind('foo',function ()
    {
        return 'bar';
    });
    $result = $container->resolve('foo');

    expect($result)->toEqual('bar');
});
