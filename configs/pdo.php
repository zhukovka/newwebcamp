<?php

/**
 * Created by IntelliJ IDEA.
 * User: lenka
 * Date: 9/24/15
 * Time: 21:41
 */
class DB
{
    private static $con;
    private static $servername = "127.0.0.1";
    private static $username = "root";
    private static $password = "root";

    public static function connect()
    {
        self::$con = new PDO('mysql:dbname=webcamp;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock;charset=utf8', self::$username, self::$password);
        self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getMenu()
    {
        $res = self::$con->query('SELECT * FROM menu ORDER BY position');
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function fetchCourses()
    {
        include_once(ROOT . "pages/code/course.php");
        include_once("pages/code/schedule.php");
        $res = self::$con->query('SELECT * FROM course');
        Courses::addCourses($res->fetchAll(PDO::FETCH_CLASS, 'Course'));
        $res = self::$con->query('SELECT shedule.start, shedule.modifier, course.name
                                    FROM shedule
                                    INNER JOIN course
                                    ON course.id = shedule.course_id
                                    WHERE shedule.start > DATE_SUB(CURDATE(), INTERVAL 1 WEEK)
                                    ORDER BY shedule.start');
        Schedules::addSchedules($res->fetchAll(PDO::FETCH_CLASS, 'Schedule'));
//        var_dump(Schedules::getAll());
    }

    public static function getAll($query, $class)
    {
        $res = self::$con->query($query);
        return $res->fetchAll(PDO::FETCH_CLASS, $class);
    }


}


