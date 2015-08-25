<?php
PageInfo::setTitle("Контакты — курсы программирования в Киеве");
PageInfo::setMenuItem("Контакты");
Parts::renderStartPage();
?>
    <div class="contacts_content">
        <div class="contacts_section">
            <h2>Контакты:</h2>
            <ul class="contacts_section_list">
				<li class="csl_phone">063-4784107 Юлия</li>
                <li class="csl_phone">063-7078513 Андрей</li>
				<li class="csl_phone">097-2555106 Елена</li>
                <li>Все номера доступны через Viber</li>
                <li class="csl_email">e-mail: info@webcamp.com.ua</li>
                <li class="csl_skype">skype: <a href="skype:webcamp.welcome?chat" style="text-decoration:none; color:#484848">webcamp.welcome</a></li>
                <li class="csl_adress">Дарвина, 10, офис 13, Киев</li>
            </ul>
        </div>
        <div class="contacts_map_section">
            <h2>Мы на карте</h2>
            <div class="contacts_map_wrapper">
                <iframe src="https://mapsengine.google.com/map/embed?mid=z1x4DSKne78E.k1HeVJp9_uk0"  width="500" height="314" frameborder="0" style="border:0"></iframe><br /><small><a href="https://goo.gl/maps/fD7MV">Просмотреть увеличенную карту</a></small>
            </div>
        </div>
    </div>
<?php
Parts::renderEndPage();
?>