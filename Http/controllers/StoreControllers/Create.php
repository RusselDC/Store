<?php

use Core\App;
use Core\Database;
use Core\InputRules;
$conn = App::resolve(Database::class);
$validate = new InputRules();
$token = getallheaders()['token'];

$authToken = $conn->query("SELECT * FROM `auth_token` WHERE token = ?", [$token])->fetch();



$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$address = $_POST['address'] ?? null;
$phone = $_POST['phone'] ?? null;

$rules = [
    'name' => "required|min:3|max:255|unique:stores,name|string",
    'email'=> "required|min:3|max:255|unique:stores,email|email",
    'address' => "required|min:3|max:255|string",
    'phone' => "required|min:3|max:255|string|unique:stores,phone"
];


$validate->validate($rules);

if ($validate->errors()) {
    exit(json_encode($validate->errors()));
}
$user = $conn->find('users', $authToken['user_id']);

if($user['is_seller'] != 1){
    $conn->query("UPDATE `users` SET `is_seller`= ? WHERE `id` = ?", [1,$authToken['user_id']]);
}

$conn->query("INSERT INTO `stores` (name, email, address, phone, user_id) VALUES (?, ?, ?, ?, ?)", [$name, $email, $address, $phone, $authToken['user_id']]);

exit(json_encode(['success' => 'Store created successfully']));







