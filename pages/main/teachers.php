<?php
PageInfo::setTitle("Преподаватели курсов программирования в Киеве от школы Webcamp");
PageInfo::setMenuItem("Преподаватели");
Parts::renderStartPage();
?>
<div class="trainers_content">
    <?php
        $teachers = Teachers::getAllTeachers();
        for($i = 0; $i < count($teachers); $i++) {
           $teacher = $teachers[$i];
    ?>
    <div class="trainers_description_wrapper">
        <div class="trainers_name"><?php echo $teacher->name ?></div>
        <figure class="trainers_photo_wrapper">
            <img src="/images/trainers/<?php echo $teacher->photo ?>" alt="">
        </figure>
        <div class="trainers_courses">
            <h6>Преподает курс<?php echo count($teacher->courses) > 1 ? "ы" : ""?>:</h6>
            <ul>
                <?php
                    for($j = 0; $j < count($teacher->courses); $j++) {
                        $course = $teacher->courses[$j];
                ?>
                <li><a href="/courses/<?php echo $course->alias ?>"><?php echo $course->name ?></a></li>
                <?php
                    }
                ?>
            </ul>
        </div>
        <p>
            <?php echo $teacher->description; ?>
        </p>
    </div>
    <?php } ?>
</div>
<?php Parts::renderEndPage(); ?>