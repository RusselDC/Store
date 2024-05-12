<?php

use Core\App;
use Core\Database;
use Http\Forms\BuyForm;
$form =  new BuyForm();
$conn = App::resolve(Database::class);

$quantity = $_POST['quantity'];
$productID = $_GET['id'];
$token = getallheaders()['token'];

$token = $conn->findbyColumn('auth_token', 'token', $token);
$user = $conn->find('users', $token['user_id']);

$validated = $form->validate($quantity);
if(!empty($validated)){
    exit(json_encode($validated));
}

$products = $form->product($productID);
if(!$products){
    exit(json_encode(['error' => 'Product not found']));
}
$store = $form->store($products['store_id']);
if(!$store){
    exit(json_encode(['error' => 'Store not found']));
}

$quantityCheck = $form->checkQuantity($quantity, $products['quantity_available']);

if(!empty($quantityCheck)){
    exit(json_encode($quantityCheck));
}



$userID = $user['id'];
$productID = $products['id'];
$storeID = $store['id'];
$orderID = "ORD-$storeID-$userID-$productID-".uniqid()."-".time();
$totalPrice = $products['price'] * $quantity;

$conn->query("INSERT INTO orders (order_id, customer_id, store_id, total_price) VALUES (?, ?, ?, ?)", 
[$orderID, $userID, $storeID, $totalPrice]);

$order = $conn->findbyColumn('orders', 'order_id', $orderID);

$conn->query("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)", 
[$order['id'], $productID, $quantity, $totalPrice]);

$conn->query("UPDATE products SET quantity_available = ? WHERE id = ?", [$products['quantity_available'] - $quantity, $productID]);

exit(json_encode(['success' => 'Order placed successfully', 'order_id' => $orderID]));















