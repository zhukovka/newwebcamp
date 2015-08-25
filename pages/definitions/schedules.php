<?php
include_once("pages/code/schedule.php");

/*FRONTEND*/

$sch = new Schedule();
$sch->setCourse(Courses::getCourse("frontend-basic"));
$sch->getCourse()->nearest = $sch;
$sch->begin = date_create("2015-09-08");
$sch->durationHours = 36;
$sch->weekDays = WeekDays::fromString("Вт, Пт");
$sch->timeFrom = new Time(19, "00");
$sch->timeTo = new Time(21, "00");
$sch->left = 3;
$sch->price = 3200;
Schedules::add($sch);

$sch = new Schedule();
$sch->setCourse(Courses::getCourse("frontend-basic-m"));
$sch->getCourse()->nearest = $sch;
$sch->begin = null;
$sch->durationHours = 36;
$sch->weekDays = WeekDays::fromString("Пн, Ср");
$sch->timeFrom = new Time(10, "00");
$sch->timeTo = new Time(13, "00");
$sch->left = 8;
$sch->price = 2800;
Schedules::add($sch);

$sch = new Schedule();
$sch->setCourse(Courses::getCourse("js-basic"));
$sch->getCourse()->nearest = $sch;
$sch->begin = date_create("2015-09-19");
$sch->durationHours = 36;
$sch->weekDays = WeekDays::fromString("Сб, Вс");
$sch->timeFrom = new Time(11, "00");
$sch->timeTo = new Time(14, "00");
$sch->left = 2;
$sch->price = 3500;
Schedules::add($sch);

$sch = new Schedule();
$sch->setCourse(Courses::getCourse("js-basic-m"));
$sch->getCourse()->nearest = $sch;
$sch->begin = null;
$sch->durationHours = 36;
$sch->weekDays = WeekDays::fromString("Пн, Ср");
$sch->timeFrom = new Time(10, "00");
$sch->timeTo = new Time(13, "00");
$sch->left = 6;
$sch->price = 3200;
Schedules::add($sch);

/*
$sch = new Schedule();
$sch->setCourse(Courses::getCourse("frontend-advanced"));
$sch->getCourse()->nearest = $sch;
$sch->begin = date_create("2015-05-25");
$sch->durationHours = 36;
$sch->weekDays = WeekDays::fromString("Пн, Ср");
$sch->timeFrom = new Time(19, "00");
$sch->timeTo = new Time(21, "00");
$sch->left = 0;
$sch->price = 3500;
Schedules::add($sch);
*/
/*
$sch = new Schedule();
$sch->setCourse(Courses::getCourse("jQuery"));
$sch->getCourse()->nearest = $sch;
$sch->begin = null;
$sch->durationHours = 12;
$sch->weekDays = WeekDays::fromString("Вт, Чт");
$sch->timeFrom = new Time(19, "00");
$sch->timeTo = new Time(22, "00");
$sch->left = 7;
$sch->price = 1500;
Schedules::add($sch);
*/
/*PHP*/

$sch = new Schedule();
$sch->setCourse(Courses::getCourse("php-basic"));
$sch->getCourse()->nearest = $sch;
$sch->begin = date_create("2015-09-19");
$sch->durationHours = 36;
$sch->weekDays = WeekDays::fromString("Сб, Вс");
$sch->timeFrom = new Time(11, "00");
$sch->timeTo = new Time(14, "00");
$sch->left = 8;
$sch->price = 3500;
Schedules::add($sch);

$sch = new Schedule();
$sch->setCourse(Courses::getCourse("php-advanced"));
$sch->getCourse()->nearest = $sch;
$sch->begin = null;
$sch->durationHours = 36;
$sch->weekDays = WeekDays::fromString("Сб, Вс");
$sch->timeFrom = new Time(11, "00");
$sch->timeTo = new Time(14, "00");
$sch->left = 2;
$sch->price = 3800;
Schedules::add($sch);

$sch = new Schedule();
$sch->setCourse(Courses::getCourse("php-symfony"));
$sch->getCourse()->nearest = $sch;
$sch->begin = null;
$sch->durationHours = 30;
$sch->weekDays = WeekDays::fromString("Пн, Ср, Пт");
$sch->timeFrom = new Time(19, "00");
$sch->timeTo = new Time(22, "00");
$sch->left = 3;
$sch->price = 5000;
Schedules::add($sch);

/*JAVA*/

$sch = new Schedule();
$sch->setCourse(Courses::getCourse("java-basic"));
$sch->getCourse()->nearest = $sch;
$sch->begin = null;
$sch->durationHours = 36;
$sch->weekDays = WeekDays::fromString("Вт, Чт");
$sch->timeFrom = new Time(19, "00");
$sch->timeTo = new Time(21, "00");
$sch->left = 4;
$sch->price = 3500;
Schedules::add($sch);

$sch = new Schedule();
$sch->setCourse(Courses::getCourse("java-advanced"));
$sch->getCourse()->nearest = $sch;
$sch->begin = null;
$sch->durationHours = 36;
$sch->weekDays = WeekDays::fromString("Вт, Чт");
$sch->timeFrom = new Time(19, "00");
$sch->timeTo = new Time(21, "00");
$sch->left = 0;
$sch->price = 5500;
Schedules::add($sch);

/*INDI, CORPORATE */

$sch = new Schedule();
$sch->setCourse(Courses::getCourse("indi"));
$sch->getCourse()->nearest = $sch;
$sch->begin = null;
$sch->durationHours = 6;
$sch->weekDays = WeekDays::fromString("Пн, Вт, Ср, Чт, Пт");
$sch->timeFrom = new Time(10, "00");
$sch->timeTo = new Time(13, "00");
$sch->left = 1;
$sch->price = "300 грн/час";
Schedules::add($sch);