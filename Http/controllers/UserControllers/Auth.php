<?php
use Core\Validator;
use Core\App;
use Core\Database;
use Core\InputRules;
use Core\Response;
use Core\ResponseCode;
try{
    $conn = App::resolve(Database::class);
    $validate = new InputRules();


$email = $_POST['email'];
$password = $_POST['password'];


$rules = [
    'email' => 'required|email',
    'password' => 'required|min:6|max:20'
];

if(!$validate->validate($rules)){
    Response::json(['errors' => $validate->errors()], ResponseCode::UNPROCESSABLE_ENTITY);
}






$userResult = $conn->query("SELECT * FROM users WHERE email = ?", [$email])->fetch();

if (!$userResult) {
    Response::json(['error' => 'These credentials do not match our records.'], ResponseCode::UNAUTHORIZED);
}

if (!password_verify($password, $userResult['password'])) {
    Response::json(['error' => 'These credentials do not match our records.'], ResponseCode::UNAUTHORIZED);
}

$profile = $conn->query("SELECT users.email, users.id, profile.* FROM users JOIN profile ON users.id = profile.user_id WHERE users.id = ?
", [$userResult['id']])->fetch();
$token = $userResult['id']."|".date("YmdHis").uniqid();


$conn->query("INSERT INTO `auth_token`(`user_id`, `token`) VALUES (?,?)",[$userResult['id'], $token]);

Response::json(['token' => $token, 'user' => $profile, 'message'=>'Logged In'], ResponseCode::OK);

}catch(Exception $e){
    Response::json(['error' => $e->getMessage()], ResponseCode::INTERNAL_SERVER_ERROR);
}




