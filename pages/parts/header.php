<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="ru" xmlns="http://www.w3.org/1999/html"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo htmlspecialchars (PageInfo::getTitle()); ?></title>
    <?php echo '<meta name="description" content="'.htmlspecialchars(PageInfo::getDescription()).'"/>' ?>

    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="shortcut icon" href="/img/favicon.ico">
    <link rel="stylesheet" href="/css/main.css" type="text/css" media="screen">
    <link href='http://fonts.googleapis.com/css?family=PT+Sans|Roboto&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <script src="/js/libs/jquery-1.9.1.min.js"></script>
    <script src="/js/libs/modernizr-2.5.3.js"></script>
    <script src="/js/libs/prefixfree.min.js"></script>
    <script src="/js/libs/validate.js"></script>
    <?php echo PageInfo::getIncludeSlider() ? '<script src="/js/libs/js-image-slider.js"></script>'."\n" : '' ?>
    <script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
    <?php echo PageInfo::getExtraHeader(); ?>
</head>
<body>
<div class="body_shadow">