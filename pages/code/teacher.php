<?php
class Teacher {
    public $name;
    public $courses;
    public $photo;
    public $description;

    function __construct() {
        $this->courses = array();
    }

    function addCourse($course) {
        array_push($this->courses, $course);
    }
}

class Teachers {
    private static $teachers = array();

    static function getAllTeachers() {
        return self::$teachers;
    }

    static function addTeacher($teacher) {
        array_push(self::$teachers, $teacher);
    }
}