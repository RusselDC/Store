<?php

use Core\App;
use Core\Database;
use Http\Forms\ProductForm;
$conn = App::resolve(Database::class);
$productForm = new ProductForm();
$token = getallheaders()['token'];



$name = $_POST['name'] ?? null;
$description = $_POST['description'] ?? null;
$price = $_POST['price'] ?? null;
$image = (!empty($_FILES['image'])) ? $_FILES['image'] : "default.png";
$quantity = $_POST['quantity'] ?? null;



$validated = $productForm->validate($name, $description, $quantity, $price);

if(!empty($validated))
{
    exit(json_encode($validated));
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



