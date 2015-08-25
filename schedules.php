<?php
include_once("pages/code/schedule.php");

$sch = new Schedule();
$sch->setCourse(Courses::getCourse("java-basic"));
$sch->getCourse()->nearest = $sch;
$sch->begin = date_create("2014-11-23");
$sch->durationHours = 42;
$sch->weekDays = WeekDays::fromString("Сб, Вс");
$sch->timeFrom = new Time(9, 00);
$sch->timeTo = new Time(12,30);
$sch->left = 4;
$sch->price = 2890;
Schedules::add($sch);

$sch = new Schedule();
$sch->setCourse(Courses::getCourse("java-advanced"));
$sch->getCourse()->nearest = $sch;
$sch->begin = date_create("2013-11-25");
$sch->durationHours = 42;
$sch->weekDays = WeekDays::fromString("Пн,Ср,Пт");
$sch->timeFrom = new Time(19,00);
$sch->timeTo = new Time(21,00);
$sch->left = 2;
$sch->price = 3250;
Schedules::add($sch);

$sch = new Schedule();
$sch->setCourse(Courses::getCourse("php-advanced"));
$sch->getCourse()->nearest = $sch;
$sch->begin = date_create("2013-12-03");
$sch->durationHours = 36;
$sch->weekDays = WeekDays::fromString("Вт, Чт");
$sch->timeFrom = new Time(18, 30);
$sch->timeTo = new Time(21, 30);
$sch->left = 8;
$sch->price = 2890;
Schedules::add($sch);


$sch = new Schedule();
$sch->setCourse(Courses::getCourse("php-basic"));
$sch->getCourse()->nearest = $sch;
$sch->begin = date_create("2014-05-12");
$sch->durationHours = 36;
$sch->weekDays = WeekDays::fromString("Сб, Вс");
$sch->timeFrom = new Time(12, 00);
$sch->timeTo = new Time(16, 00);
$sch->left = 8;
$sch->price = 2560;
Schedules::add($sch);



$sch = new Schedule();
$sch->setCourse(Courses::getCourse("cpp-basic"));
$sch->getCourse()->nearest = $sch;
$sch->begin = null;
$sch->durationHours = 108;
$sch->weekDays = WeekDays::fromString("Сб, Вс");
$sch->timeFrom = new Time(10, "00");
$sch->timeTo = new Time(13, "00");
$sch->left = 7;
$sch->price = "2200 грн. в месяц";
Schedules::add($sch);

$sch = new Schedule();
$sch->active = false;
$sch->setCourse(Courses::getCourse("frontend-basic"));
$sch->getCourse()->nearest = $sch;
$sch->begin = null;
$sch->durationHours = 36;
$sch->weekDays = WeekDays::fromString("Пн,Ср,Пт");
$sch->timeFrom = new Time(19, "00");
$sch->timeTo = new Time(21, "00");
$sch->left = "";
$sch->price = 2560;
Schedules::add($sch);

$sch = new Schedule();
$sch->active = false;
$sch->setCourse(Courses::getCourse("frontend-advanced"));
$sch->getCourse()->nearest = $sch;
$sch->begin = null;
$sch->durationHours = 36;
$sch->weekDays = WeekDays::fromString("Пн,Ср,Пт");
$sch->timeFrom = new Time(19, "00");
$sch->timeTo = new Time(21, "00");
$sch->left = "";
$sch->price = 2890;
Schedules::add($sch);

/*

$sch = new Schedule();
$sch->active = false;
$sch->setCourse(Courses::getCourse("php-advanced"));
$sch->getCourse()->nearest = $sch;
$sch->begin = null;
$sch->durationHours = "-";
$sch->weekDays = WeekDays::fromString("");
$sch->timeFrom = new Time("", "");
$sch->timeTo = new Time("", "");
$sch->left = "";
$sch->price = "-";
Schedules::add($sch);

$sch = new Schedule();
$sch->active = false;
$sch->setCourse(Courses::getCourse("frontend-basic"));
$sch->getCourse()->nearest = $sch;
$sch->begin = null;
$sch->durationHours = "-";
$sch->weekDays = WeekDays::fromString("");
$sch->timeFrom = new Time("", "");
$sch->timeTo = new Time("", "");
$sch->left = "";
$sch->price = "-";
Schedules::add($sch);

$sch = new Schedule();
$sch->active = false;
$sch->setCourse(Courses::getCourse("frontend-advanced"));
$sch->getCourse()->nearest = $sch;
$sch->begin = null;
$sch->durationHours = "-";
$sch->weekDays = WeekDays::fromString("");
$sch->timeFrom = new Time("", "");
$sch->timeTo = new Time("", "");
$sch->left = "";
$sch->price = "-";
Schedules::add($sch);

*/
