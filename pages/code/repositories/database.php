<?php
class Database {
    private static $db = null;

    public static function modify($query) {
        return mysql_affected_rows(self::query($query));
    }

    public static function modifyOne($query) {
        $rowsAff = self::modify($query);

        if($rowsAff !== 1) {
            throw new Exception("Cannot modify one element by query {$query}");
        }
    }

    public static function fetch($query) {
        $result = self::query($query);
        $ret = array();

        while ($row = mysql_fetch_array($result)) {
            array_push($ret, $row);
        }
        mysql_free_result($result);
        return $ret;
    }

    public static function fetchOne($query) {
        $ret = self::fetch($query);

        if(count($ret) !== 1) {
            throw new Exception("Cannot fetch one element by {$query} query");
        }
        return $ret[0];
    }

    private static function query($query) {
        self::init();
        return mysql_query($query);
    }

    private static function init() {
        if(self::$db !== null) return;

        self::$db = mysql_connect("webcamp.mysql.ukraine.com.ua", "webcamp_db", "RCrHA4F5");
    }
}