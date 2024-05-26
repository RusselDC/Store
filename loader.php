<?php
use Core\Container;
use Core\App;
use Core\Database;
use Core\Queue;


$container = new Container();


$container->bind('Core\Database',function (){
    $config = require base_path('config.php');
    return new Database($config['database']);
});

$container->bind('Core\Queue',function (){
    return new Queue();
});

App::setContainer($container);