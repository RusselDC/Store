<?php

use Core\App;
use Core\Database;
use Http\Forms\CreateStoreForm;
$storeForm = new CreateStoreForm();
$conn = App::resolve(Database::class);
$token = getallheaders()['token'];

$authToken = $conn->query("SELECT * FROM `auth_token` WHERE token = ?", [$token])->fetch();



$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$address = $_POST['address'] ?? null;
$phone = $_POST['phone'] ?? null;

$validate = $storeForm->validate($name, $email, $address, $phone);

if (!empty($validate)) {
    exit(json_encode($validate));
}

$emailCheck = $storeForm->email($email);

if (!empty($emailCheck)) {
    exit(json_encode($emailCheck));
}

$nameCheck = $storeForm->name($name);

if (!empty($nameCheck)) {
    exit(json_encode($nameCheck));
}

$phoneCheck = $storeForm->phone($phone);

if (!empty($phoneCheck)) {
    exit(json_encode($phoneCheck));
}


$conn->query("UPDATE `users` SET `is_seller`= ? WHERE `id` = ?", [1,$authToken['user_id']]);


$conn->query("INSERT INTO `stores` (name, email, address, phone, user_id) VALUES (?, ?, ?, ?, ?)", [$name, $email, $address, $phone, $authToken['user_id']]);

exit(json_encode(['success' => 'Store created successfully']));







