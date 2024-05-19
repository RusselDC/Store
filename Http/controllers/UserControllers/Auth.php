<?php
use Core\Validator;
use Core\App;
use Core\Database;
use Core\InputRules;
$conn = App::resolve(Database::class);
$validate = new InputRules();


$email = $_POST['email'];
$password = $_POST['password'];


$rules = [
    'email' => 'required|email',
    'password' => 'required|min:6|max:20'
];

if(!$validate->validate($rules)){
    exit(json_encode(['errors'=>$validate->errors()]));
}






$userResult = $conn->query("SELECT * FROM users WHERE email = ?", [$email])->fetch();

if (!$userResult) {
    exit(json_encode(['email' => 'Email not found']));
}

if (!password_verify($password, $userResult['password'])) {
    exit(json_encode(['password' => 'Wrong password']));
}

$profile = $conn->query("SELECT users.email, users.id, profile.* FROM users JOIN profile ON users.id = profile.user_id WHERE users.id = ?
", [$userResult['id']])->fetch();
$token = uniqid();;


$conn->query("INSERT INTO `auth_token`(`user_id`, `token`) VALUES (?,?)",[$userResult['id'], $token]);

exit(json_encode(['success' => 'User logged in successfully', 'profile_data' => $profile, 'token' => $token]));




