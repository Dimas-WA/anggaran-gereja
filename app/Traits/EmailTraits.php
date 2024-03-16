<?php

namespace App\Traits;

use App\Models\Setting;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
trait EmailTraits
{

    function emailSend($emailuser,$nameuser,$subjectEmail,$bodyEmail)
    {


        $settings = Setting::select('key','value')->get()->pluck('value','key')->toArray();

        $Host = $settings['smtp_host'] ?? '';
        $SMTPAuth = $settings['smtp_auth'] ?? '';
        $Username = $settings['u_email'] ?? '';
        $Password = $settings['p_email'] ?? '';
        $SMTPAutoTLS = $settings['smtp_auto_tls'] ?? '';
        $SMTPSecure = $settings['smtp_secure'] ?? '';
        $Port = $settings['port'] ?? '';


        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = $Host;
        $mail->SMTPAuth = $SMTPAuth;
        $mail->Username   = $Username;                     //SMTP username
        $mail->Password   = $Password;
        $mail->SMTPAutoTLS = $SMTPAutoTLS;
        $mail->SMTPSecure = $SMTPSecure;
        $mail->Port       = $Port;

        $mail->setFrom('compass@compass-tsel.id', 'Compass-Tsel');
        $mail->addReplyTo('compass@compass-tsel.id', 'Compass-Tsel');
        $mail->addAddress($emailuser, $nameuser);

        // $mail->addBcc('dimas_w@id.msig-asia.com', 'Dimas Wisnu Aryadi');
        $mail->isHTML(true);
        $mail->Subject = $subjectEmail;

        $mail->Body = $bodyEmail;

        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if (!$mail->send()) {
            echo 'Mailer Error: '. $mail->ErrorInfo;
            \Log::channel('email')->info($mail->ErrorInfo);
        } else {
            // echo 'Message sent!';
        }

    }




}
