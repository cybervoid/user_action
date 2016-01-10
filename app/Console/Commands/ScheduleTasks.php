<?php namespace App\Console\Commands;

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
            if (strtotime($current) <= strtotime($today))
            {
                // execute the task
                Schedule::processScheduleTasks($storedSchedules[$date][0]);

                //  delete the task
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
