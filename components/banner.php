<?php 
$purple_banner = get_field('purple_banner');
$text = $purple_banner['text'];
$logo = $purple_banner['logo'];
	?><div class="inner-banner">
        <div class="custom-container">
            <h1><?php the_title();?></h1>
            <?php 
            if(!empty($text) || !empty($logo)) {
                ?>
                <div class="grid-container">
                    <div class="text-col">
                        <?php if(!empty($text)) {
                            echo $text;
                        }
                        ?>
                    </div>
                    <div class="img-col">
                        <div class="img-logo-container position-relative">
                            <img class="diamond" src="/wp-content/uploads/2025/06/Graphic_whtite-diamond.svg" alt="" />
                            <img class="logo-banner" src="<?php echo $logo['url'];?>" alt="<?php echo $logo['alt'];?>" />
                    </div>
                    </div>
                </div>

                <?php
            }
            ?>
        </div>
    </div>
    <img src="/wp-content/uploads/2025/07/banner_wave_about.svg" alt="" />
    <?php



