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
        $today = date('m/d/Y');


        $storedSchedules = Schedule::readScheduleFile();
        $theDates = array_keys($storedSchedules);

        foreach ($theDates as $date)
        {
            $current = date('m/d/Y', strtotime($date));
            if ($current == $today)
            {
                // execute the task
                Schedule::processScheduleTasks($storedSchedules[$date][0]);


                // send notification email
                $attachment = isset($storedSchedules[$date][0]['attachment']) ?
                    file_exists($storedSchedules[$date][0]['attachment']) ? $storedSchedules[$date][0]['attachment'] :
                        false : null;

                Mailer::send('emails.batch_confirmation', ['name' => $storedSchedules[$date][0]['name'],
                    'action' => $storedSchedules[$date][0]['action'],
                    'attachment' => $attachment], function (Message $m) use ($storedSchedules, $attachment, $date)
                {
                    $to = \Config::get('app.eMailIT');
                    $subject = \Config::get('app.subjectBatchPrefix') . $storedSchedules[$date][0]['action'] . ' - ' . $storedSchedules[$date][0]['name'];
                    $m->to($to, null)->subject($subject);
                    if ($attachment)
                    {
                        $m->attach($attachment);
                    }
                });

                // delete the task
                unset($storedSchedules[$date]);
                Schedule::saveFile($storedSchedules);
            }
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
