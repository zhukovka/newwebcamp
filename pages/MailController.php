<?php
/**
 * Created by PhpStorm.
 * User: Punkor
 * Date: 02.04.2016
 * Time: 20:42
 */
//require_once ROOT . 'pages/ScheduleController.php';
//require_once ROOT . 'pages/CoursesController.php';


class MailController
{
    private static $webcampDomain = "webcamp.com.ua";
    private static $register = "register";
    private static $info = "info";
    private static $manager = "manager";

    public static function registerMail($data)
    {
        $to = self::$register . "@" . self::$webcampDomain;
        $subj = "Заявка на курс";
        $mail = $data["email"];
        $modifier_id = $data["modifier_id"];
        $course_id = $data["course_id"];
        $courseinfo = DB::getArray("SELECT shedule.start as start, course.name as course_name, modifiers.name as modifier_name FROM courseinfo
JOIN modifiers ON modifiers.id = courseinfo.modifier
JOIN course ON course.id = courseinfo.course_id
LEFT JOIN shedule ON shedule.course_id = courseinfo.course_id AND shedule.start > CURDATE() AND shedule.modifier = courseinfo.modifier
WHERE modifiers.id = '{$modifier_id}' AND course.id='{$course_id}'");
        $info = $courseinfo[0]["course_name"] . " " .$courseinfo[0]["course_modifier"]. " .";
        if($courseinfo[0]["start"] != null) {
            $info .= "Стартуем: " . $courseinfo[0]["start"]." ";
        }
        $msg = "
                Имя:\t" . $data["name"] . "\n
                Телефон:\t" . $data["phone"] . "\n
                Курс:\t" . $info . "\n
                Как нашли:\t" . $data["how"] . "\n
                Комментарий:\t" . $data["comment"] . "\n
                ";

        $headers = "Content - type: text / html; charset = utf - 8 \r\n";
        $headers .= "From: Отправитель <" . $mail . ">\r\n";
        mail($to, $subj, $msg, $headers);

    }

}