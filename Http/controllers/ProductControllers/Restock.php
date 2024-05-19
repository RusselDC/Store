<?php
 
use Core\App;
use Core\Database;

use Core\InputRules;
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
    exit(json_encode(['error' => $validate->errors()]));
};


$conn->query("UPDATE products SET quantity = quantity + ? WHERE id = ?", [$quantity, $id]);
$conn->query("INSERT INTO restocks (product_id, quantity, restock_date) VALUES (?, ?, ?)", [$id, $quantity, $date]);

exit(json_encode(['success' => 'Product restocked successfully']));






