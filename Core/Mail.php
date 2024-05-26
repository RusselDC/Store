<?php

namespace Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Mail 
{
    protected $to;
    protected $subject;
    protected $body;

    public static function to($to)
    {
        $instance = new self();
        $instance->to = $to;
        return $instance;
    }

    public function subject($subject = "Subject")
    {
        $this->subject = $subject;
        return $this;
    }

    public function body($body = "Body")
    {
        $this->body = $body;
        return $this;
    }

    public function send()
    {
        $mail = new PHPMailer(true);
        try
        {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'dencare2023@gmail.com';
            $mail->Password = '';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('dencare2023@gmail.com', 'Dencare');
            $mail->addAddress($this->to);

            $mail->isHTML(true);    
            $mail->Subject = $this->subject;
            $mail->Body = $this->body;

            $mail->send();

            
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }
}

?>