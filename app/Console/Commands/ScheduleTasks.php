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
            echo 'aqui';
            die;
            Mailer::send('emails.bathumch_confirmation', ['name' => $taskInfo['name'], 'action' => $taskInfo['action'],
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
