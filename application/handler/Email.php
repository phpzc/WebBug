<?php


namespace app\handler;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use think\facade\Log;

/**
 * 邮件发送处理
 * Class Email
 * @package app\handler
 */
class Email
{
    public function send($toUserEmail,$name,$title,$content)
    {

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;
            $mail->CharSet ="UTF-8";
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = config('email.host');  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = config('email.username');                     // SMTP username
            $mail->Password   = config('email.password');                               // SMTP password
            $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = config('email.port');                                    // TCP port to connect to

            //Recipients
            $mail->setFrom(config('email.username'), 'WebBug');
            $mail->addAddress($toUserEmail, $name);     // Add a recipient


            // Attachments

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $title;
            $mail->Body    = $content;


            $mail->send();

            return true;
        } catch (Exception $e) {

            Log::info("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }


    }
}