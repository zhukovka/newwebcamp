<?php
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
        $sms = self::userSMS($data['name'], $data['phone'], $info);


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
                                <td>' . $sms . '</td>
                            </tr>
                        </table>
                </body>
                </html>
                ';

        $headers = self::$header . "\r\n" . 'From: Абитуриент <' . $mail . '>' . "\r\n";
        mail($to, $subj, $msg, $headers);
        self::userMail($mail, $data['name'], $info);
    }

    public static function userMail($to, $name, $info)
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
            <ul style="list-style:none;">
            <li><a style="text-decoration:none;color:#797e83;" href="tel:+380502706713">+38 (050) 270-67-13</a></li>
            <li><a style="text-decoration:none;color:#797e83;" href="tel:+380637078513">+38 (063) 707-85-13</a></li>
            </ul>
            или написать в скайп: <strong>webcamp.welcome</strong><br>
            <a style="text-decoration:none;color:#797e83;" href="https://www.facebook.com/webcamp.kiev"> Группа в Facebook</a>
            </p>
            </body>
            </html>
';
        $headers = self::$header . "\r\n" . 'From: WebCamp <' . self::$info . '@' . self::$webcampDomain . '>' . "\r\n";
        mail($to, $subj, $msg, $headers);
    }

    public static function userSMS($name, $phone, $info)
    {
        str_replace('/\+\(\)\s/', '', $phone);
        $message = "Спасибо " . $name . ", Вы зарегистрировались на курс " . $info . " от WebCamp";
        $sms = new SMSclient('', '', SMS_KEY);
        $id = $sms->sendSMS("WebCamp", $phone, $message);
        $res = $sms->receiveSMS($id);
        return $res;

    }

}