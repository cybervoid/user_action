<?php namespace App\Http\Controllers;
/**
 * Created by PhpStorm.
 * User: rafag
 * Date: 5/27/15
 * Time: 9:45 AM
 */





class Mail extends Controller {

    /**
     * Prepare email basic params to send email
     *
     * @param $to
     * @param $ccRecipients
     * @param $subject
     * @param $body
     * @param $attachment
     *
     * @internal param int $id
     * @return Response
     */

    static public function send_mail($to, $ccRecipients, $subject, $body, $attachment)
    {

        $mailer = new \PHPMailer(true);
        //$mailer->IsSMTP();
        $mailer->Host = "10.44.1.73"; // SMTP server
        $mailer->SMTPDebug = 2; // enables SMTP debug information (for testing)
        $mailer->Debugoutput = 'html';

        $mailer->SMTPAuth = true; // enable SMTP authentication
        $mailer->Port = 25; // set the SMTP port for the GMAIL server
        $mailer->Username = "illy\user1"; // SMTP account username // $mailer->Username =
        $mailer->Password = "Illy2014"; // SMTP account password
        $mailer->SMTPSecure = 'tls';
        $mailer->SMTPAuth = true;
        $mailer->CharSet = "UTF-8";
        $mailer->Timeout = 60;
        $mailer->setFrom("user1@illy.com", "illy NA HR Notifications");
        $mailer->addAddress($to);
        if ($ccRecipients != '')
        {
            foreach ($ccRecipients as $email => $name)
            {
                $mailer->AddCC($email, $name);
            }
        }

        $mailer->Subject = $subject;
        $mailer->Body = $body;
        if($attachment!='') $mailer->addAttachment($attachment);

        return $mailer->send();
    }
}