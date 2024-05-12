<?php
use Core\Validator;
use Core\App;
use Core\Database;
use Http\Forms\RegisterForm;
$conn = App::resolve(Database::class);
$register = new RegisterForm();

$postData  = array(
    'email' => $_POST['email'] ?? null,
    'password' => $_POST['password'] ?? null,
    'password_confirmation' => $_POST['password_confirmation'] ?? null,
    'first_name' => $_POST['first_name'] ?? null,
    'last_name' => $_POST['last_name'] ?? null,
    'phone' => $_POST['phone'] ?? null,
    'address' => $_POST['address'] ?? null,
);



$validation = $register->validator(
    $postData['email'],
    $postData['password'],
    $postData['password_confirmation'],
    $postData['first_name'],
    $postData['last_name'],
    $postData['phone'],
    $postData['address']
);

if (count($validation) > 0) {
    exit(json_encode($validation));
}

$emailResult = $conn->query("SELECT * FROM users WHERE email = ?", [$postData['email']])->fetch();

if ($emailResult) {
    exit(json_encode(['email' => 'Email already exists']));
}

$hash = password_hash($postData['password'], PASSWORD_BCRYPT);


$conn->query("INSERT INTO `users`(`email`, `password`) VALUES (?,?)",[ $postData['email'], $hash]);

$id = $conn->query("SELECT id FROM users WHERE email = ?", [$postData['email']])->fetch();

$id['id'];

$conn->query("INSERT INTO `profile`(`first_name`, `last_name`, `phone`, `address`, `user_id`) VALUES (?,?,?,?,?)",
    [$postData['first_name'], $postData['last_name'], $postData['phone'], $postData['address'], $id['id']]);

exit(json_encode(['success' => 'User registered successfully']));


