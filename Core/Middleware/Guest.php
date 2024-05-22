<?php

namespace Core\Middleware;

use Core\Database;
use Core\App;
use Core\User;
use Core\Response;
use Core\ResponseCode;

class Guest
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

        $userID =  $conn->query("SELECT user_id FROM `auth_token` WHERE token = ?", [$token])->fetch();

        if($userID)
        {
            Response::json(['error' => 'Unauthorized'], ResponseCode::UNAUTHORIZED);
        }
    }
}