<?php
class PageInfo {
    private $title;

    private $description;

    private $menuItem;

    private $currentCourse;

    private $includeSlider;

    private $extraHeader;

    private $extraData;

    private static $_instance = null;

    private function __construct()
    {
        $this->description = "Курсы по созданию сайтов, обучение программированию в Киеве от школы компьютерных курсов Webcamp";
        $this->includeSlider = false;
        $this->currentCourse = null;
    }

    private static function instance() {
        if(self::$_instance === null) self::$_instance = new PageInfo();
        return self::$_instance;
    }

    public static function setTitle($title)
    {
        self::instance()->title = $title;
    }

    public static function getTitle()
    {
        return self::instance()->title;
    }

    public static function setDescription($description)
    {
        self::instance()->description = $description;
    }

    public static function getDescription()
    {
        return self::instance()->description;
    }

    public static function setMenuItem($menuItem)
    {
        self::instance()->menuItem = $menuItem;
    }

    public static function getMenuItem()
    {
        return self::instance()->menuItem;
    }

    public static function setIncludeSlider($is)
    {
        self::instance()->includeSlider = $is;
    }

    public static function getIncludeSlider()
    {
        return self::instance()->includeSlider;
    }

    public static function setCurrentCourse($course)
    {
        self::instance()->currentCourse = $course;
    }

    public static function getCurrentCourse()
    {
        return self::instance()->currentCourse;
    }

    public static function setExtraHeader($header)
    {
        self::instance()->extraHeader = $header;
    }

    public static function getExtraHeader()
    {
        return self::instance()->extraHeader;
    }

    public static function setExtraData($data) {
        self::instance()->extraData = $data;
    }

    public static function getExtraData() {
        return self::instance()->extraData;
    }
}