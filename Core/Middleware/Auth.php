<?php

namespace Core\Middleware;
use Core\Database;
use Core\App;
use Core\User;


class Auth
{
    private function getConnection()
    {
        return App::resolve(Database::class);
    }

    public function handle()
    {   
        $conn = $this->getConnection();
        $token = getallheaders()['token'] ?? null;
        $separated = explode("|", $token);
        $id = $separated[0];
        if(!$token)
        {
            exit(json_encode(['error' => 'Invalid Request']));
        }

        $userID =  $conn->query("SELECT user_id FROM `auth_token` WHERE token = ?", [$token])->fetch();

        if(!$userID)
        {
            exit(json_encode(['error' => 'Unauthorized']));
        }

        if($userID['user_id'] != $id)
        {
            exit(json_encode(['error' => 'Unauthorized']));
        }

        $user = $conn->find('users', $userID['user_id']);

        User::Auth($user);

    }

}