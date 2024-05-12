<?php

namespace Core\Middleware;
use Core\Database;
use Core\App;


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
        if(!$token)
        {
            exit(json_encode(['error' => 'Invalid Request']));
        }

        $userID =  $conn->query("SELECT user_id FROM `auth_token` WHERE token = ?", [$token])->fetch();

        if(!$userID)
        {
            exit(json_encode(['error' => 'Unauthorized']));
        }

    }

}