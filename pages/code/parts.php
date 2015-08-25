<?php
include_once("pages/code/pageinfo.php");

class Parts {
    const partsPrefix = "pages/parts/";

    private function __construct() {

    }

    private static function renderPart($part) {
        include(Parts::partsPrefix.$part.".php");
    }

    static function renderHeader() {
        self::renderPart("header");
    }

    static function renderMenu() {
        self::renderPart("menu");
    }

    static function renderFooter() {
        self::renderPart("footer");
    }

    static function renderPlugins() {
        self::renderPart("googleanalytic");
        self::renderPart("siteheart");
        self::renderPart("yandex");
    }

    static function renderSignUpForm() {
        self::renderPart("signupform");
    }

    static function renderStartPage() {
        Parts::renderHeader();
        Parts::renderMenu();
    }

    static function renderEndPage() {
        Parts::renderFooter();
        Parts::renderSignUpForm();
        Parts::renderPlugins();
    }
}