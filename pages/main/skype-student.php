<?php
PageInfo::setTitle("Skype-студент");
PageInfo::setMenuItem("Акции");

Parts::renderStartPage();
?>

<html>
<head>
    <title></title>
</head>

<body>
    <div class="promotions_content">
        <section class="course_description_section">
            <div class="cds_course_name_wrapper">
                <h1 class="skype-student">Skype-студент</h1>
            </div>

            <div class="cds_next_course_info_row">
                <!-- yellow sticker left   -->

                <div class="cds_nearest_group yellow_sticker">
                    <h4 class="mbm">Может записаться на любой курс</h4>

                    <p class="data_row small_row">Посещает занятие с реальной группой</p>

                    <p></p>

                    <p class="data_row small_row">Получает знания и поддержку на уровне с остальными студентами</p>
                </div><!-- green   sticker    center      -->

                <div class="cds_nearest_group green_sticker">
                    <h4 class="mbm">Скидка 25%</h4>

                    <p class="data_row small_row">Все skype-студенты платят на 25% меньше</p>
                </div><!-- yellow sticker right   -->

                <div class="cds_nearest_group yellow_sticker">
                    <h4 class="mbm">Требования к кандидату</h4>

                    <p class="data_row small_row">Наличие ноутбука (компьютера)</p>

                    <p class="data_row small_row">Наличие интернет соеденения</p>

                    <p class="data_row small_row">Желание учиться</p>

                    <p class="data_row small_row">Готовность выполнять задания</p>
                </div>
            </div><script type="text/javascript">
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

            <div class="cds_course_intro_wrapper">
                <div class="cds_left_column">
                    <div class="cds_sign_up_box">
                        <a class="assign_to_course" href="#" rel="#sign_up_form">Записаться</a>
                    </div>

                    <h3 class="audience_header">Для кого</h3>

                    <p>Стать <strong>skype-студентом в Webcamp</strong> может любой желающий записаться на один из курсов <strong>Webcamp</strong>.</p>
                    <p>
	                    Как и другие студеты, <strong> skype-студент в Webcamp</strong> может выучить <a href="http://www.webcamp.com.ua/courses/php-basic">php</a>, <a href="http://www.webcamp.com.ua/courses/frontend-basic">frontend</a> или <a href="http://www.webcamp.com.ua/courses/java-basic">java</a>. 
                    </p>

                    <h3 class="knowledge_header">Вместе с группой вы сможете</h3>

                    <ul>
                        <li>Участвовать на занятии</li>
                        <li>Получать задание</li>
                        <li>Получать помощь в выполнении задании</li>
                    </ul>
                </div>

                <div class="cds_right_column">
                    <h3 class="description_header">Как использовать Skype?</h3>

                    <p>Для того, чтобы получить знания как <strong>skype-студент в Webcamp</strong> вам нужно:</p>

                    <ul class="circle_list_img">
                        <li>Записаться на курс и указать, что вы хотите быть <strong>skype-студентом в Webcamp</strong></li>

                        <li>За день до начала курса, согласно рассписанию, связаться по skype с администрацией по skype адресу <a href="skype:webcamp.welcome?chat" style="text-decoration:none; color:#484848">webcamp.welcome</a> и провести тестовое участие</li>

                        <li>Оплатить стоимость курса со скидкой в 25%</li>

                        <li>Учиться на уровне со всеми студентами</li>

                    </ul>

                    <p>Даже если вы не имеете возможности приехать к нам на занятия, вы всегда сможете получить знания и помощь в учебе, которые студенты <strong>Webcamp</strong> получают от наших опытных преподавателей.</p>
                </div>
            </div>

            
            
        </section>
    </div><?php Parts::renderEndPage() ?>
</body>
</html>
