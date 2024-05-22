<?php

use Core\App;
use Core\Database;
use Core\Response;
use Core\ResponseCode;


$conn = App::resolve(Database::class);
use Core\InputRules;
$validate = new InputRules();
$token = getallheaders()['token'];



$name = $_POST['name'] ?? null;
$description = $_POST['description'] ?? null;
$price = $_POST['price'] ?? null;
$image = (!empty($_FILES['image'])) ? $_FILES['image'] : "default.png";
$quantity = $_POST['quantity'] ?? null;
$store_id = $_POST['store_id'] ?? null;

$validate->validate([
    'name' => "required",
    'description' => "required",
    'price' => "required|float",
    'quantity' => "required|number",
    'image' => "required|image",
    'store_id' => "required|number|exists:store,id"
]);

if($validate->errors())
{
    Response::json(['errors' => $validate->errors()], ResponseCode::UNPROCESSABLE_ENTITY);
}


if($_FILES['image'])
{
    $timestamp = time();
    $originalFilename = $_FILES['image']['name'];
    $extension = pathinfo($originalFilename, PATHINFO_EXTENSION);
    $newFilename = "IMG-$timestamp.$extension";
    $tempLocation = $_FILES['image']['tmp_name'];
    $targetDir = "Images/";
    $targetPath = $targetDir . $newFilename;
    move_uploaded_file($tempLocation, $targetPath);
    $image = $newFilename;
}


$conn->query("INSERT INTO `products`(`name`, `description`, `price`, `image`, `quantity_available`, `store_id`) VALUES (?,?,?,?,?,?)", [$name, $description, $price, $image, $quantity, $store_id]);

Response::json(['message' => 'Product Created'], ResponseCode::CREATED);



