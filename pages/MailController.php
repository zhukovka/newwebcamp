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
        $subj = 'Заявка на курс';
        $modifier_id = $data["modifier_id"];
        $course_id = $data["course_id"];
        $courseinfo = DB::getArray("SELECT shedule.start as start, course.name as course_name, modifiers.name as modifier_name FROM courseinfo
JOIN modifiers ON modifiers.id = courseinfo.modifier
JOIN course ON course.id = courseinfo.course_id
LEFT JOIN shedule ON shedule.course_id = courseinfo.course_id AND shedule.start > CURDATE() AND shedule.modifier = courseinfo.modifier
WHERE modifiers.id = '{$modifier_id}' AND course.id='{$course_id}'");
        $msg = '
                Имя: ' . $data["name"] . '\n
                Телефон: ' . $data["phone"] . '\n
                Курс:' . $courseinfo[0]["course_name"] . '\n
                Как нашли: ' . $data["how"] . '\n
                Комментарий: ' . $data["comment"] . '\n
                ';

        $headers = "Content - type: text / html; charset = utf - 8 \r\n";
        $headers .= 'From: Отправитель <' . $data["email"] . '>\r\n';
        mail($to, $subj, $msg, $headers);

    }
}