<?php

/*return [
    '/' =>  'controllers/index.php',
    '/about' =>  'controllers/about.php',
    '/contact' => 'controllers/contact.php',
    '/notes'=> 'controllers/notes/index.php',
    '/notes/add'=>'controllers/notes/create.php',
    '/note'=> 'controllers/notes/show.php'

];*/


$router->post('/', 'UserControllers/Auth.php')->only('guest');
$router->post('/register', 'UserControllers/Register.php')->only('guest');

$router->get('/logout', 'UserControllers/Logout.php')->only('auth');
$router->post('/store/create', 'StoreControllers/Create.php')->only('auth');

$router->post('/product/store', 'ProductControllers/Store.php')->only('seller');
$router->post('/product/restock', 'ProductControllers/Restock.php')->only('seller');
$router->post('/product/buy', 'ProductControllers/Buy.php')->only('auth');



