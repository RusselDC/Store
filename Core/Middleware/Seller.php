<?php 

namespace Core\Middleware;
use Core\Database;
use Core\App;
use Core\User;


class Seller 
{
    private function getConnection()
    {
        return App::resolve(Database::class);
    }

    public function handle()
    {
        $conn = $this->getConnection();
        $token = getallheaders()['token'] ?? null;
        if(!$token)
        {
            exit(json_encode(['error' => 'Invalid Request']));
        }

        $userID =  $conn->query("SELECT user_id FROM `auth_token` WHERE token = ?", [$token])->fetch();

        if(!$userID)
        {
            exit(json_encode(['error' => 'Unauthorized']));
        }

        $user = $conn->query("SELECT * FROM `users` WHERE id = ?", [$userID['user_id']])->fetch();

        if($user['is_seller'] == 0)
        {
            exit(json_encode(['error' => 'Only Seller Here']));
        }

        User::Auth($user);
    }
}