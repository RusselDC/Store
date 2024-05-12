<?php
 
use Core\App;
use Core\Database;
use Http\Forms\RestockForm;

$conn = App::resolve(Database::class);
$restockForm = new RestockForm();





$id = $_GET['id'];
$quantity = $_POST['quantity'];
$date = $_POST['date'];

if(!$id){
    exit(json_encode(['error' => 'Product ID is required']));
}

$validate = $restockForm->validate($quantity,$date);
if(!empty($validate)){
    exit(json_encode($validate));
}

$checkProduct = $restockForm->checkProduct($id);

if(!empty($checkProduct)){
    exit(json_encode($checkProduct));
}

$conn->query("UPDATE products SET quantity = quantity + ? WHERE id = ?", [$quantity, $id]);
$conn->query("INSERT INTO restocks (product_id, quantity, restock_date) VALUES (?, ?, ?)", [$id, $quantity, $date]);

exit(json_encode(['success' => 'Product restocked successfully']));






