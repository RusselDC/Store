<?php

namespace Http\Forms;

use Core\Validator;

class LoginForm
{
    protected $error = [];
    public function validate($email,$pWord)
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

        return $this->error;

    }

    public function email($val)
    {
        if(!$val)
        {
            $this->error['process'] = "This email was not found";
            return $this->error;
        }
    }

    public function password($pWord,$dbpWord,$email,$id)
    {
        if(password_verify($pWord, $dbpWord))
        {
            login([
                'Email'=>$email,
                'ID'=>$id
            ]);
            echo '<script>window.location.href = "/"</script>';
            exit();
        }else{
            $this->error['process'] = "WRONG PASSWORD";
        }
        return $this->error;
    }
}


