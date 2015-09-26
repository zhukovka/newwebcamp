<?php
include_once("pages/code/valueobjects.php");
setlocale(LC_TIME, "ru_RU");
class Schedule {
//    public $id;
    public $day;
//    public $durationHours;
//    public $timeFrom;
//    public $timeTo;
//    public $weekDays;
//    public $left;
//    public $price;
//    public $active;
//    private $course;
    public $begin;

    function __construct()
    {
        $this->active = true;
        $this->begin = DateTime::createFromFormat('Y-m-d H:i:s', $this->start);
        $time = $this->begin->getTimestamp();
        $this->day = $this->begin->format('d');
        $this->month = strftime("%B", $time);
    }

    static function cmp_obj($a, $b)
    {
        $al = ($a->begin);
        $bl = ($b->begin);
        if ($al == $bl) {
            return 0;
        }

        return ($al > $bl) ? +1 : -1;

    }

    public function getDurationWeeks()
    {
        $classDuration = ($this->timeTo->toPlain() - $this->timeFrom->toPlain()) / 60;
        if (!is_int($this->durationHours)) return '';
        $classes = $this->durationHours / $classDuration;
        $weeks = $classes / $this->getClassesInWeek();
        return ceil($weeks) . " " . ($weeks % 10 == 1 ? "неделя" : "недель");
    }

    public function getClassesInWeek()
    {
        return $this->weekDays->getDaysInWeek();
    }

    /* This is the static comparing function: */

    public function getCourse() {
        if(is_string($this->course)) {
            $this->course = Courses::getCourse($this->course);
        }
        return $this->course;
    }

    public function setCourse($course)
    {
        $this->course = $course;
    }
}

class Schedules {
    private static $schedules = array();
    private static $closest = array();

    private function __construct() {

    }

    static function addSchedules($schedules)
    {
        self::$schedules = $schedules;
        self::setClosest();
    }

    private static function setClosest()
    {
        self::$closest = array_filter(self::$schedules, function ($schedule, $k) {
            return $schedule->begin >= new DateTime();
        }, ARRAY_FILTER_USE_BOTH);
    }

    public static function getClosest(int $limit = null)
    {
        return array_slice(self::$closest, 0, $limit);
    }

    public static function getSchedules()
    {
        return self::$schedules;
    }

    public static function add($sch) {
        array_push(self::$schedules, $sch);
    }

    public static function getNearest($alias)
    {
//        $default = date_timestamp_get(date_create("2035-01-01"));
//        $retTime = $default;
//        $ret = null;
//        foreach(self::$schedules as $sch) {
//            if($sch->getCourse()->alias == $alias && (($retTime === $default && $sch->begin == null) || (date_timestamp_get($sch->begin) < $retTime))) {
//                $ret = $sch;
//            }
//        }
//        return $ret;
    }


}