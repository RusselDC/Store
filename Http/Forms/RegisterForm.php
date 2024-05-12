<?php

namespace Http\Forms;
use Core\Validator;

class RegisterForm
{
    protected $error = [];
    public function validator($email,$pWord,$pWordc,$fName,$lName,$phone,$address)
    {
        if(Validator::string($pWord))
        {
            $this->error['password'] = "PLEASE PROVIDE A PASSWORD";
        }
        if(Validator::string($email))
        {
            $this->error['email'] = "PLEASE PROVIDE AN EMAIL";
        }

        if(Validator::length($pWord,20))
        {
            $this->error['password'] = "ONLY INSERT A PASSWORD OF NO MORE THAN 20 CHARACTERS";
        }
        if(Validator::length($email,40))
        {
            $this->error['email'] = "ONLY INSERT AN EMAIL OF MORE THAN 40 CHARACTERS";
        }
        if(Validator::min($pWord))
        {
            $this->error['password'] = "INSERT A PASSWORD OF NO LESS THAN 8 CHARACTERS";
        }
        if(Validator::email($email))
        {
            $this->error['email'] = "PLEASE INSERT A VALID EMAIL";
        }
        if(Validator::match($pWord,$pWordc))
        {
            $this->error['password'] = "PASSWORDS DO NOT MATCH";
        }
        if(Validator::string($fName))
        {
            $this->error['first_name'] = "PLEASE PROVIDE A FIRST NAME";
        }
        if(Validator::string($lName))
        {
            $this->error['last_name'] = "PLEASE PROVIDE A LAST NAME";
        }
        if(Validator::string($phone))
        {
            $this->error['phone'] = "PLEASE PROVIDE A PHONE NUMBER";
        }
        if(Validator::string($address))
        {
            $this->error['address'] = "PLEASE PROVIDE AN ADDRESS";
        }
        if(Validator::number($phone))
        {
            $this->error['phone'] = "PLEASE PROVIDE A VALID PHONE NUMBER";
        }


        return $this->error;
    }

    public function email($email)
    {
        if($email)
        {
            $this->error['process'] = "Email already taken!";
        }
        return $this->error;
    }

    public function log($email,$id)
    {
        login(['Email'=>$email,'ID'=>$id]);
        echo '<script> window.location.href = "/" </script>';
    }

}
