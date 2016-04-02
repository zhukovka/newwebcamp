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
        $courseinfo = DB::getArray("
          SELECT shedule.start as course_start, course.name as course_name, modifiers.name as modifier FROM shedule
          JOIN course ON shedule.course_id=course.id
          JOIN modifiers ON shedule.modifier=modifiers.id
          WHERE shedule.modifier={$data["modifier_id"]} AND course.id={$data["course_id"]}
          ");
        $msg = '
                Имя: ' . $data["name"] . '\n
                Телефон: ' . $data["phone"] . '\n
                Курс:' . $courseinfo . '\n
                Как нашли: ' . $data["how"] . '\n
                Комментарий: ' . $data["comment"] . '\n
                ';

        $headers = "Content - type: text / html; charset = utf - 8 \r\n"; //Кодировка письма
        $headers .= 'From: Отправитель <' . $_POST['email'] . '>\r\n'; //Наименование и почта отправителя
        mail($to, $subj, $msg, $headers); //Отправка письма с помощью функции mail

    }
}