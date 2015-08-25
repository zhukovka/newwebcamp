<?php
class WeekDays {
    private static $rusWeekDays = array("Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс");

    public $days = array(0, 0, 0, 0, 0, 0,0 );

    public function getDaysInWeek() {
        $ret = 0;
        foreach($this->days as $day) {
            if($day) $ret++;
        }
        return $ret;
    }

    public function toString() {
        $days = array();

        for($i = 0; $i < 7; $i++) {
            if($this->days[$i]) array_push($days, self::$rusWeekDays[$i]);
        }
        return implode(", ", $days);
    }

    public function toBin() {
        $ret = 0;
        for($i = 0; $i < 7; $i++) {
            if($this->days[$i]) $ret += pow(2, $i);
        }
        return $ret;
    }

    public static function fromBin($binDays) {
        $ret = new self();
        for($i = 0; $i < 7; $i++) {
            if($binDays & pow(2, $i)) $ret->days[$i] = true;
        }
        return $ret;
    }

    public static function fromString($str) {
        $ret = new self();
        for($i = 0; $i < 7; $i++) {
            if(strpos($str, self::$rusWeekDays[$i]) !== false) $ret->days[$i] = true;
        }
        return $ret;
    }
}

class Time {
    public $hours;
    public $minutes;

    function __construct($hours, $minutes) {
        $this->hours = $hours;
        $this->minutes = $minutes;
    }

    public function toString() {
        return sprintf("%02d:%02d", $this->hours, $this->minutes);
    }

    public function toPlain() {
        return ($this->hours * 60) + $this->minutes;
    }

    public static function fromPlain($plainTime) {
        $hours = floor($plainTime / 60);
        $minutes = $plainTime % 60;
        return new Time($hours, $minutes);
    }
}