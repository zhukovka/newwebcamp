<?php

class Slide
{
    public $alias;
    public $name;
    public $icon;

    public function __construct()
    {
        $this->icon_img = file_get_contents("img/icons/$this->icon.svg");
    }

    public static function fromPost()
    {
        $ret = new Slide();
        $ret->alias = $_POST["alias"];
        $ret->name = $_POST["name"];
        $ret->shortDescription = $_POST["shortDescription"];
        return $ret;
    }

    public function getNearest()
    {
        return Schedules::getNearest($this->alias);
    }
}

class Slides
{
    private static $slides = array();

    private static $order = array();

    private function  __construct()
    {

    }

    static function addSlide($slide)
    {
        self::$slides[$slide->alias] = $slide;
    }

    static function getSlide($alias)
    {
        return self::$slides[$alias];
    }

    static function contains($alias)
    {
        return isset(self::$slides[$alias]);
    }

    static function getAll()
    {
        $ret = array();
        foreach (self::$slides as $slide) {
            array_push($ret, $slide);
        }
        return $ret;
    }

    static function getOrder()
    {
        return self::$order;
    }

    static function setOrder($order)
    {
        self::$order = $order;
    }
}