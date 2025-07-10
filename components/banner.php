<?php 
$purple_banner = get_field('purple_banner');
$text = $purple_banner['text'];
$logo = $purple_banner['logo'];
$class ='';
if(!empty($logo) && !empty($text)) {
    $class ='grid-container';
}
	?><div class="inner-banner">
        <div class="custom-container">
            <h1><?php the_title();?></h1>
            <?php 
            if(!empty($text) || !empty($logo)) {
                ?>
                <div class="<?php echo $class;?>">
                    
                        <?php if(!empty($text)) {
                            ?> <div class="text-col"><?php
                            echo $text;
                            ?>  </div><?php
                        }
                        ?>
                   <?php if(!empty($logo) && !empty($text)) {
                        ?> <div class="img-col">
                            <div class="img-logo-container position-relative">
                                <img class="diamond" src="/wp-content/uploads/2025/06/Graphic_whtite-diamond.svg" alt="" />
                                <img class="logo-banner" src="<?php echo $logo['url'];?>" alt="<?php echo $logo['alt'];?>" />
                            </div>
                    <?php
                   }
                   ?>
                    
                    </div>
                </div>

                <?php
            }
            ?>
        </div>
    </div>
    <img class="banner-wave" src="/wp-content/uploads/2025/07/banner_wave_about.svg" alt="" />
    <?php



