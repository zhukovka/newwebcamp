<?php
$message = '<head>
	<meta charset="UTF-8">
	<title>Регистрация на курсы программирования WebCamp</title>
	</head>
<body>
	
	<div class="content">
		<h3>Добрый день, '. $_POST[applicant_name] .'</h3>
		<p>Спасибо, что записались на <strong>'.$_POST[applicant_course].'</strong> от Webcamp.</p>
		<p>Очень скоро мы свяжемся с вами и сообщим вам детали.</p>
	</div>
	<div id="footer">
		<div>
			<ul>
			 	<li>097-2555106 Елена (доступно через Viber)</li>
			 	<li>063-7078513 Андрей (доступно через Viber)</li>
			</ul>
		</div>
		<div>
			<ul>
				 	<li>Скайп: webcamp.welcome</li>
				 	<li>info@webcamp.com.ua</li>
			</ul>
		</div>
	</div>
	
</body>
</html>';
$headers = 'Content-type: text/html; charset=utf-8' . "\r\n";

$course = Courses::getCourse("php-advanced");

$message1 = $_POST[applicant_name]."\n".$_POST[applicant_phone]."\n".$_POST[applicant_email]."\n".$_POST[applicant_course]."\n".$_POST[applicant_channel]."\n".$_POST[applicant_message];
$headers1 = 'To: Helen <register@webcamp.com.ua>' . "\r\n";
$headers1 .= 'From:'.$_POST[applicant_email]. "\r\n";



    mail("register@webcamp.com.ua", "Новый абитуриет", $message1, $headers1);
    if($_POST[applicant_email]) {
        mail("$_POST[applicant_email]", "Регистрация на курсы программирования WebCamp", $message, $headers);
    }
?>