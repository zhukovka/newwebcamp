<?php
PageInfo::setTitle("Курсы WEB программирования для начинающих в Киеве от школы программировния Webcamp");
PageInfo::setMenuItem("Домашняя");
PageInfo::setExtraHeader('<script type="text/javascript" src="http://vk.com/js/api/openapi.js?88"></script>');
Parts::renderStartPage();
?>
    <div class="ind_slider">
        <a href="/schedule">
            <div class="slide_1">
            </div>
        </a>
    </div>
    <div class="ind_content">
        <div class="ind_vk_widget_wrapper">
            <!-- VK Widget -->
            <div id="vk_groups"></div>
            <script type="text/javascript">
                VK.Widgets.Group("vk_groups", {mode: 0, width: "445", height: "271"}, 52282841);
            </script>
        </div>
        <div class="ind_feedback_wrapper">
            <h6 class="ind_graduate_review_header">
                <div class="ind_graduate_reviews_tumbler">
                    <a class="up">вверх</a>
                    <a class="down">вниз</a>
                </div>
                <a href="/studentfeedback">Отзывы выпускников</a>
            </h6>
            <ul class="ind_graduate_review_list" data-current="0">
                <?php
                    PageInfo::setExtraData(0);
                    include_once("api-feedback.php");
                ?>
            </ul>
        </div>
        <script type="text/javascript">
            $(function() {
                var loader = function(up) {
                    var feedbacks = $('.ind_graduate_review_list'),
                            current = feedbacks.data('current') + (up ? -2 : 2);

                    feedbacks.data('current', current);
                    $.ajax({
                        url: "/api/feedback/" + (current === 0 ? "00" : current),
                        success: function(data) {
                            feedbacks.animate({opacity: 0.1}, 100);
                            setTimeout(function() {
                                feedbacks.animate({opacity: 1}, 100);
                                feedbacks.html(data);
                            }, 100);
                        },
                        dataType: 'html'
                    });
                    return false;
                }
                $(".ind_graduate_review_header .up").click(function() { loader(true);})
                $(".ind_graduate_review_header .down").click(function() { loader(false);})
            });
        </script>
        <div id="facebook-widget">
            <div class="fb-like-box" data-href="https://www.facebook.com/webcampstudy" data-width="445" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = "//connect.facebook.net/uk_UA/all.js#xfbml=1";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            </script>
        </div>
    </div>
<?php Parts::renderEndPage(); ?>