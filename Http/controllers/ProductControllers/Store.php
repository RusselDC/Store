<?php

use Core\App;
use Core\Database;

$conn = App::resolve(Database::class);
use Core\InputRules;
$validate = new InputRules();
$token = getallheaders()['token'];



$name = $_POST['name'] ?? null;
$description = $_POST['description'] ?? null;
$price = $_POST['price'] ?? null;
$image = (!empty($_FILES['image'])) ? $_FILES['image'] : "default.png";
$quantity = $_POST['quantity'] ?? null;

$validate->validate([
    'name' => "required",
    'description' => "required",
    'price' => "required|float",
    'quantity' => "required|number",
    'image' => "required|image"
]);

if($validate->errors())
{
    exit(json_encode(['error' => $validate->errors()]));
}


if($_FILES['image'])
{
    $timestamp = time();
    $originalFilename = $_FILES['image']['name'];
    $extension = pathinfo($originalFilename, PATHINFO_EXTENSION);
    $extensionValidate = $productForm->validatImage($extension);
    if(!empty($extensionValidate))
    {
        exit(json_encode($extensionValidate));
    }
    $newFilename = "IMG-$timestamp.$extension";
    $tempLocation = $_FILES['image']['tmp_name'];
    $targetDir = "Images/";
    $targetPath = $targetDir . $newFilename;
    move_uploaded_file($tempLocation, $targetPath);
    $image = $newFilename;
}


$conn->query("INSERT INTO `products`(`name`, `description`, `price`, `image`, `quantity_available`, `store_id`) VALUES (?,?,?,?,?,?)", [$name, $description, $price, $image, $quantity, 1]);

echo json_encode(['message' => 'Product Created Successfully']);



