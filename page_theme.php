<?php

 /**
 * Infinity Pro.
 *
 * This file adds the main page template to the Infinity Pro Theme.
 * 
 * Template Name: Theme
 *
 *
 * @package Infinity
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/infinity/
 */

remove_action('genesis_entry_content', 'genesis_do_post_content');
remove_action('genesis_entry_header', 'genesis_do_post_title');
// Add landing page body class to the head.
add_filter( 'body_class', 'infinity_add_body_class' );
function infinity_add_body_class( $classes ) {
	$classes[] = 'theme-page inner-page';
	return $classes;

}

function banner() {
	get_template_part('/components/banner_plain');
}


add_action( 'genesis_entry_header', 'banner');

add_action( 'genesis_entry_content', 'custom_content' );

function custom_content() {

    $banner_text = get_field('banner_text');
    $banner_image = get_field('banner_image');
    $text_above_cards = get_field('text_above_cards');
    $text_above = get_field("text_above");

    if(!empty($banner_text)) {
        ?><div class="full-container yellow-container">
            <div class="custom-container">
                <div class="theme-container">
                    <div class="text-col">
                        <div class="text">
                            <?php echo $banner_text;?>
                        </div>
                        
                    </div>
                    <div class="img-col">
                        <img class="theme-img" src="<?php echo $banner_image['url'];?>" alt="<?php echo $banner_image['alt'];?>" />
                    </div>
                </div>
            </div>
        </div>
        <img src="/wp-content/uploads/2025/06/2025-Theme-Banner_-wave.svg" alt="" class="wave theme-wave" />
    <?php
    }

    if(have_rows('cards')) {
        ?>
        <div class="full-container mt-0">
            <div class="custom-container">
                <div class="heading">
                 <?php echo $text_above_cards;?>
    </div>
                 <div class="cards cards-importance slider-mobile">
                    <?php while(have_rows('cards')) {
                        the_row();
                        $image = get_sub_field('image');
                        $add_background = get_sub_field('add_background');
                        $background_colour = get_sub_field('background_colour');
                        $text = get_sub_field('text');
                        $class = '';
                        if(!empty($background_colour) && !$add_background) {
                            $class = $background_colour;
                        } else {
                            $class ='';
                        }
                        if(!empty($image) && !empty($text)) {
                            ?><div class="card importance-card">
                                <div class="graphics <?php echo $class;?>">
                                    <img src="<?php echo $image['url'];?>" alt = "<?php echo $image['alt'];?>" />
                                </div>
                                <p class="card-text-imp">
                                    <strong>
                                        <?php echo $text;?>
                                    </strong>

                                </p>

                            </div>

                            <?php
                        }

                    }
                    ?>
                </div>
            </div>
        </div>
       
        <?php
    }

    if(!empty($text_above)) {
        ?><div class="full-container">
            <div class="custom-container">
                <?php echo $text_above;?>
                <?php 
                if(have_rows('support')) {
                    ?><div class="diamond-cards">
                        <?php while(have_rows('support')) {
                             the_row();
                             $icon = get_sub_field('icon_2');
                             $text = get_sub_field('text');
                            if(!empty($icon) && !empty($text)) {
                                ?><div class="diamond-card">
                                        <div class="title-diamond icon-diamond">
                                            <img class="icon" src="<?php echo $icon['url'];?>" alt="<?php echo $icon['alt'];?>" />
                                        </div>
                                        <div class="diamond-content">
                                            <?php echo $text;?>
                            </div>
                                 </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <?php
                }

?>
    </div>
            </div>
    <?php
    }

   
?> 
    <?php
    

}

genesis();