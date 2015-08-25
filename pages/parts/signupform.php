<div id="sign_up_form" class="dialog_box">
    <form class="sign_up_form" action="" method="post" name="sign_up_form">
        <a class="close_form">&nbsp;</a>
        <div class="sign_up_inputs">
            <div class="applicant_name_wrapper">
                <label for="applicant_name">ФИО</label>
                <input type="text" id="applicant_name" name="applicant_name" autocomplete="off" autofocus="autofocus" required="required" placeholder="Иванов Иван"/>
            </div>
            <div class="applicant_phone_wrapper">
                <label for="applicant_phone">Телефон</label>
                <input type="text" id="applicant_phone" name="applicant_phone" required="required" placeholder="0637078513"/>
            </div>
            <div class="applicant_email_wrapper">
                <label for="applicant_email">Email</label>
                <input type="email" id="applicant_email" name="applicant_email" required="required" placeholder="info@webcamp.com.ua"/>
            </div>
            <div class="applicant_course_wrapper">
                <label for="applicant_course">Курс</label>
                <select class="select" id="applicant_course" name="applicant_course">
                    <option value="wonders">Еще не определился</option>
                    <?php
                        $courses = Courses::getAll();
                        foreach($courses as $course) {
                            echo '<option '.($course === PageInfo::getCurrentCourse() ? 'selected="true"' : '').
                                ' value="'.$course->alias.'">'.$course->name.'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="applicant_channel_wrapper">
                <label for="applicant_channel">Как нас нашли</label>
                <select class="select" id="applicant_channel" name="applicant_channel">
                    <option value="google">Google</option>
                    <option value="advise">Посоветовали</option>
                    <option value="yandex">Яндекс</option>
                    <option value="fb">Facebook</option>
					<option value="itjam">Узнали на ITJam</option>
                    <option value="another">Другое</option>
                </select>
            </div>
            <div class="applicant_message_wrapper">
                <label for="applicant_message">Комментарии</label>
                <textarea id="applicant_message" name="applicant_message" rows="10" cols="45" placeholder="Мне Вас посоветовал друг ..."></textarea>
            </div>
            <div class="applicant_form_submit_wrapper">
                <button type="submit" class="send_sign_up_form -visor-no-click" onclick="_gaq.push(['_trackEvent', 'Регистрация', 'Записаться'])">Записаться</button>
            </div>
        </div>

        <div class="sign_up_form_message" id="signUpSuccessMes">
            <span class="assigner_name"></span>, спасибо! Ваша заявка отправлена!
            Мы свяжемся с Вами в ближайшее время!
        </div>
        <div class="sign_up_form_message" style="color:red" id="signUpValidation">

        </div>
    </form>
    <script type="text/javascript">
        function selectCourse(curCourse) {
            $("#applicant_course option").removeAttr("selected");
            $("#applicant_course option[value='" + curCourse + "']").attr("selected", "true");
            $("#applicant_course").change();
        }

        $(document).ready(function(){
            $(".assign_to_course").overlay({
                top:-165,
                close:".close_form",
                fixed:false,
                // some mask tweaks suitable for modal dialogs
                mask: {
                    color: '#ebecff',
                    loadSpeed: 200,
                    opacity: 0.9
                },
                closeOnClick: true,
                onBeforeClose: function(){
                    $(".sign_up_form_message").hide();
                },
                onBeforeLoad:function(){
                    var curCourse = this.getTrigger().attr("data-course");
                    if(curCourse) {
                        selectCourse(curCourse);
                    }
                    <?php
                        echo PageInfo::getCurrentCourse() == null ? 'else { selectCourse("wonders"); } ' : '';
                    ?>
                    $(".sign_up_inputs").show();
                    $(".sign_up_form_message").hide();

                }
            });

            $(".send_sign_up_form").click(function(e){
                e.preventDefault();
                $("#signUpValidation").text("");
                var emailRegex = /^[a-zA-Z0-9.!#$%&amp;'*+\-\/=?\^_`{|}~\-]+@[a-zA-Z0-9\-]+(?:\.[a-zA-Z0-9\-]+)*$/,
                    alphaRegex = /^[a-zа-я]+$/i,
                    alphaNumericRegex = /^[a-zA-Z0-9а-яА-ЯєЄїЇіІ' ]+$/i,
                    numericDashRegex = /^[\d\- \s]+$/,
                    errors = 0;

                if(!$("#applicant_phone").val() && !$("#applicant_email").val()) {
                    $("#signUpValidation").html($("#signUpValidation").html() + "Введите, пожалуйста, свой телефон или Email. <br/>").show();
                    errors += 1;
                }

                if(!emailRegex.test($("#applicant_email").val())){
                     $("#signUpValidation").html($("#signUpValidation").html() + "Введите, пожалуйста корректный Email.  <br/>").show();
                     errors += 1;
                }

                if(!alphaNumericRegex.test($("#applicant_name").val())) {
                     $("#signUpValidation").html($("#signUpValidation").html() + "Введите, пожалуйста корректное ФИО.  <br/>").show();
                     errors += 1;
                }

                if(!numericDashRegex.test($("#applicant_phone").val())) {
                     $("#signUpValidation").html($("#signUpValidation").html() + "Введите, пожалуйста корректный номер телефона.  <br/>").show();
                     errors += 1;
                }

                if(errors > 0){
                    return;
                }

                else {
                    $("#signUpValidation").hide();
                }

                var data = $(".sign_up_form").serialize();
                $.ajax({
                    type: "POST",
                    url: "/registernew",
                    data: data,
                    success: function(data){
                        $(".assigner_name").text($("#applicant_name").val());
                        $(".sign_up_inputs").hide();
                        $("#signUpSuccessMes").show();
                    },
                    dataType: "html"
                });
            });

            $('select.select').each(function(){
                var title = $(this).attr('title');
                if( $('option:selected', this).val() != ''  ) title = $('option:selected',this).text();
                $(this)
                    .css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
                    .after('<span class="select">' + title + '</span>')
                    .change(function(){
                        val = $('option:selected',this).text();
                        $(this).next().text(val);
                    })
            });
        });
    </script>
</div>