<?php namespace App\Http\Controllers;
/**
 * Created by PhpStorm.
 * User: rafag
 * Date: 6/24/2015
 * Time: 15:35
 */

use App\Services\ActiveDirectory;

class Schedule extends Controller
{

    public static function checkDueDate()
    {
        $today = date('m/d/Y');
        $savedSchedules = Schedule::readScheduleFile();

        if (isset($savedSchedules[$today]))
        {
            $result = array('name' => $savedSchedules[$today][0]['name'],
                'action' => $savedSchedules[$today][0]['action'],
                'attachment' => $savedSchedules[$today][0]['attachment']);
            Schedule::processScheduleTasks($savedSchedules);
            unset($savedSchedules[$today]);

//            Schedule::saveFile($savedSchedules);
            return $result;
        }

        return false;
    }

    private static function readScheduleFile()
    {

        if (file_exists(\Config::get('app.schedule_batch')))
        {
            $myFile = \Config::get('app.schedule_batch');
            $fileContent = file_get_contents($myFile);

            return json_decode($fileContent, true);
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $content
     */
    private static function processScheduleTasks($content)
    {
        $today = date('m/d/Y');
        echo $content[$today][0]['action'];
        switch ($content[$today][0]['action'])
        {
            case "reminder":
                Schedule::reminders($content);
                break;
            case "separation":
                Schedule::separations($content);
                break;
        }
        die;

    }

    private static function reminders($content)
    {
        $today = date('m/d/Y');

    }

    private static function separations($content)
    {
        $today = date('m/d/Y');

        foreach ($content[$today] as $item)
        {
            $ad = ActiveDirectory::get_connection();
            $ad->disableUser($item['samaccountname']);
            $ad->removeUserInfo($item['samaccountname']);

            if (count($item['groups']) > 0)
            {
                ActiveDirectory::removeFromGroups($item['groups'], $item['samaccountname']);
            }
        }
    }

    public static function addSchedule($dueDate, $samaccountname, $name, $action, $deactivate, $reportPath, $groups)
    {
        //load the file
        $schedule = Schedule::readScheduleFile();


        $schedule[$dueDate][] = ['samaccountname' => $samaccountname, 'name' => $name, 'action' => $action,
            'deactivate' => $deactivate, 'attachment' => $reportPath, 'groups' => $groups];

        return Schedule::saveFile($schedule);

    }

    private static function saveFile($content)
    {
        //load the file
        $myFile = \Config::get('app.schedule_batch');
        $fileHandle = fopen($myFile, "w");


        fwrite($fileHandle, json_encode($content));
        fclose($fileHandle);
    }
}