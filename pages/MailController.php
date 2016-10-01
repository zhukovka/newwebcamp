<?php
/**
 * Created by PhpStorm.
 * User: Punkor
 * Date: 02.04.2016
 * Time: 20:42
 */
//require_once ROOT . 'pages/ScheduleController.php';
//require_once ROOT . 'pages/CoursesController.php';
require_once ROOT . 'pages/smsclient.php';


class MailController
{
    private static $webcampDomain = "webcamp.com.ua";
    private static $register = "register";
    private static $info = "info";
    private static $manager = "manager";
    private static $test = "test";
    private static $header = 'Content-type: text/html; charset=utf-8';
    private static $testDomain = "devtest.";

    public static function registerMail($data, $modifier_text)
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
        $info = $courseinfo[0]["course_name"] . " " . $modifier_text["modifier_text"];
        strlen($courseinfo[0]["start"]) > 0 ? $start = $courseinfo[0]["start"] : $start = "Идёт набор группы";


        /*recieve sms to user*/
        $sms_result = self::userSMS($data['name'], $data['phone'], $info);


        $msg = '
                <html>
                    <head>
                        <title>Регистрация на курс</title>
                    </head>
                    <body>
                        <table>
                            <tr>
                                <td>Имя:</td>
                                <td>' . $data["name"] . '</td>
                            </tr>
                            <tr>
                                <td>Телефон:</td>
                                <td>' . $data["phone"] . '</td>
                            </tr>
                            <tr>
                                <td>Курс:</td>
                                <td>' . $info . '</td>
                            </tr>
                            <tr>
                                <td>Почта:</td>
                                <td>' . $mail . '</td>
                            </tr>
                            <tr>
                                <td>Ближайшая группа:</td>
                                <td>' . $start . '</td>
                            </tr>
                            <tr>
                                <td>Как нашли:</td>
                                <td>' . $data["how"] . '</td>
                            </tr>
                            <tr>
                                <td>Комментарий:</td>
                                <td>' . $data["comment"] . '</td>
                            </tr>
                            <tr>
                                <td>Сообщение:</td>
                                <td>' . $sms_result . '</td>
                            </tr>
                        </table>
                </body>
                </html>
                ';


        $headers = self::$header . "\r\n" . 'From: Абитуриент <' . $mail . '>' . "\r\n";
        mail($to, $subj, $msg, $headers);
        self::userMail($mail, $data['name'], $info, $start);
        self::userSMS($data['name'], $data['phone'], $info);
    }

    public static function userMail($to, $name, $info, $start)
    {
        $subj = "Регистрация на курс от Webcamp.";
        $msg = '
            <html>
            <head>
            <title>Регистрация на курс от Webcamp</title>
            </head>
            <body>
            <p>
            Здравствуйте ' . $name . ' !<br>
            Вы записались на курс <b>' . $info . '</b> от Webcamp.<br>
            В ближайшее время мы перезвоним Вам на указанный номер и сообщим детали.<br>
            Вы можете связаться с нами по телефонам:<br>
            <ul>
            <li><a class="text-dark" href="tel:+38-063-478-41-07">+38 (063) 478-41-07</a> Андрей</li>
            <li><a class="text-dark" href="tel:+38-063-707-85-13">+38 (063) 707-85-13</a> Юлия</li>
            </ul>
            Скайп: webcamp.welcome<br>
            <a href="https://www.facebook.com/webcamp.kiev"> Группа в Facebook</a>
            </p>
            </body>
            </html>
';
        $headers = self::$header . "\r\n" . 'From: WebCamp <' . self::$info . '@' . self::$webcampDomain . '>' . "\r\n";
        mail($to, $subj, $msg, $headers);
    }
    
    public static function userSMS($name, $phone, $info){
        str_replace('/\+\(\)\s/', '', $phone);
        $message = "Спасибо ".$name.", Вы зарегистрировались на курс ".$info." от WebCamp";
        $sms = new SMSclient('', '', SMS_KEY);
        $id = $sms->sendSMS("WebCamp", $phone, $message);
        $res = $sms->receiveSMS($id);
        $balance = $sms->getBalance();

        return "Результат отправки SMS: ".$res.", текущий баланс: ".$balance;

    }

}