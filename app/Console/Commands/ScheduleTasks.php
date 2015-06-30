<?php namespace App\Console\Commands;

use App\Http\Controllers\MyMail;
use App\Http\Controllers\Schedule;
use Illuminate\Console\Command;
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
        $body = 'The following event has taken place for the HR Tool today ' . date('m/d/Y H:i') . ' for the user ' . $taskInfo['name'] . ' and the request is a ' . $taskInfo['action'] . '<br>reference document is attached.';
        $subject = 'HR Tool Action taken for ' . $taskInfo['action'] . ' - ' . $taskInfo['name'];
        $attachment = '';
        if (file_exists($taskInfo['attachment']))
        {
            $attachment = $taskInfo['attachment'];
        }
        MyMail::send_mail('rafael.gil@illy.com', '', $subject, $body, $attachment);
        $this->info($body);

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
