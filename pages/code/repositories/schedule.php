<?php
include_once("/pages/code/schedule.php");

class SchedulesRepository extends Repository {
    private static $rows = array("Id", "Course", "Begin", "DurationHours", "TimeFrom", "TimeTo", "WeekDays", "Left", "Price");

    public function getRows()
    {
        return self::$rows;
    }

    public function mapObject($row)
    {
        $ret = new Schedule();

        $ret->id = $row["Id"];
        $ret->setCourse($row["Course"]);
        $ret->begin = $row["Begin"];
        $ret->durationHours = $row["DurationHours"];
        $ret->timeFrom = Time::fromPlain($row["TimeFrom"]);
        $ret->timeTo = Time::fromPlain($row["TimeTo"]);
        $ret->weekDays = new WeekDays($row["WeekDays"]);
        $ret->left = $row["Left"];
        $ret->price = $row["Price"];
    }

    public function mapRows($obj)
    {
        $course = is_string($obj->getCourse()) ? $obj->getCourse() : $obj->getCourse()->alias;
        return array(
            "Id" => $obj->id,
            "Course" => $course,
            "Begin" => $obj->begin,
            "DurationHours" => $obj->durationHours,
            "TimeFrom" => $obj->timeFrom->toPlain(),
            "TimeTo" => $obj->timeTo->toPlain(),
            "Left" => $obj->left,
            "Price" => $obj->price
        );
    }
}