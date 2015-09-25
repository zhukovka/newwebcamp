<?php
function renderMenuItem($name, $class, $href) {
    echo '<li class="' . $class . (strcmp($name, PageInfo::getMenuItem()) == 0 ? " nav-list__item--active" : "") . '"><a href="' . $href . '">' . $name . '</a></li>' . "\n";
}
?>
<header class="header">
    <div class="header__top">
        <div class="grid pos-r">
            <div class="grid__left w-30">
                <a class="header__logo" href="/"><img src="img/icons/logo.svg" alt=""/></a>
            </div>


            <nav class="header__nav--top w-70">
                <div class="grid__left">
                    <a href="#" rel="#sign_up_form" class="assign_to_course ml-20 btn-enroll">Оформить заявку</a>
                </div>
                <div class="grid__right">
                    <ul class="nav-contacts">
                        <li class="nav-contacts__phone">
                            <span class="text-numbers">+38&nbsp;063&nbsp;707&nbsp;85&nbsp;13</span>
                        </li>
                        <li class="nav-contacts__skype">
                            <a href="skype:webcamp.welcome?chat">skype:&nbsp;webcamp.welcome</a></li>
                    </ul>
                </div>

            </nav>
            <nav class="header__nav--bottom">
                <ul class="nav-list">
                    <!--                <?php //renderMenuItem("Курсы программирования и цены", "mnl_home", "/") ?>-->
                    <?php renderMenuItem("Курсы программирования и цены", "mnl_courses nav-list__item", "/courses") ?>
                    <?php renderMenuItem("Расписание", "mnl_schedule nav-list__item", "/schedule") ?>
                    <!--                --><?php //renderMenuItem("Обучение", "mnl_courses", "/courses") ?>
                    <?php renderMenuItem("Новости", "mnl_promotions nav-list__item", "/promotions") ?>
                    <?php renderMenuItem("Контакты", "mnl_contacts nav-list__item", "/contacts") ?>
                    <?php renderMenuItem("О нас", "mnl_about_us nav-list__item", "/aboutus") ?>
                    <!--                --><?php //renderMenuItem("Акции", "mnl_promotions", "/promotions") ?>
                    <!--                --><?php //renderMenuItem("Преподаватели", "mnl_teachers", "/teachers") ?>
                    <!--                --><?php //renderMenuItem("Отзывы", "mnl_studentfeedback", "/studentfeedback") ?>
                </ul>

            </nav>

        </div>
    </div>
</header>
<!--<div id="skip-link"><a href="#main-menu">Jump to Navigation</a></div>-->
<!--    <div class="main_page_wrapper">-->
<!--        <div class="main_header_wrapper">-->
<!--            <header class="main_header">-->
<!--                <a href="/" class="main_logo">Webcamp курсы программирования.Вы будете подготовлены!</a>-->
<!--                <div class="main_logo_bubble">&nbsp;</div>-->
<!--                <div class="main_header_contacts_box">-->
<!--                    <ul class="first_column">-->
<!--                        <li class="mhc_phone"></li>-->
<!--                        <li class="mhc_email">info@webcamp.com.ua</li>-->
<!--                    </ul>-->
<!--                    <ul class="second_column">-->
<!--                        <li class="mhc_phone"></li>-->
<!--                        <li class="mhc_skype"><a href="skype:webcamp.welcome?chat" style="text-decoration:none; color:#484848">webcamp.welcome</a></li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--                <div class="main_header_sign_up_box">-->
<!--                    <a href="#" rel="#sign_up_form" class="assign_to_course">Записаться</a>-->
<!--                </div>-->
<!--            </header>-->
<!--        </div>-->
