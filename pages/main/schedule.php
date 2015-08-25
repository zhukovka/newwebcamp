<?php
PageInfo::setTitle("Расписание курсов программирования в Киеве от школы Webcamp");
PageInfo::setMenuItem("Расписание");
Parts::renderStartPage();
$ru_month_inf = array('январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь' );
$today = date_create();
?>
    <div class="schedule_content">
        <img class="schedule_icons" src="images/schedule/schedule_icons.png" height="183" width="858">
        <ul class="schedule_courses_list">
            <li>
                <div class="scl_courses">Курсы</div>
                <div class="scl_start_date">Дата начала</div>
                <div class="scl_duration">Длительность</div>
                <div class="scl_time">Время занятий</div>
                <div class="scl_pupil_limit">Мест осталось</div>
                <div class="scl_price">Цена</div>
                <div class="scl_sign_up">Записаться</div>
            </li>
            <?php
                foreach(Schedules::getAll() as $schedule) {
                    echo "<li>";
                    echo '<div class="scl_courses"><a href="/courses/'.$schedule->getCourse()->alias.'">'.$schedule->getCourse()->name.'</a></div>'."\n";
                   echo '<div class="scl_start_date">'.($schedule->begin == null ? "По набору" : ((date_diff($today, $schedule->begin)->m >= "1") ? ($ru_month_inf[intval($schedule->begin->format('m'))-1]." ".$schedule->begin->format('Y')) : $schedule->begin->format('d.m.Y')))."</div>\n";
                    echo '<div class="scl_duration">'.$schedule->getDurationWeeks()."</div>\n";
                    echo '<div class="scl_time">'.$schedule->weekDays->toString()."<br/>".$schedule->timeFrom->toString().'-'.$schedule->timeTo->toString()."</div>\n";
                    echo '<div class="scl_pupil_limit">'.$schedule->left."</div>\n";
                    echo '<div class="scl_price">'.$schedule->price.(!is_string($schedule->price) ? ' грн.' : '')."</div>\n";
                    echo '<div class="scl_sign_up"><a class="assign_to_course" href="#" rel="#sign_up_form" data-course="'.$schedule->getCourse()->alias.'">записаться</a></div>'."\n";
                    echo "</li>";
                }
            ?>
        </ul>
    </div>
<?php Parts::renderEndPage() ?>