<?php
define("ROOT", __DIR__ . "/");

require_once ROOT . 'vendor/autoload.php';
use flight\Engine;

require_once ROOT . 'configs/pdo.php';
try {
    DB::connect();
    $menu = DB::getMenu();
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
}
$loader = new Twig_Loader_Filesystem(ROOT . 'templates');
$twig = new Twig_Environment($loader);
$twig->addGlobal('menu', $menu);
$twig->addGlobal('env', ENV);
$twig->addGlobal('host', HOST);

$app = new Engine();
Flight::set('twig', $twig);
$app->map('notFound', function () {
    // Display custom 404 page
    echo Flight::get('twig')->render('404.html.twig',
        array('active' => '404')

    );
});
$app->route('/', function () {
    require_once("pages/code/Slide.php");
    $slides = DB::getAll('SELECT * FROM slider WHERE alias="courses"', 'Slide');
    $tracks = DB::getGroup('SELECT tracks.name AS track, course.name AS course, course.alias AS course_alias FROM tracks LEFT JOIN course ON course.track = tracks.id INNER JOIN courseinfo ON courseinfo.course_id = course.id WHERE courseinfo.include = 1');
    echo Flight::get('twig')->render('index.html.twig',
        array('active' => 'home',
            'slides' => $slides,
            'tracks' => $tracks,
            'title'=>"Курсы программирования и тренинги Webcamp")
    );
});
$app->route('/schedule', function () {
    require_once(ROOT . 'pages/ScheduleController.php');
    ScheduleController::index();
});
$app->route('/study', function () {
    echo Flight::get('twig')->render('Study/index.html.twig',
        array('active' => 'study',
            'title'=>"Webcamp: график работы, акции и скидки, фотографии и формат занятий")
    );
});
$app->route('/contacts', function () {
    echo Flight::get('twig')->render('Contact/index.html.twig',
        array('active' => 'contacts',
            'title'=>"Записаться на курсы Webcamp: контактная информация")
    );
});
$app->route('/aboutus', function () {
    echo Flight::get('twig')->render('About/index.html.twig',
        array('active' => 'aboutus',
            'title'=>"Команда Webcamp: наши специалисты по обучению и разработке программ.")
    );
});

$app->route('/courses(/@alias)', function ($alias) {
    require_once(ROOT . 'pages/CoursesController.php');
    CoursesController::index($alias);
});
$app->route('/api/instructors', function () {
    require_once(ROOT . 'pages/CoursesController.php');
    Flight::json(CoursesController::instructors());
});

$app->route('/api/schedule', function () {
    require_once(ROOT . 'pages/ScheduleController.php');
    ScheduleController::all();
});
$app->route('/api/schedule/@courseId', function ($courseId) {
    require_once(ROOT . 'pages/ScheduleController.php');
    ScheduleController::schedule($courseId);
});
$app->route('/api/courses', function () {
    require_once(ROOT . 'pages/CoursesController.php');
    CoursesController::all();
});
$app->route('/api/courses/names', function () {
    require_once(ROOT . 'pages/CoursesController.php');
    CoursesController::coursenames();
});
$app->route('/api/courses/@alias', function ($alias) {
    require_once(ROOT . 'pages/CoursesController.php');
    $course = CoursesController::courses($alias);
    if (!$course) {
        Flight::notFound();
    } else {
        Flight::json($course);
    }
});
$app->route('/api/lessons/@courseId', function ($courseId) {
    require_once(ROOT . 'pages/CoursesController.php');
    Flight::json(CoursesController::lessons($courseId));
});
$app->route('POST /enroll', function () {
    require_once(ROOT . 'pages/CoursesController.php');
    try {
        CoursesController::enroll();
        Flight::json(array('success' => 'true'));
    } catch (PDOException $e) {
        file_put_contents('PDOErrors.txt', $e->getMessage() . $e->errorInfo[1], FILE_APPEND);

        if ($e->errorInfo[1] == 1062) {
            // duplicate entry, do something else
            header('Content-Type: application/json');
            Flight::json(array('sqlError' => array('code' => 1062, 'message' => $e->errorInfo[2])));
        } else {
            // an error other than duplicate entry occurred
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-Type: application/json');
            Flight::error($e);
        }
    }

});
$app->route('POST /subscribe', function () {
    require_once(ROOT . 'MailChimp.php');
    $MailChimp = new MailChimp('abc123abc123abc123abc123abc123-us1');

});

/* new routes under construction */

$app->route('/faq', function () {
    echo Flight::get('twig')->render('FAQ/index.html.twig',
        array('active' => 'faq',
            'title'=>"Вопросы и Ответы")
    );
});
//$app->route('/companies', function(){
//    echo Flight::get('twig')->render('Slider/companies.html.twig',
//        array('active' => 'companies')
//    );
//});

//$app->route('/practice', function(){
//    echo Flight::get('twig')->render('Slider/practice.html.twig',
//        array('active' => 'practice')
//    );
//});
//
//$app->route('/specs', function(){
//    echo Flight::get('twig')->render('Slider/specs.html.twig',
//        array('active' => 'specs')
//    );
//});


$app->start();
