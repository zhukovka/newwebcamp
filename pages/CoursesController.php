<?php

/**
 * Created by IntelliJ IDEA.
 * User: lenka
 * Date: 9/30/15
 * Time: 16:42
 */
class CoursesController
{
    public static function index()
    {

        $index = array_search('courses', array_column($GLOBALS['menu'], 'alias'));
        $menuItem = '';
        if ($index !== false) {
            $menuItem = $GLOBALS['menu'][$index];
        }
        echo $GLOBALS['twig']->render('Courses/index.html.twig',
            array('active' => 'courses',
                'menuItem' => $menuItem,

            )
        );
    }

    public static function all()
    {
        include_once("pages/code/course.php");
        $courses = DB::getAll('SELECT course.id, course.name, course.alias, course.description, course.duration, course.level, courseinfo.price, modifiers.name as modifier, tracks.name as track FROM course
                                JOIN courseinfo ON course.id = courseinfo.course_id
                                JOIN modifiers ON modifiers.id = courseinfo.modifier
                                JOIN tracks ON tracks.id = course.track
                                WHERE courseinfo.include = 1
                                ORDER BY tracks.name', 'Course');
        echo json_encode($courses);
    }

    public static function courses($alias)
    {
        include_once("pages/code/course.php");
        $course = DB::getOne("SELECT course.id, course.name, course.alias, course.description, course.duration, course.level, tracks.name as track FROM course
                                JOIN tracks ON tracks.id = course.track
                                WHERE course.alias = '{$alias}'", 'Course');
        echo json_encode($course);
    }
}