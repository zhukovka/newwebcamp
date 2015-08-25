<?php
function renderMenuItem($name, $class, $href) {
    echo '<li class="'.$class.(strcmp($name, PageInfo::getMenuItem()) == 0 ? " active" : "").'"><a href="'.$href.'">'.$name.'</a></li>'."\n";
}
?>
    <div id="skip-link"><a href="#main-menu">Jump to Navigation</a></div>
    <div class="main_page_wrapper">
        <div class="main_header_wrapper">
            <header class="main_header">
                <a href="/" class="main_logo">Webcamp курсы программирования.Вы будете подготовлены!</a>
                <div class="main_logo_bubble">&nbsp;</div>
                <div class="main_header_contacts_box">
                    <ul class="first_column">
                        <li class="mhc_phone"></li>
                        <li class="mhc_email">info@webcamp.com.ua</li>
                    </ul>
                    <ul class="second_column">
                        <li class="mhc_phone"></li>
                        <li class="mhc_skype"><a href="skype:webcamp.welcome?chat" style="text-decoration:none; color:#484848">webcamp.welcome</a></li>
                    </ul>
                </div>
                <div class="main_header_sign_up_box">
                    <a href="#" rel="#sign_up_form" class="assign_to_course">Записаться</a>
                </div>
            </header>
        </div>
        <nav class="main_nav">
            <ul class="main_nav_list">
                <?php renderMenuItem("Домашняя", "mnl_home", "/") ?>
                <?php renderMenuItem("О нас", "mnl_about_us", "/aboutus") ?>
                <?php renderMenuItem("Курсы", "mnl_courses", "/courses") ?>
                <?php renderMenuItem("Акции", "mnl_promotions", "/promotions") ?>
                <?php renderMenuItem("Расписание", "mnl_schedule", "/schedule") ?>
                <?php renderMenuItem("Преподаватели", "mnl_teachers", "/teachers") ?>
                <?php renderMenuItem("Отзывы", "mnl_studentfeedback", "/studentfeedback") ?>
                <?php renderMenuItem("Контакты", "mnl_contacts", "/contacts") ?>
            </ul>
        </nav>