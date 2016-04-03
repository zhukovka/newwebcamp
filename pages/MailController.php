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
    private static $test = "test";
    private static $header = 'Content-type: text/html; charset=utf-8';

    public static function registerMail($data)
    {
        $to = self::$test . "@" . self::$webcampDomain;
        $subj = "Заявка на курс";
        $mail = $data["email"];
        $modifier_id = $data["modifier_id"];
        $course_id = $data["course_id"];
        $courseinfo = DB::getArray("SELECT shedule.start as start, course.name as course_name, modifiers.name as modifier_name FROM courseinfo
JOIN modifiers ON modifiers.id = courseinfo.modifier
JOIN course ON course.id = courseinfo.course_id
LEFT JOIN shedule ON shedule.course_id = courseinfo.course_id AND shedule.start > CURDATE() AND shedule.modifier = courseinfo.modifier
WHERE modifiers.id = '{$modifier_id}' AND course.id='{$course_id}'");
        $info = $courseinfo[0]["course_name"] . " " . $courseinfo[0]["modifier_name"] . ".";
        if (strlen($courseinfo[0]["start"]) > 0) {
            $info .= "Стартуем: " . $courseinfo[0]["start"] . " ";
        }
        $msg = '
                <html>
                    <head>
                        <title>Регистрация на курс</title>
                    </head>
                    <body>
                        <table>
                            <tr>
                                <td>Имя:</td>
                                <td>'.$data["name"].'</td>
                            </tr>
                            <tr>
                                <td>Телефон:</td>
                                <td>'.$data["phone"].'</td>
                            </tr>
                            <tr>
                                <td>Курс:</td>
                                <td>'.$info.'</td>
                            </tr>
                            <tr>
                                <td>Как нашли:</td>
                                <td>'.$data["how"].'</td>
                            </tr>
                            <tr>
                                <td>Комментарий:</td>
                                <td>'.$data["comment"].'</td>
                            </tr>
                        </table>
                </body>
                </html>
                ';

        $headers = self::$header . "\r\n" . 'From: Абитуриент <' . $mail . '>' . "\r\n";
        mail($to, $subj, $msg, $headers);
        self::userMail($mail, $info);
    }

    public static function userMail($to, $info)
    {
        $subj = "Регистрация на курс от Webcamp.";
        $msg = "
                ололо!\r\n
                вы записались на курс " . $info . ". \r\n
                мы вам когда-нибудь позвоним или не позвоним.\r\n
                Щастяздоровля
                ";
        $headers = self::$header . "\r\n" . 'From: WebCamp <' . self::$register . self::$webcampDomain . '>' . "\r\n";
        mail($to, $subj, $msg, $headers);
    }

}