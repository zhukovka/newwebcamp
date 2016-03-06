<?php

require_once ROOT . 'configs/pdo.php';
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
        $courses = DB::getAll('SELECT DISTINCT course.id, course.name, course.alias, course.description, course.duration, course.level, courseinfo.price, tracks.name as track FROM course
                                JOIN courseinfo ON course.id = courseinfo.course_id
                                JOIN tracks ON tracks.id = course.track
                                WHERE courseinfo.include = 1
                                ORDER BY tracks.name', 'Course');
        echo json_encode($courses);
    }

    public static function courses($alias)
    {
        include_once("pages/code/course.php");
        $course = DB::getOne("SELECT course.id, course.name, course.alias, course.description, course.results, course.duration, course.level, tracks.name as track FROM course
                                JOIN tracks ON tracks.id = course.track
                                WHERE course.alias = '{$alias}'", 'Course');
        echo json_encode($course);
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
            'hash' => null
        );
        $query = "INSERT INTO students (id, name, email, phone, comment, how, course_id, modifier_id, hash)
                  VALUES (:id, :name, :email, :phone, :comment, :how, :course_id, :modifier_id, :hash);";
        DB::postOne($query, array_merge($data, $_POST));
    }

    public static function enrollCompany()
    {
        $data = array(
            'id' => null,
            'name' => null,
            'contact' => null,
            'address' => null,
            'email' => null,
            'phone' => null,
            'course_id' => null,
            'pupilCount' => null,
            'time' => null,
            'comment' => null
        );
        $query = "INSERT INTO companies (id, name, contact, address, email, phone, course_id, pupilCount, time, comment)
                  VALUES (:id, :name, :contact, :address, :email, :phone, :course_id, :pupilCount, :time, :comment);";
        DB::postOne($query, array_merge($data, $_POST));
    }

    public static function coursenames()
    {
        include_once("pages/code/course.php");
        $courses = DB::getArray('SELECT course.id as course_id, course.name as course_name FROM course');
        echo json_encode($courses);
    }
}