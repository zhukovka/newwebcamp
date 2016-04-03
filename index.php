<?php
define("ROOT", __DIR__ . "/");

require_once ROOT . 'vendor/autoload.php';
use flight\Engine;

try {
    require_once ROOT . 'configs/pdo.php';
    DB::connect();
    $menu = DB::getMenu();
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
}
$loader = new Twig_Loader_Filesystem(ROOT . 'templates');
$twig = new Twig_Environment($loader);
$twig->addGlobal('title', 'Webcamp');
$twig->addGlobal('menu', $menu);
//var_dump($menu);
//$twig = new Twig_Environment($loader, array(
//    'cache' => ROOT . 'compilation_cache',
//));
$app = new Engine();
Flight::set('twig', $twig);
$app->map('notFound', function () {
    // Display custom 404 page
    echo 'oppa-pa 404';
});
$app->route('/', function () {
    require_once("pages/code/Slide.php");
    $slides = DB::getAll('SELECT * FROM slider WHERE alias="courses"', 'Slide');
    $tracks = DB::getGroup('SELECT tracks.name as track, course.name as course, course.alias as course_alias FROM tracks LEFT JOIN course ON course.track = tracks.id');
    echo Flight::get('twig')->render('index.html.twig',
        array('active' => 'home',
            'slides' => $slides,
            'tracks' => $tracks)
    );
});
$app->route('/schedule', function () {
    require_once(ROOT . 'pages/ScheduleController.php');
    ScheduleController::index();
});
$app->route('/study', function () {
    echo Flight::get('twig')->render('Study/index.html.twig',
        array('active' => 'study')
    );
});
$app->route('/contacts', function () {
    echo Flight::get('twig')->render('Contact/index.html.twig',
        array('active' => 'contacts')
    );
});
$app->route('/aboutus', function () {
    echo Flight::get('twig')->render('About/index.html.twig',
        array('active' => 'aboutus')
    );
});

$app->route('/courses(/@alias)', function () {
    require_once(ROOT . 'pages/CoursesController.php');
    CoursesController::index();
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
    CoursesController::courses($alias);
});
$app->route('/api/lessons/@courseId', function ($courseId) {
    require_once(ROOT . 'pages/CoursesController.php');
    Flight::json(CoursesController::lessons($courseId));
});
$app->route('POST/enroll', function () {
    require_once(ROOT . 'pages/CoursesController.php');
    try{
        CoursesController::enroll();
    }catch (PDOException $e){
        Flight::error($e);
    }
});

/* new routes under construction */

$app->route('/faq', function(){
    echo Flight::get('twig')->render('FAQ/index.html.twig',
        array('active' => 'faq')
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
