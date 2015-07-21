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



    /**
     * @param $content
     * content is the array witht he information for the schedule
     *
     * @return bool|void
     */
    public static function processScheduleTasks($content)
    {

        switch ($content['action'])
        {
            case "reminder":
                return Schedule::reminders($content);
                break;
            case "separation":
                return Schedule::separations($content);
                break;
        }

        return false;
    }

    private static function reminders($content)
    {
        $today = date('m/d/Y');

    }

    private static function separations($content)
    {
        $ad = ActiveDirectory::get_connection();
        $ad->disableUser($content['samaccountname']);
        $ad->removeUserInfo($content['samaccountname']);
        if (count($content['groups']) > 0)
        {
            $ad->removeFromGroups($content['groups'], $content['samaccountname']);
        }
    }

    public static function addSchedule($dueDate, $samaccountname, $name, $action, $deactivate, $reportPath, $groups)
    {
        //load the file
        $schedule = Schedule::readScheduleFile();

        $schedule[$dueDate . date(' h:i:s a')][] = ['samaccountname' => $samaccountname, 'name' => $name,
            'action' => $action,
            'deactivate' => $deactivate, 'attachment' => $reportPath, 'groups' => $groups];

        return Schedule::saveFile($schedule);

    }

    public static function readScheduleFile()
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

    public static function saveFile($content)
    {
        //load the file
        $myFile = \Config::get('app.schedule_batch');
        $fileHandle = fopen($myFile, "w");

        fwrite($fileHandle, json_encode($content));
        fclose($fileHandle);
    }

}