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

    public static function getAll($query, $class)
    {
        $res = self::$con->query($query);
//var_dump($res);
//    $res = $pdo->query('SELECT * FROM course');

# Map ress to object
//        $res->setFetchMode(PDO::FETCH_CLASS, $class);
        return $res->fetchAll(PDO::FETCH_CLASS, $class);
    }

}


