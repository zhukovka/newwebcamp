<?php
$from = PageInfo::getExtraData();
$feedbacks = StudentFeedbacks::getFrom($from);
for($i = 0; $i < count($feedbacks); $i++) {
    $feedback = $feedbacks[$i];
    ?>
    <li class="ind_graduate_review">
        <figure class="ind_reviewer_photo_wrapper">
            <img src="images/feedback/<?php echo $feedback->photo ?>" alt="">
        </figure>
        <p>
            <?php echo $feedback->shortComment?>
            <a href="/studentfeedback?#feedback<?php echo $feedback->id ?>" data-text="<?php echo $feedback->shortComment?>" class="ind_read_more">читать отзыв полностью</a>
        </p>
    </li>
<?php } ?>