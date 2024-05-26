<?php

namespace Core\Jobs;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Core\Mail;
use Core\JobInterface;

class SendForgotEmail implements JobInterface
{
    protected $to;
    protected $subject;
    protected $body;

    public function __construct($to, $body)
    {
        $this->to = $to;
        $this->subject = "Password Reset";
        $this->body = $body;
    }

    public function handle()
    {
        try
        {
            $mail = new Mail();
            $mail->to($this->to)
                 ->subject($this->subject)
                 ->body($this->body)
                 ->send();
        }
        catch (Exception $e)
        {
            echo "Email failed: " . $e->getMessage() . PHP_EOL;
        }
    }
}

?>
