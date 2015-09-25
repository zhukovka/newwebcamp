<?php
class Course {
    public $alias;
    public $name;
    public $shortDescription;
    public $description;
    public $start;

    public static function fromPost()
    {
        $ret = new Course();
        $ret->alias = $_POST["alias"];
        $ret->name = $_POST["name"];
        $ret->shortDescription = $_POST["shortDescription"];
        return $ret;
    }

    public function getNearest() {
        return Schedules::getNearest($this->alias);
    }
}

class Courses {
    private static $courses = array();

    private static $order = array();

    private function  __construct() {

    }

    static function addCourse($course) {
        self::$courses[$course->alias] = $course;
    }

    static function getCourse($alias) {
        return self::$courses[$alias];
    }

    static function contains($alias) {
        return isset(self::$courses[$alias]);
    }

    static function getAll() {
        $ret = array();
        foreach(self::$courses as $course) {
            array_push($ret, $course);
        }
        return $ret;
    }

    static function getOrder()
    {
        return self::$order;
    }

    static function setOrder($order) {
        self::$order = $order;
    }
}