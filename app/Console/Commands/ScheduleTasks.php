<?php namespace App\Console\Commands;

use App\Http\Controllers\Schedule;
use App\Services\Mailer;
use Illuminate\Console\Command;
use Illuminate\Mail\Message;
use Symfony\Component\Console\Input\InputOption;

class ScheduleTasks extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'schdl_batch:check';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for Schedules Tasks to be ran in the AD';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        //
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */

    public function handle()
    {
        //$this->info('Display this on the screen');


        $taskInfo = Schedule::checkDueDate();

        $attachment = isset($taskInfo['attachment']) ?
            file_exists($taskInfo['attachment']) ? $taskInfo['attachment'] : false : null;

        if ($taskInfo)
        {
            Mailer::send('emails.batch_confirmation', ['name' => $taskInfo['name'], 'action' => $taskInfo['action'],
                'attachment' => $attachment], function (Message $m) use ($taskInfo, $attachment)
            {
                $to = \Config::get('app.eMailIT');
                $subject = \Config::get('app.subjectBatchPrefix') . $taskInfo['action'] . ' - ' . $taskInfo['name'];
                $m->to($to, null)->subject($subject);
                if ($attachment)
                {
                    $m->attach($attachment);
                }
            });
        }
        else
        {
            echo 'no info to process';
        }

    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],];
    }
}


/*
 *         $domain = 'illy-domain.com';
        $from_address = "Illy Roaming Service Desk <user1@illy.com>";
        $from_name = "Illy Roaming Service Desk";
        $attendee = "Rafael Gil <rafael.gil@illy.com> , Forster Roy <Roy.Forster@illy.com>";
        $description = 'This is a test';
        $subject = 'This is the subject';
        $location = "Rye Brook Office";


        $startTime = date('m/d/Y') . " 10:30:00";
        $endTime = date('m/d/Y') . " 10:45:00";

        //Create Email Headers
        $mime_boundary = "----Meeting Booking----".MD5(TIME());


        Mailer::send('emails.ical', ['mime_boundary' => $mime_boundary], function (Message $m) use ($mime_boundary)
        {
            $subject = 'This is the subject';
            $m->to('rafael.gil@illy.com', null)->subject($subject);
            $m->getSwiftMessage()->getHeaders()->addTextHeader("From: Rafael Gil\n");
            $m->getSwiftMessage()->getHeaders()->addTextHeader("Reply-To: rafael.gil@illy.com\n");
            $m->getSwiftMessage()->getHeaders()->addTextHeader("MIME-Version: 1.0\n");
            $m->getSwiftMessage()->getHeaders()->addTextHeader("Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n");
            $m->getSwiftMessage()->getHeaders()->addTextHeader("Content-class: urn:content-classes:calendarmessage\n");




        });
 */