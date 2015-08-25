<?php
include_once("pages/code/teacher.php");

$teacher = new Teacher();
$teacher->name = "Кирилл Штиммерман";
$teacher->photo = "shtimerman.jpg";
$teacher->addCourse(Courses::getCourse('php-basic'));
$teacher->addCourse(Courses::getCourse('php-advanced'));
$teacher->description = "Более 6 лет профессиональной деятельности в IT в роли PHP разработчика. Опыт работы с заказчиками из США и Украины. Большой опыт работы с различными PHP фреймоворками. Имеет огромный опыт работы в роли лидера команды. Текущее место работы - лидер команды в области разработки веб приложений в датской компании в Киеве.";
Teachers::addTeacher($teacher);

$teacher = new Teacher();
$teacher->name = "Владимир Курченко";
$teacher->photo = "kurchenko.jpg";
//$teacher->addCourse(Courses::getCourse('java-basic'));
$teacher->addCourse(Courses::getCourse('java-advanced'));
$teacher->description = "Более 17 лет профессиональной деятельности в IT. 14 лет опыта работы на Java. 10 лет опыта работы Solution Architect. Опыт работы с заказчиками по всему миру – США, Дания, Швейцария, Бельгия, Колумбия и т.д. Имеет большой опыт передачи знаний начинающим программистам в различных проектах. Работа на крупные outsourcing и outstuffing компании Киева.";
Teachers::addTeacher($teacher);

$teacher = new Teacher();
$teacher->name = "Елена Жукова";
$teacher->photo = "none.jpg";
$teacher->addCourse(Courses::getCourse('frontend-basic'));
$teacher->addCourse(Courses::getCourse('js-basic'));
$teacher->description = "Более 2 лет профессиональной деятельности в IT. Более 3 лет работы с JavaScript, HTML/CSS, опыт работы с частными заказчиками по разработке сайтов. Опыт работы с языками PHP и Python. Профессионально работает с такими языками программирования и технологиями: HTML/HTML5, CSS/CSS3/SASS, JavaScript, jQuery, Backbone, node.js, MySQL, Mongo, svn/git. Опыт развития своих проектов. Текущее место работы - разработка, поддержка и развитие сайтов наших партнеров.";
Teachers::addTeacher($teacher);

//$teacher = new Teacher();
//$teacher->name = "Роман Андриянов";
//$teacher->photo = "none.jpg";
//$teacher->addCourse(Courses::getCourse('java-basic'));
//$teacher->description = "Более 2 лет профессиональной деятельности в IT. Более 3 лет работы с JavaScript, HTML/CSS, опыт работы с частными заказчиками по разработке сайтов. Опыт работы с языками PHP и Python. Профессионально работает с такими языками программирования и технологиями: HTML/HTML5, CSS/CSS3/SASS, JavaScript, jQuery, Backbone, node.js, MySQL, Mongo, svn/git. Опыт развития своих проектов. Текущее место работы - разработка, поддержка и развитие сайтов наших партнеров.";
//Teachers::addTeacher($teacher);