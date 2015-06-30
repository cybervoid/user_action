<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: rafag
 * Date: 5/27/15
 * Time: 9:45 AM
 */


use Illuminate\Http\Request;

class MyMail extends Controller
{


    /*
 * Organize the list of recepients
 */
    static public function emailRecipients(Request $req)
    {

        //       $ccRecipients['rafael.gil@illy.com'] = 'rafael.gil@illy.com';


        $ccRecipients[\Config::get('app.eMailHRAdd')] = \Config::get('app.eMailHRAdd');


        $iTDeptEmail = $req->request->get('iTDeptEmail');
        if (isset($iTDeptEmail))
        {
            $ccRecipients[\Config::get('app.eMailIT')] = \Config::get('app.eMailIT');
        }

        $oracle = $req->request->get('oracle');
        if (isset($oracle))
        {
            $ccRecipients[\Config::get('app.eMailOracle')] = \Config::get('app.eMailOracle');
        }

        $oManager = $req->request->get('oManager');
        if (isset($oManager))
        {
            $ccRecipients[\Config::get('app.eMailManagement')] = \Config::get('app.eMailManagement');
            $ccRecipients[\Config::get('app.eMailManagement1')] = \Config::get('app.eMailManagement1');
        }

        $creditCard = $req->request->get('creditCard');
        if (isset($creditCard))
        {
            $ccRecipients[\Config::get('app.eMailFinanceCreditCard')] = \Config::get('app.eMailFinanceCreditCard');
        }

        $newDriver = $req->request->get('newDriver');
        if (isset($newDriver))
        {
            $ccRecipients[\Config::get('app.eMailFinanceDrivers')] = \Config::get('app.eMailFinanceDrivers');
        }


        // Per Maren's request include Stacey when we hire Sales Person
        if ($req->request->get('department') == 'Sales')
        {
            $ccRecipients['Stacey.Berger@illy.com'] = 'Stacey.Berger@illy.com';
        }

        // Per Maren's request include lisa Gutman in all the requests
        $ccRecipients['Lissa.Guttman@illy.com'] = 'Lissa.Guttman@illy.com';

        //Add the manager's email in the recipients list
        if ($req->request->get('managerEmail') != '')
        {
            $ccRecipients[$req->request->get('managerEmail')] = $req->request->get('managerEmail');
        }

        return $ccRecipients;
    }

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

        /*
        if (env('APP_ENV' != 'live'))
        {
            $mailer->SMTPDebug = 2; // enables SMTP debug information (for testing)
        }
        else
        {
            $mailer->SMTPDebug = 0;
        } // enables SMTP debug information (for testing)
        */
        $mailer->Debugoutput = 'html';

        $mailer->SMTPAuth = true; // enable SMTP authentication
        $mailer->Port = 25; // set the SMTP port for the GMAIL server
        $mailer->Username = "illy\hrdept"; // SMTP account username // $mailer->Username =
        $mailer->Password = "Illy4559"; // SMTP account password
        $mailer->SMTPSecure = 'tls';
        $mailer->SMTPAuth = true;
        $mailer->CharSet = "UTF-8";
        $mailer->Timeout = 60;
        $mailer->setFrom("hrdeptnorthamerica@illy.com", "illy NA HR Notifications");
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
        if ($attachment != '')
        {
            $mailer->addAttachment($attachment);
        }

        return $mailer->send();

    }


}