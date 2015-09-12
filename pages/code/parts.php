<?php
include_once("pages/code/pageinfo.php");

class Parts {
    const partsPrefix = "pages/parts/";

    private function __construct() {

    }

    static function renderSlider()
    {
        self::renderPart("slider");
    }

    private static function renderPart($part) {
        include(Parts::partsPrefix.$part.".php");
    }

    static function renderStartPage()
    {
        Parts::renderHeader();
        Parts::renderMenu();
    }

    static function renderHeader() {
        self::renderPart("header");
    }

    static function renderMenu() {
        self::renderPart("menu");
    }

    static function renderEndPage()
    {
        Parts::renderFooter();
        Parts::renderSignUpForm();
        Parts::renderPlugins();
    }

    static function renderFooter() {
        self::renderPart("footer");
    }

    static function renderSignUpForm() {
        self::renderPart("signupform");
    }

    static function renderPlugins()
    {
        self::renderPart("googleanalytic");
//        self::renderPart("siteheart");
        self::renderPart("yandex");
    }
}