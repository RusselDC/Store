<?php 


use Core\App;
use Core\Database;
use Core\User;



exit(json_encode(['User'=>User::user()]));

$conn = App::resolve(Database::class);

$id = getallheaders()['token'];


$userID = $conn->query("SELECT user_id FROM `auth_token` WHERE token = ?", [$id])->fetch();
$conn->query("DELETE FROM `auth_token` WHERE user_id = ?", [$userID['user_id']]);
exit(json_encode(['success' => 'Logged out successfully']));

