<?php
define("ROOT", __DIR__ . "/");

require_once ROOT . 'vendor/autoload.php';

try {
    require_once ROOT . 'configs/pdo.php';
    DB::connect();
    $menu = DB::getMenu();
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
$loader = new Twig_Loader_Filesystem(ROOT . 'templates');
$twig = new Twig_Environment($loader);
$twig->addGlobal('title', 'Webcamp');
$twig->addGlobal('menu', $menu);
//var_dump($menu);
//$twig = new Twig_Environment($loader, array(
//    'cache' => ROOT . 'compilation_cache',
//));

$routes = array(
    'index' => 'Home',
    'test' => 'TestController',
    'courses' => 'CoursesController',
    'schedule' => 'ScheduleController'
);


function getPathElements() {
//    var_dump($_SERVER['REQUEST_METHOD']);
    $elements = explode('/',$_SERVER['REQUEST_URI']);
    $ret = array();
    foreach($elements as $el) {
        if ($el) array_push($ret, $el);
    }
    return $ret;
}
function redirect($page) {
    header('Location: http://'.$_SERVER['SERVER_NAME'].($page != null ? '/'.$page : '')) ;
    exit();
}

function goToErrorPage() {
    redirect(null);
}

function movedPermanently($page) {
    header("HTTP/1.1 301 Moved Permanently");
    header('Location: http://'.$_SERVER['SERVER_NAME'].'/'.$page);
    exit();
}

function renderPage($page) {
    $class = $GLOBALS['routes'][$page];
    require_once("pages/$class.php");
    call_user_func("$class::index");
    exit();
}

function compare($str1, $str2) {
    return strcmp($str1, $str2) == 0;
}

function route($matches)
{
    if (!empty($matches)) {
        $first = $matches['first'];
        $second = $matches['second'];
        $class = $GLOBALS['routes'][$first];
        require_once("pages/$class.php");
        if (empty($second)) {
            call_user_func("$class::all");
            exit();
        }
        call_user_func("$class::$first", $second);
    }
    exit();
}

$elements = getPathElements();
if(count($elements) == 0) renderPage("index");
elseif (count($elements) == 1 && array_key_exists($elements[0], $routes)) {
    renderPage($elements[0]);
} elseif (preg_match('/(^\/api\/)(?P<first>courses|schedule)\/{0,1}(?P<second>\w*)/', $_SERVER['REQUEST_URI'], $matches)) {
    if (array_key_exists($matches['first'], $routes)) {
        route($matches);
    }
} elseif (preg_match('/(?P<first>courses|schedule)\/(?P<second>\w*)/', $_SERVER['REQUEST_URI'], $matches)) {
    if (array_key_exists($matches['first'], $routes)) {
        renderPage($matches['first']);
//        echo $twig->render('Courses/index.html.twig');
    }
}
goToErrorPage();
