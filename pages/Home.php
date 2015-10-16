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
        $tracks = DB::getGroup('SELECT tracks.name as track, course.name as course FROM tracks LEFT JOIN course ON course.track = tracks.id');
//        $closest = Schedules::getClosest(6);
//        var_dump($tracks);
        echo $GLOBALS['twig']->render('index.html.twig',
            array('active' => 'home',
                'slides' => $slides,
//                'closest' => $closest,
                'tracks' => $tracks)
        );
    }
}