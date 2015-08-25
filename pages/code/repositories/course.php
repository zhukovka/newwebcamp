<?php
include_once("pages/code/course.php");

class CoursesRepository extends Repository {
    private static $rows = array("Id", "Name", "ShortDescription");

    public function getRows() {
        return self::$rows;
    }

    public function mapObject($row) {
        $ret = new Course();

        $ret->alias = $row["Id"];
        $ret->name = $row["Name"];
        $ret->shortDescription = $row["ShortDescription"];
        return $ret;
    }

    public function mapRows($obj) {
        return array("Id" => $obj->alias, "Name" => $obj->name, "ShortDescription" => $obj->shortDescription);
    }
}