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
    private static $servername = "";
    private static $username = "root";
    private static $password = "root";

    public static function connect()
    {
        self::$con = new PDO('mysql:dbname=webcamp;host=localhost;charset=utf8', self::$username, self::$password);
        self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$con->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_TO_STRING);
        self::$con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    public static function getMenu()
    {
        $res = self::$con->query('SELECT alias, name, submenu FROM menu ORDER BY position');
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getArray($query)
    {
        $res = self::$con->query($query);
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function fetchSchedule()
    {
        include_once(ROOT . "pages/code/schedule.php");
        $res = self::$con->query('SELECT shedule.start, shedule.modifier, course.name as course_name,
                                          course.duration as courseDuration,
                                          courseinfo.price, courseinfo.duration as durationHours, courseinfo.days as weekDays
                                    FROM shedule
                                    INNER JOIN course
                                    ON course.id = shedule.course_id
                                    INNER JOIN courseinfo
                                    ON course.id = courseinfo.course_id AND shedule.modifier = courseinfo.modifier
                                    WHERE shedule.start > DATE_SUB(CURDATE(), INTERVAL 1 WEEK)
                                    ORDER BY shedule.start');
        Schedules::addSchedules($res->fetchAll(PDO::FETCH_CLASS, 'Schedule'));
    }

    public static function getAll($query, $class)
    {
        $res = self::$con->query($query);
        $res->setFetchMode(PDO::FETCH_CLASS, $class);
        return $res->fetchAll();
    }

    public static function getOne($query, $class)
    {
        $res = self::$con->query($query);
        $res->setFetchMode(PDO::FETCH_CLASS, $class);
        return $res->fetch();
    }

    public static function getGroup($query)
    {
        $res = self::$con->query($query);
        return $res->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);
    }

    public static function postOne($query, $data)
    {
        try {
            $res = self::$con->prepare($query);
            $res->execute($data);
            Flight::json(array('success' => 'true'));
        } catch (PDOException $e) {
            file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
            if ($e->errorInfo[1] == 1062) {
                // duplicate entry, do something else
                Flight::json(array('sqlError' => array('code'=>1062, 'message'=>$e->errorInfo[2])));
            } else {
                // an error other than duplicate entry occurred
                header('HTTP/1.1 500 Internal Server Error');
                Flight::error($e);
            }
        }
    }
}


