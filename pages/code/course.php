<?php
class Course {
    public $alias;
    public $name;
    public $metadesc;
    public $description;
    public $results;
    public $requirements;

//    public $start;
    private function  __construct()
    {
        $this->results = explode("\n", $this->results);
        $this->requirements = explode("\n", $this->requirements);
    }
    public static function fromPost()
    {
        $ret = new Course();
        $ret->alias = $_POST["alias"];
        $ret->name = $_POST["name"];
        $ret->metadesc = $_POST["metadesc"];
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

    static function addCourses($courses)
    {
        self::$courses = $courses;
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