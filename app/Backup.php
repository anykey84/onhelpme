<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Backup extends Model
{
    static function getFileList(){

        set_time_limit(300);

        $now = new DateTime('now');
        $timeStamp = $now->getTimestamp();

        if(!DB::table('filelist')->count()){
            $login = 'foxycoder@yandex.ru';
            $secret = 'Mh49b8fgjPVtoqsB6AGa';

            //$xed = XED::encrypt('peqof0xX', $secret);
            //$xed = XED::decrypt('a1loV29VZVttZ1wvSz1TNgdwKRkpEyIVLR4rHS8', $secret);


            $url = "http://testwp.onhelp.me/sbackup.php";

            $post_data = array (
                "action" => "getFileList",
            );

            $output = Backup::queryToService($url, $post_data);

            if($output && strpos($output, "|")){
                $output = explode("|", $output);

                $filesSize = 0;
                $filesCount = 0;
                $totalSize = 0;
                $totalCount = 0;
                $filesstring = '';
                //DB::table('filelist')->truncate();

                foreach($output as $file){
                    if($file != ''){
                        list($name, $size) = explode(";", $file, 2);
                    }

                    if($filesCount < 700 && $filesSize < 300000000){
                        $filesstring .= $file."|";
                        $filesSize += $size;
                        $filesCount++;
                        $totalSize += $size;
                        $totalCount++;
                    } else {
                        Backup::writeDB(substr($filesstring, 0, -1), $filesSize, $filesCount, $timeStamp);
                        $filesSize = 0;
                        $filesCount = 0;
                        $filesstring = '';
                    }
                }

                if($filesCount > 0){
                    $totalSize += $filesSize;
                    $totalCount += $filesCount;
                    Backup::writeDB(substr($filesstring, 0, -1), $filesSize, $filesCount, $timeStamp);
                }

                DB::table('backupLog')->insert(
                    ['message' => "Задания добавлены: ".($totalCount)." файлов, ".($totalSize)." байт",
                        'created_at'  => new DateTime('now'), 'updated_at'  => new DateTime('now')]
                );

                $endTime = new DateTime("now");
                return ($endTime->getTimestamp()-$timeStamp);
            } elseif(!strpos($output, "|")){
                return $output;
            } else {
                return 'no response';
            }

        } else {
            Backup::backup();
        }

    }

    static function queryToService($url, $data){
        self::logDB("Обращение к сервису");

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);

        $output = curl_exec($ch);

        curl_close($ch);

        $output ? self::logDB("Получен ответ от сервиса") : self::logDB("Ответ от сервиса не получен");


        return ($output);
    }

    static function writeDB($name, $size, $count = 0, $archiveName = "", $status = "new"){
        $result = DB::table('filelist')->insert(
            ['name' => substr($name, 0, -1), 'size' => $size, 'status' => $status, 'archiveName' => $archiveName]
        );

        $now = new DateTime('now');

        if(!$result){
            DB::table('backupLog')->insert(
                ['message' => "Ошибка добавления задания: ".($count)." файлов, ".($size)." байт",
                    'created_at'  => $now, 'updated_at'  => $now]
            );
        }
    }

    static function logDB($message){
        DB::table('backupLog')->insert(
            ['message' => $message,
                'created_at'  => new DateTime('now'), 'updated_at'  => new DateTime('now')]
        );
    }

    static function backup($timelimit = 20){

        set_time_limit(300);

        while($timelimit > 0){
            if(DB::table('filelist')->count()){

                $job = DB::table('filelist')->first();

                if($job->status == "new") {
                    self::logDB("Задание " . $job->id . " запущено");
                    DB::table('filelist')
                        ->where('id', $job->id)
                        ->update(['status' => "work"]);

                    $arr = explode("|", $job->name);
                    $files = [];
                    foreach ($arr as $file) {
                        $fileArr = explode(";", $file);
                        if(count($fileArr) == 2){
                            $files[] = ["name" => $fileArr[0], "size" => $fileArr[1]];
                        }
                    }
                    //dd(json_encode($files));

                    $url = "http://testwp.onhelp.me/sbackup.php";

                    $post_data = array(
                        "action" => "backup",
                        "data" => json_encode($files),
                        "archiveName" => $job->archiveName
                    );

                    $output = Backup::queryToService($url, $post_data);

                    if ($output > 0) {
                        DB::table('filelist')->where('id', '=', $job->id)->delete();
                        $timelimit -= $output;
                        Backup::logDB("Задание {$job->id} выполнено за {$output} секунд");
                        if (!DB::table('filelist')->count()) {
                            self::writeDB($job->archiveName, "", 1, $job->archiveName, "created");
                            self::logDB("Архив {$job->archiveName} создан");
                        }


                    } else {
                        self::logDB("Ошибка при выполнении задания {$job->id}: {$output}");

                        DB::table('filelist')
                            ->where('id', $job->id)
                            ->update(['status' => "new"]);

                        $timelimit = 0;
                    }


                } elseif($job->status == "created") {
                    self::logDB("Отправка архива в облако");
                    $timelimit = 0;
                    return "send";


                } else {
                    self::logDB("Задание не выполнено. Не закончено другое задание");
                    DB::table('filelist')
                        ->where('id', $job->id)
                        ->update(['status' => "new"]);

                    if($timelimit > 0){
                        sleep(2);
                        $timelimit -= 2;
                    }

                }

            } else {
                $timelimit = 0;
            }

        }

    }

}
