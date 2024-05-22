<?php
use Core\Validator;
use Core\App;
use Core\Database;
use Core\Response;
use Core\ResponseCode;
use Core\InputRules;

try
{
    $conn = App::resolve(Database::class);
    $validate = new InputRules();
    
    $rules = 
    [
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|max:16',
        'password_confirmation' => 'required|same:password',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'phone' => 'required|number|min:10|max:11|unique:profile,phone',
        'address' => 'required|string',
    ];
    
    $validate->validate($rules);
    if($validate->errors()){
        Response::json(['errors' => $validate->errors()], ResponseCode::UNPROCESSABLE_ENTITY);
    }
    
    $emailResult = $conn->query("SELECT * FROM users WHERE email = ?", [$_POST['email']])->fetch();

    $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
    $conn->query("INSERT INTO `users`(`email`, `password`) VALUES (?,?)",[ $_POST['email'], $hash]);
    
    $id = $conn->query("SELECT id FROM users WHERE email = ?", [$_POST['email']])->fetch();
    
    
    $conn->query("INSERT INTO `profile`(`first_name`, `last_name`, `phone`, `address`, `user_id`) VALUES (?,?,?,?,?)",
        [$_POST['first_name'], $_POST['last_name'], $_POST['phone'], $_POST['address'], $id['id']]);
    
   Response::json(['message' => 'User Registered'], ResponseCode::CREATED);
    
    
    
}catch(Exception $e){
    Response::json(['error' => $e->getMessage()], ResponseCode::INTERNAL_SERVER_ERROR);
}
