<?php
function renderCourseDescription() {
    include("pages/definitions/courses/".PageInfo::getCurrentCourse()->alias.".php");
}

$ru_month = array( 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря' );
$ru_month_inf = array('январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь' );
$course = PageInfo::getCurrentCourse();
$sch = $course->getNearest();
PageInfo::setTitle("Курс программирования ".$course->name." в Киеве от школы программировния Webcamp");
PageInfo::setMenuItem("Курсы");
PageInfo::setIncludeSlider(true);
PageInfo::setDescription("Курс программирования ".$course->name." в Киеве. ".$course->shortDescription);
Parts::renderStartPage();
?>
    <section class="course_description_section">
        <div class="cds_course_name_wrapper">
            <h1 class="<?php echo $course->alias ?>"><?php echo $course->name ?></h1>
        </div>
        <div class="cds_next_course_info_row">
            <div class="cds_nearest_group yellow_sticker">
                <h4>Ближайшая группа</h4>

                <div class="cds_start_date">
                    <?php
					$begin = $sch->begin;
					$today = date_create();
					if($begin == null) {
						echo '<div class="date"></div><span>По набору группы.</span><br>';
					}
					else {
						if(date_diff($begin, $today)->m >= 1){
							echo '<div class="date" style="margin-top:-15px;">'.$ru_month_inf[intval($begin->format('m'))-1].'</div><br><div class="year">'.$begin->format('Y').'</div>';
						}
						else{

							echo '<div class="date">'.intval($begin->format('d')).'</div><span>'.$ru_month[intval($begin->format('m')) - 1].'</span><br><small class="year">'.$begin->format('Y').'</small>';

						}
					}
				?>
                </div>

                <div class="cds_time">
                    <?php echo $sch->weekDays->toString() ?>
                    <br>
                    <div class="studying_days">
                        <?php echo $sch->timeFrom->hours.'<sup>'.$sch->timeFrom->minutes.'</sup> - '.$sch->timeTo->hours.'<sup>'.$sch->timeTo->minutes.'</sup>' ?>
                    </div>
                </div>

                <div class="cds_pupil_limit">
                    <?php echo $sch->left ?> мест
                </div>
            </div>

            <div class="cds_nearest_group green_sticker">

                <h4  class="mbm">Продолжительность курса</h4>
                <p class="data_row small_row">Длительность: <?php
                echo $sch->getDurationWeeks();
                ?></p>
                <p><?php echo $sch->getClassesInWeek() != null ? '<p class="data_row small_row">Число занятий в неделю: '.$sch->getClassesInWeek().'</p>' : '' ?></p>

                <h4>Цена</h4>

                <p class="price_row"><?php

                	echo $sch->price;
                ?>
                <?php
	                if(!is_string($sch->price)) echo " грн."; ?>
	           </p>
            </div>

             <div class="cds_nearest_group yellow_sticker">
                            <h4 class="mbm">Требования к кандидату</h4>
                            <p class="data_row small_row">Наличие ноутбука</p>
                            <p class="data_row small_row">Желание учиться</p>
                            <p class="data_row small_row">Готовность выполнять задания</p>
                         </div>

        </div>
        <script>
            var sliderOptions =
            {
                sliderId: "promotion-slider",
                effect: "series1",
                effectRandom: true,
                pauseTime: 1500,
                transitionTime: 500,
                slices: 12,
                boxes: 8,
                hoverPause: 0,
                autoAdvance: true,
                captionOpacity: 0.3,
                captionEffect: "fade",
                m: false
            };
            var imageSlider = new mcImgSlider(sliderOptions);
        </script>
        <?php renderCourseDescription() ?>
    </section>
<?php
Parts::renderEndPage();
?>