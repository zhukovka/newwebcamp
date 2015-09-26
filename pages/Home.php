<?php

/**
 * Created by IntelliJ IDEA.
 * User: lenka
 * Date: 9/25/15
 * Time: 15:18
 */
class Home
{
    public static function index()
    {
        include_once("pages/code/slide.php");
        $slides = DB::getAll('SELECT * FROM slider ORDER BY position', 'Slide');
        echo $GLOBALS['twig']->render('index.html.twig',
            array('active' => 'home',
                'slides' => $slides,
                'closest' => Schedules::closest));
    }
}