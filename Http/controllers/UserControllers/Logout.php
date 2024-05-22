<?php 


use Core\App;
use Core\Database;
use Core\User;
use Core\Response;
use Core\ResponseCode;
$conn = App::resolve(Database::class);
$conn->query("DELETE FROM `auth_token` WHERE user_id = ?", [User::user()['id']]);
Response::json(['message' => 'Logged Out'], ResponseCode::OK);

