<?php

use Core\App;
use Core\Database;
use Core\InputRules;
use Core\User;
use Core\Response;
use Core\ResponseCode;
$conn = App::resolve(Database::class);

$validate = new InputRules();
$token = getallheaders()['token'];

try
{
    $user = User::user();
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $address = $_POST['address'] ?? null;
    $phone = $_POST['phone'] ?? null;
    
    $rules = [
        'name' => "required|min:3|max:255|unique:store,name|string",
        'email'=> "required|min:3|max:255|unique:store,email|email",
        'address' => "required|min:3|max:255|string",
        'phone' => "required|min:3|max:255|string|unique:store,phone"
    ];
    
    
    $validate->validate($rules);
    
    if ($validate->errors()) {
        exit(json_encode($validate->errors()));
    }

    if($user['is_store'] != 1){
        $conn->query("UPDATE `users` SET `is_store`= ? WHERE `id` = ?", [1,$user['id']]);
    }
    
    $conn->query("INSERT INTO `store` (name, email, address, phone, user_id) VALUES (?, ?, ?, ?, ?)", [$name, $email, $address, $phone, $user['id']]);
    
    Response::json(['message' => 'Store Created'], ResponseCode::CREATED);
}
catch(Exception $e)
{
    Response::json(['error' => $e->getMessage()], ResponseCode::INTERNAL_SERVER_ERROR);
}








