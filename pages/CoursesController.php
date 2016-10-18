<?php

require_once ROOT . 'configs/pdo.php';
require_once ROOT . 'pages/MailController.php';

/**
 * Created by IntelliJ IDEA.
 * User: lenka
 * Date: 9/30/15
 * Time: 16:42
 */
class CoursesController
{
    public static function index($alias)
    {

        $index = array_search('courses', array_column($GLOBALS['menu'], 'alias'));
        $menuItem = '';
        $description = "Курсы программирования и цены";
        $title = "Курсы программирования Webcamp";
        if ($alias != null) {
            $metadata = DB::getObj("SELECT course.name, course.metadesc FROM course WHERE course.alias = '{$alias}'");
            $description = $metadata['metadesc'];
            $title = $metadata['name'];
        }
        if ($index !== false) {
            $menuItem = $GLOBALS['menu'][$index];
        }

        echo $GLOBALS['twig']->render('Courses/index.html.twig',
            array('active' => 'courses',
                'menuItem' => $menuItem,
                'title' => $title,
                'description' => $description,
                'alias' => $alias
            )
        );
    }

    public static function all()
    {
        include_once("pages/code/course.php");
        $courses = DB::getAll('SELECT DISTINCT course.id, course.name, course.alias, course.description, course.duration, course.level, courseinfo.price, tracks.name AS track FROM course
                                JOIN courseinfo ON course.id = courseinfo.course_id
                                JOIN tracks ON tracks.id = course.track
                                WHERE courseinfo.include = 1
                                ORDER BY tracks.name', 'Course');
        echo json_encode($courses);
    }

    public static function courses($alias)
    {
        include_once("pages/code/course.php");
        return DB::getOne("SELECT course.id, course.name, course.alias,course.metadesc, course.description, course.results, course.requirements, course.duration, course.level, tracks.name as track FROM course
                                JOIN tracks ON tracks.id = course.track
                                WHERE course.alias = '{$alias}'", 'Course');
    }

    public static function lessons($courseId)
    {
        return DB::getArray("SELECT lessons.num, lessons.description FROM lessons WHERE lessons.course_id = $courseId ORDER BY lessons.num");
    }

    public static function instructors()
    {
        return DB::getArray("SELECT * FROM instructors");
    }

    public static function enroll()
    {
        $data = array(
            'id' => null,
            'name' => null,
            'email' => null,
            'phone' => null,
            'comment' => null,
            'how' => null,
            'course_id' => null,
            'modifier_id' => null,
            'hash' => null,
            'modifier_text' => null
        );
        $tmp = array_merge($data, $_POST);
        $modifier_text = array_splice($tmp, -1);
        $query = "INSERT INTO students (id, name, email, phone, comment, how, course_id, modifier_id, hash)
                  VALUES (:id, :name, :email, :phone, :comment, :how, :course_id, :modifier_id, :hash);";
        DB::postOne($query, $tmp);
        MailController::registerMail($tmp, $modifier_text);
    }

    public static function coursenames()
    {
        include_once("pages/code/course.php");
        $courses = DB::getArray('SELECT course.id AS course_id, course.name AS course_name FROM course JOIN courseinfo ON course.id = courseinfo.course_id WHERE courseinfo.include = 1');
        echo json_encode($courses);
    }
}