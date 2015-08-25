<?php
include_once("pages/code/valueobjects.php");

class Schedule {
    public $id;
    private $course;
    public $begin;
    public $durationHours;
    public $timeFrom;
    public $timeTo;
    public $weekDays;
    public $left;
    public $price;
    public $active;

    function __construct()
    {
        $this->active = true;
    }


    public function setCourse($course) {
        $this->course = $course;
    }

    public function getClassesInWeek() {
        return $this->weekDays->getDaysInWeek();
    }

    public function getDurationWeeks() {
        $classDuration = ($this->timeTo->toPlain() - $this->timeFrom->toPlain()) / 60;
        if(!is_int($this->durationHours)) return '';
        $classes = $this->durationHours / $classDuration;
        $weeks = $classes / $this->getClassesInWeek();
        return ceil($weeks)." ".($weeks % 10 == 1 ? "неделя" : "недель");
    }
     /* This is the static comparing function: */
    static function cmp_obj($a, $b)
    {
        $al = ($a->begin);
        $bl = ($b->begin);
        if ($al == $bl) {
            return 0;
        }
        
		return ($al > $bl) ? +1 : -1;
        
    }

    public function getCourse() {
        if(is_string($this->course)) {
            $this->course = Courses::getCourse($this->course);
        }
        return $this->course;
    }
}

class Schedules {
    private static $schedules = array();

    private function __construct() {

    }

    public static function getAll() {
        $ret = array();

        foreach(self::$schedules as $sch) {
            if($sch->active and $sch->begin!=null) array_push($ret, $sch);
            
        }
        usort($ret, array("Schedule", "cmp_obj"));
        foreach(self::$schedules as $sch) {
            if($sch->active and $sch->begin==null) array_push($ret, $sch);
            
        }
/*         usort($ret, array("Schedule", "cmp_obj")); */
        return $ret;
    }

    public static function add($sch) {
        array_push(self::$schedules, $sch);
    }

    public static function getNearest($alias) {
        $default = date_timestamp_get(date_create("2035-01-01"));
        $retTime = $default;
        $ret = null;
        foreach(self::$schedules as $sch) {
            if($sch->getCourse()->alias == $alias && (($retTime === $default && $sch->begin == null) || (date_timestamp_get($sch->begin) < $retTime))) {
                $ret = $sch;
            }
        }
        return $ret;
    }
}