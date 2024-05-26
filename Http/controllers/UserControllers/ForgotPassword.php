<?php 



use Core\Database;
use Core\App;
use Core\Jobs\SendForgotEmail;
use Core\Response;
use Core\ResponseCode;
use Core\InputRules;
use Core\Mail;

$conn = App::resolve(Database::class);


$validate = new InputRules();
$rules = [
    'email' => 'required|email|exists:users,email'
];
$validate->validate($rules);

if ($validate->errors())
{
    Response::json(['errors' => $validate->errors()], ResponseCode::UNPROCESSABLE_ENTITY);
   
}


$token = bin2hex(random_bytes(50));


$user = $conn->findbyColumn('users', 'email', $_POST['email']);

$conn->insert('forgot_password', [
    'user_id' => $user['id'],
    'token' => $token
]);

Mail::to($user['email'])
    ->subject('Reset Password')
    ->body('Click <a href="http://localhost:8000/reset-password?token=' . $token . '">here</a> to reset your password')
    ->send();




Response::json(['message' => 'Email sent'], ResponseCode::OK);

?>
