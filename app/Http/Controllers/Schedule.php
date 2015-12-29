<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: rafag
 * Date: 6/24/2015
 * Time: 15:35
 */

use App\Services\ActiveDirectory;
use App\Services\Mailer;
use Illuminate\Mail\Message;

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
            case "newHire_reminder":
                return Schedule::newHire_reminder($content);
                break;
            case "separation_reminder":
                return Schedule::separation_reminder($content);
                break;
            case "separation":
                return Schedule::separations($content);
                break;
        }

        return false;
    }

    public static function newHire_reminder($content)
    {
        Mailer::send('emails.newHire_reminder', ['name' => $content['name'],
            'samaccountname' => $content['samaccountname'],
            'date' => $content['deactivate']], function (Message $m) use ($content)
        {
            $to = \Config::get('app.eMailIT');
            $subject = \Config::get('app.subjectBatchPrefix') . $content['action'] . ' - ' . $content['name'];
            $m->to($to, null)->subject($subject);

        });
    }

    private static function separation_reminder($content)
    {

        $attachment = isset($content['attachment']) ?
            file_exists($content['attachment']) ? $content['attachment'] : false : null;

        Mailer::send('emails.separation_reminder', ['name' => $content['name'], 'action' => $content['action'],
            'samaccountname' => $content['samaccountname'], 'separationDate' => $content['deactivate'],
            'comment' => $content['groups'],
            'attachment' => $attachment], function (Message $m) use ($content, $attachment)
        {
            $to = \Config::get('app.eMailIT');
            $subject = \Config::get('app.subjectBatchPrefix') . $content['action'] . ' - ' . $content['name'];
            $m->to($to, null)->subject($subject)->cc(\Config::get('app.eMailITManager'));
            if ($attachment)
            {
                $m->attach($attachment);
            }
        });

    }

    private static function separations($content)
    {

        $ad = ActiveDirectory::get_connection();

        $entry = $ad->getsamaccountname($content['samaccountname']);

        if (count($entry) < 2)
        {
            return false;
        }

        $ad->disableUser($entry);
        $ad->removeUserInfo($entry);


        if (count($content['groups']) > 0)
        {
            $ad->removeFromGroups($content['groups'], $entry[0]["dn"]);
        }


        // send notification email

        $attachment = isset($content['attachment']) ?
            file_exists($content['attachment']) ? $content['attachment'] : false : null;

        Mailer::send('emails.separation_batch', ['name' => $content['name'], 'action' => $content['action'],
            'attachment' => $attachment], function (Message $m) use ($content, $attachment)
        {
            $to = \Config::get('app.eMailIT');
            $subject = \Config::get('app.subjectBatchPrefix') . $content['action'] . ' - ' . $content['name'];
            $m->to($to, null)->subject($subject);
            if ($attachment)
            {
                $m->attach($attachment);
            }
        });

    }

    public static function addSchedule($dueDate, $samaccountname, $name, $action, $deactivate, $reportPath, $groups)
    {
        //load the file
        $schedule = Schedule::readScheduleFile();

        $schedule[$dueDate . date(' h:i:s a')][] = ['samaccountname' => $samaccountname, 'name' => $name,
            'action' => $action, 'deactivate' => $deactivate, 'attachment' => $reportPath, 'groups' => $groups];

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