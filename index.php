<?php
define("ROOT", __DIR__ . "/");

require_once ROOT . 'vendor/autoload.php';

try {
    require_once ROOT . 'configs/pdo.php';
    DB::connect();
//    include_once("pages/code/definitions.php");
//    include_once("pages/code/parts.php");
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

//$menuItems = array
$loader = new Twig_Loader_Filesystem(ROOT . 'templates');
$twig = new Twig_Environment($loader);
$twig->addGlobal('title', 'Webcamp');
//$twig = new Twig_Environment($loader, array(
//    'cache' => ROOT . 'compilation_cache',
//));

$routes = array(
    'index' => 'Home'
);

//echo $twig->render('index.html.twig', array('name' => 'Fabien'));

function getPathElements() {
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
    include("pages/$class.php");
    call_user_func("$class::index");
//    echo $GLOBALS['twig']->render($page . '.html.twig', array('active' => $page));
    exit();
}

function compare($str1, $str2) {
    return strcmp($str1, $str2) == 0;
}

$elements = getPathElements();
if(count($elements) == 0) renderPage("index");
elseif (count($elements) == 1 && array_key_exists($elements[0], $routes)) {
    renderPage($routes[$elements[0]]);

//    if(compare($elements[0], "courses")) renderPage("courses");
//    elseif(compare($elements[0], "aboutus")) renderPage("aboutus");
//    elseif(compare($elements[0], "promotions")) renderPage("promotions");
//    elseif(compare($elements[0], "schedule")) renderPage("schedule");
//    elseif(compare($elements[0], "contacts")) renderPage("contacts");
//    elseif(compare($elements[0], "registernew")) renderPage("registernew");
//    elseif(compare($elements[0], "teachers")) renderPage("teachers");
//    elseif(compare($elements[0], "studentfeedback")) renderPage("studentfeedback");
//    //old html files
//    elseif(compare($elements[0], "about_us.html")) movedPermanently("aboutus");
//    elseif(compare($elements[0], "courses.html")) movedPermanently("courses");
//    elseif(compare($elements[0], "promotions.html")) movedPermanently("promotions");
//    elseif(compare($elements[0], "schedule.html")) movedPermanently("schedule");
//    elseif(compare($elements[0], "contacts.html")) movedPermanently("contacts");
//    elseif(compare($elements[0], "course_description_basic_frontend.html")) movedPermanently("courses/frontend-basic");
//    elseif(compare($elements[0], "course_description_basic_php.html")) movedPermanently("courses/php-basic");
//    elseif(compare($elements[0], "course_description_java.html")) movedPermanently("courses/java-basic");
//    elseif(compare($elements[0], "course_description_advanced_frontend.html")) movedPermanently("courses/frontend-advanced");
//    elseif(compare($elements[0], "course_description_advanced_php.html")) movedPermanently("courses/php-advanced");
//    //test
//    elseif(compare($elements[0], "skype-student")) renderPage("skype-student");
//    elseif(compare($elements[0], "test")) renderPage("test");
}
//elseif(count($elements) == 2) {
//    if(compare($elements[0], "courses")) {
//        if(Courses::contains($elements[1])) {
//            PageInfo::setCurrentCourse(Courses::getCourse($elements[1]));
//            renderPage("course");
//        }
//        redirect("courses");
//    }
//}
//elseif(count($elements) == 3) {
//    if(compare($elements[0], "api")) {
//       if(compare($elements[1], "feedback")) {
//           PageInfo::setExtraData($elements[2]);
//           renderPage("api-feedback");
//       }
//    }
//}
goToErrorPage();
