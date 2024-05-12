<?php

namespace Http\Forms;

use Core\Validator;
use Core\App;
use Core\Database;

class CreateStoreForm
{
    protected $error = [];
    protected $conn;

    public function __construct()
    {
        $this->conn = App::resolve(Database::class);
    }
    public function validate($name, $email, $address, $phone)
    {
        if(Validator::string($name))
        {
            $this->error['name'] = "PLEASE PROVIDE A NAME";
        }

        if(Validator::string($email))
        {
            $this->error['email'] = "PLEASE PROVIDE AN EMAIL";
        }

        if(Validator::string($address))
        {
            $this->error['address'] = "PLEASE PROVIDE AN ADDRESS";
        }

        if(Validator::string($phone))
        {
            $this->error['phone'] = "PLEASE PROVIDE A PHONE";
        }

        if(Validator::length($name, 20))
        {
            $this->error['name'] = "ONLY INSERT A NAME OF NO MORE THAN 20 CHARACTERS";
        }

        if(Validator::length($email, 40))
        {
            $this->error['email'] = "ONLY INSERT AN EMAIL OF NO MORE THAN 40 CHARACTERS";
        }

        if(Validator::min($email))
        {
            $this->error['name'] = "INSERT A NAME OF NO LESS THAN 8 CHARACTERS";
        }

        if(Validator::min($phone))
        {
            $this->error['phone'] = "INSERT A PHONE OF NO LESS THAN 8 CHARACTERS";
        }

        if(Validator::number($phone))
        {
            $this->error['phone'] = "PLEASE PROVIDE A VALID PHONE NUMBER";
        }

        return $this->error;
    }

    public function email($email)
    {
        $usedEmail = $this->conn->query("SELECT * FROM `stores` WHERE email = ?", [$email])->fetch();
        if($usedEmail)
        {
            $this->error['email'] = "EMAIL ALREADY IN USE";
        }

        return $this->error;
    }

    public function name($name)
    {
        $usedName = $this->conn->query("SELECT * FROM `stores` WHERE name = ?", [$name])->fetch();
        if($usedName)
        {
            $this->error['name'] = "NAME ALREADY IN USE";
        }

        return $this->error;
    }

    public function phone($phone)
    {
        $usedPhone = $this->conn->query("SELECT * FROM `stores` WHERE phone = ?", [$phone])->fetch();
        if($usedPhone)
        {
            $this->error['phone'] = "PHONE ALREADY IN USE";
        }

        return $this->error;
    }


}