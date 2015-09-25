<div class="slider">
    <div class="slider__content">
        <ul class="slides">
            <li class="slide slide_1">
                <div class="gradient">
                    <div class="grid">
                        <div class="slide__content grid__left w-30">
                            <h3>Практика в IT</h3>

                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat id ipsum iure
                                laudantium, nihil obcaecati possimus ratione sapiente sed voluptas!</p>
                            <a href="" class="btn-more">Подробнее</a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="slider__controls">
        <?php
        $slides = Slides::getAll();
        for ($i = 0; $i < count($slides); $i++) {
            echo $slides[$i]->alias;
            echo $slides[$i]->icon;
//            if($i != 0 && $i % 3 == 0) {
//                echo "</div>";
//                echo '<div class="slides_raw">';
//            }
//            renderSlidePane($slides[$i]);
        }
        ?>
    </div>
</div>