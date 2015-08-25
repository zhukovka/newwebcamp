<?php
PageInfo::setTitle("Отзывы о курсах программирования от школы Webcamp в Киеве ");
PageInfo::setMenuItem("Отзывы");
Parts::renderStartPage();
?>
<div class="feedback_content">
    <?php
        $feedbacks = StudentFeedbacks::getAllFeedbacks();
        for($i = 0; $i < count($feedbacks); $i++) {
            $feedback = $feedbacks[$i];
    ?>
    <div class="graduate_review_wrapper" id="feedback<?php echo $feedback->id ?>" data-full="<?php echo $feedback->comment ?>">
        <div class="graduate_info_wrapper">
            <ul>
                <li>
                    <span>Прошел курс:</span>
                    <a href="/courses/<?php echo $feedback->course->alias ?>"><?php echo $feedback->course->name ?></a>
                </li>
                <?php
                    $contacts = $feedback->contacts;
                    for($j = 0; $j < count($contacts); $j++) {
                ?>
                <li class="contact" <?php if($j == 0 && $i % 2 == 0) echo ' style="padding-right: 40px;"'?>><?php echo $contacts[$j]->getPresentation(); ?></li>
                <?php } ?>
            </ul>
        </div>
        <div class="graduate_info_border"></div>
        <figure class="graduate_photo_wrapper">
            <img src="images/feedback/<?php echo $feedback->photo ?>" alt="">
            <figcaption><?php echo $feedback->name ?></figcaption>
        </figure>

        <p>
            <span><?php echo $feedback->middleComment ?></span>
            <a class="graduate_review_expand" href="#">показать полностью</a>
        </p>
    </div>
    <?php } ?>
    <script type="text/javascript">
$(function() {

    $('.graduate_review_wrapper').mouseenter(function(){
      var main = $(this),
          el = main.find('.graduate_review_expand'),
          textarea = $('p span', main);
        if(el.hasClass('graduate_review_expand') && !main.hasClass('graduate_review_wrapper_expand')){
            main.data('short', textarea.html());
            console.log(main.data('full'));
            console.log(textarea);
            textarea.html(main.data('full'));
            main.addClass('graduate_review_wrapper_expand');
            el.toggleClass('graduate_review_hide');
            el.toggleClass('graduate_review_expand');
        }
    });

    $('.graduate_review_wrapper').mouseleave(function(){
        var main = $(this),
            el = main.find('.graduate_review_hide'),
            textarea = $('p span', main);
        if(el.hasClass('graduate_review_hide') && main.hasClass('graduate_review_wrapper_expand')){
            console.log(main);
            textarea.html(main.data('short'));
            main.removeClass('graduate_review_wrapper_expand');
            el.toggleClass('graduate_review_hide');
            el.toggleClass('graduate_review_expand');
        }
    });

    $('.graduate_review_expand').click(function(ev) {
        ev.preventDefault();
        var el = $(ev.target),
            main = el.parents('.graduate_review_wrapper'),
            textarea = $('p span', main);

        if(el.hasClass('graduate_review_expand')){
            main.data('short', textarea.html());
            textarea.html(main.data('full'));
        }
        else {
            textarea.html(main.data('short'));
        }
            el.toggleClass('graduate_review_hide');
            el.toggleClass('graduate_review_expand');

        });
});

    </script>
</div>
<?php
Parts::renderEndPage();
?>