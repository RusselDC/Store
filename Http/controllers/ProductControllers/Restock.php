<?php
 
use Core\App;
use Core\Database;

use Core\InputRules;
use Core\Response;
use Core\ResponseCode;
$validate = new InputRules();
$conn = App::resolve(Database::class);






$id = $_POST['id'];
$quantity = $_POST['quantity'];
$date = $_POST['date'];


$validate->validate([
    'id' => "required|min:1|number|exists:products,id",
    'quantity' => "required|min:1|number",
    'date' => "required|date"
]);

if ($validate->errors()) {
    Response::json(['errors' => $validate->errors()], ResponseCode::UNPROCESSABLE_ENTITY);
};


$conn->query("UPDATE products SET quantity = quantity + ? WHERE id = ?", [$quantity, $id]);
$conn->query("INSERT INTO restocks (product_id, quantity, restock_date) VALUES (?, ?, ?)", [$id, $quantity, $date]);

Response::json(['message' => 'Product Restocked'], ResponseCode::OK);






