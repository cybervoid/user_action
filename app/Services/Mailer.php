<?php namespace app\Services;


use Illuminate\Mail\Message;

class Mailer
{

    static public function send($view, $data, $cb)
    {
        \Mail::send($view, $data, function (Message $m) use ($cb)
        {
            $cb($m);

            $to = \Config::get('mail.to');
            if ($to['address'])
            {
                $m->setTo($to['address'], isset($to['name']) ? $to['name'] : '');
            }
        });
    }

}