<?php
include_once("pages/code/valueobjects.php");
setlocale(LC_TIME, "ru_RU");

//define("DAYS", array('понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье'));
class Schedule {
//    public $id;
    public $course_name;
    public $course_alias;
    public $modifier;
//    public $month;
    public $days;
    public $price;
    public $lessonCount;
//    public $begin;
//    public $weekDaysNames;
//    public $time;
//    public $timeFrom;
//    public $timeTo;
    public $durationHours;
    public $courseDuration;
    private $weekDays;
    private $start;
//    private $daysNames = array('понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье');
//    public $left;
//    public $active;
//    private $course;

    function __construct()
    {
//        $this->active = true;
        if (!empty($this->start)) {
            $time = DateTime::createFromFormat('Y-m-d H:i:s', $this->start);
            $this->begin = $time->getTimestamp() * 1000;
        }
        $this->days = explode(',', $this->days);
//            array_map(function ($day) {
//            return $day - 1;
//        }, explode(',', $this->weekDays));
        $this->lessonCount = round($this->courseDuration / count($this->days));
        $this->durationHours = (int)$this->durationHours;
//        $this->day = $this->begin->format('d');
//        $this->month = strftime("%B", $this->time);
//        $this->timeFrom = strftime("%R", $this->time);
//        $this->timeTo = strftime("%R", $this->time + $this->durationHours * 3600);
        $this->setInfo();
    }


    private function setInfo()
    {
        $days = explode(',', $this->weekDays);
        $times = count($days);
//        $this->weekDaysNames = array_map(function ($day) {
//            return $this->daysNames[$day - 1];
//        }, $days);
    }

//    static function cmp_obj($a, $b)
//    {
//        $al = ($a->begin);
//        $bl = ($b->begin);
//        if ($al == $bl) {
//            return 0;
//        }
//
//        return ($al > $bl) ? +1 : -1;
//
//    }

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

    public static function getClosest($limit = null)
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