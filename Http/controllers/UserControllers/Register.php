<?php
use Core\Validator;
use Core\App;
use Core\Database;

$conn = App::resolve(Database::class);

use Core\InputRules;
$validate = new InputRules();


$postData  = array(
    'email' => $_POST['email'] ?? null,
    'password' => $_POST['password'] ?? null,
    'password_confirmation' => $_POST['password_confirmation'] ?? null,
    'first_name' => $_POST['first_name'] ?? null,
    'last_name' => $_POST['last_name'] ?? null,
    'phone' => $_POST['phone'] ?? null,
    'address' => $_POST['address'] ?? null,
);


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
    exit(json_encode(['errors'=>$validate->errors()]));
}



$emailResult = $conn->query("SELECT * FROM users WHERE email = ?", [$postData['email']])->fetch();


$hash = password_hash($postData['password'], PASSWORD_BCRYPT);


$conn->query("INSERT INTO `users`(`email`, `password`) VALUES (?,?)",[ $postData['email'], $hash]);

$id = $conn->query("SELECT id FROM users WHERE email = ?", [$postData['email']])->fetch();

$id['id'];

$conn->query("INSERT INTO `profile`(`first_name`, `last_name`, `phone`, `address`, `user_id`) VALUES (?,?,?,?,?)",
    [$postData['first_name'], $postData['last_name'], $postData['phone'], $postData['address'], $id['id']]);

exit(json_encode(['success' => 'User registered successfully']));


