<?php
function renderCoursePane($course) {
    echo '<a href="/courses/'.$course->alias.'">'."\n".
         '  <img src="/images/courses/'.$course->alias.'.jpg" alt="">'."\n".
         '  <p>'.$course->name.' <small>'.$course->shortDescription.'</small></p>'."\n".
         '</a>'."\n";
}
PageInfo::setTitle("Webcamp — курсы программирования в Киеве");
PageInfo::setMenuItem("Курсы программирования и цены");
Parts::renderStartPage();
?>
    <div class="courses_content">
        <div class="courses_raw">
        <?php
            $courses = Courses::getAll();
            for($i = 0; $i < count($courses); $i++) {
                if($i != 0 && $i % 3 == 0) {
                    echo "</div>";
                    echo '<div class="courses_raw">';
                }
                renderCoursePane($courses[$i]);
            }
        ?>
        </div>
<?php
Parts::renderEndPage();
?>