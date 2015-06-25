<?php
/**
 * Created by PhpStorm.
 * User: rafag
 * Date: 6/24/2015
 * Time: 15:35
 */

namespace app\Http\Controllers;


class Schedule extends Controller
{


    public static function addSchedule($dueDate, $samaccountname, $deactivate, $groups)
    {
        //load the file

        $schedule[$dueDate][] = ['samaccountname' => $samaccountname, 'deactivate' => $deactivate, 'groups' => $groups];

        return Schedule::saveFile($schedule);

    }

    private function saveFile($content)
    {
        //load the file
        $myFile = \Config::get('app.schedule_batch');
        $fileHandle = fopen($myFile, "w");

        fwrite($fileHandle, json_encode($content));
        fclose($fileHandle);
    }

    public static function checkDueDate()
    {
        $today = date('m/d/Y');
        $savedSchedules = Schedule::readScheduleFile();

        if (isset($savedSchedules[$today]))
        {
            return Schedule::processScheduleTasks($savedSchedules);

        }

        return false;
    }

    private static function readScheduleFile()
    {

        $myFile = \Config::get('app.schedule_batch');
        $fileContent = file_get_contents($myFile);

        return json_decode($fileContent, true);
    }

    private static function processScheduleTasks($content)
    {

        $today = date('m/d/Y');
        foreach ($content[$today] as $item)
        {
            echo $item['samaccountname'] . '<br>';
        }

    }
}