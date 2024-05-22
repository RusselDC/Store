<?php

use Core\App;
use Core\Database;

use Core\InputRules;
use Core\Response;
use Core\ResponseCode;
$validate = new InputRules();


$conn = App::resolve(Database::class);

$quantity = $_POST['quantity'];
$productID = $_GET['id'];
$token = getallheaders()['token'];

$token = $conn->findbyColumn('auth_token', 'token', $token);
$user = $conn->find('users', $token['user_id']);


$validate->validate([
    'quantity' => "required|min:1|number|lessThan:products,quantity_available,".$_POST['id'],
    'id' => "required|min:1|number|exists:products,id"
]);

if ($validate->errors()) {
    Response::json(['errors' => $validate->errors()], ResponseCode::UNPROCESSABLE_ENTITY);
};



$userID = $user['id'];
$productID = $products['id'];
$storeID = $store['id'];
$orderID = "ORD-$storeID-$userID-$productID-".uniqid()."-".time();
$totalPrice = $products['price'] * $quantity;

$conn->query("INSERT INTO orders (order_id, user_id, store_id, total_price) VALUES (?, ?, ?, ?)", 
[$orderID, $userID, $storeID, $totalPrice]);

$order = $conn->findbyColumn('orders', 'order_id', $orderID);

$conn->query("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)", 
[$order['id'], $productID, $quantity, $totalPrice]);

$conn->query("UPDATE products SET quantity_available = ? WHERE id = ?", [$products['quantity_available'] - $quantity, $productID]);

Response::json(['message' => 'Product Bought'], ResponseCode::OK);















