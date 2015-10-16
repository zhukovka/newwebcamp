<?php

/**
 * Created by IntelliJ IDEA.
 * User: lenka
 * Date: 10/7/15
 * Time: 20:56
 */
class TestController
{
    public static function index()
    {
        echo $GLOBALS['twig']->render('Tests/test.html.twig');
    }
}