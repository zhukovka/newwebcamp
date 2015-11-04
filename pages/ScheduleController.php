<?php

/**
 * Created by IntelliJ IDEA.
 * User: lenka
 * Date: 10/1/15
 * Time: 18:16
 */
class ScheduleController
{
    public static function index()
    {

        $index = array_search('schedule', array_column($GLOBALS['menu'], 'alias'));
        $menuItem = '';
        if ($index !== false) {
            $menuItem = $GLOBALS['menu'][$index];
        }
        echo $GLOBALS['twig']->render('Schedules/index.html.twig',
            array('active' => 'schedule',
                'menuItem' => $menuItem,

            )
        );
    }

    public static function all()
    {
        include_once(ROOT . "pages/code/schedule.php");
        $schedule = DB::getAll('SELECT shedule.start, course.name as course_name, course.alias as course_alias, modifiers.name as modifier,modifiers.id as modifier_id,
                                          course.duration as courseDuration,
                                          courseinfo.price, courseinfo.duration as durationHours, courseinfo.days as weekDays
                                    FROM shedule
                                    INNER JOIN course
                                    ON course.id = shedule.course_id
                                    INNER JOIN courseinfo
                                    ON course.id = courseinfo.course_id AND shedule.modifier = courseinfo.modifier
                                    JOIN modifiers ON modifiers.id = courseinfo.modifier
                                    WHERE shedule.start > DATE_SUB(CURDATE(), INTERVAL 1 WEEK)
                                    ORDER BY shedule.start', 'Schedule');
        echo json_encode($schedule);
    }

    public static function schedule($courseId)
    {
        include_once(ROOT . "pages/code/schedule.php");

        $schedule = DB::getAll("SELECT shedule.start, modifiers.name as modifier_name, modifiers.id as modifier_id, courseinfo.price, courseinfo.days, courseinfo.duration as durationHours FROM courseinfo
JOIN modifiers ON modifiers.id = courseinfo.modifier
LEFT JOIN shedule ON shedule.course_id = courseinfo.course_id AND shedule.start > DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND shedule.modifier = courseinfo.modifier
WHERE courseinfo.course_id = {$courseId}", 'Schedule');
        echo json_encode($schedule);
    }
}