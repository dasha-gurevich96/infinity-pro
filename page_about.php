<?php

 /**
 * Infinity Pro.
 *
 * This file adds the main page template to the Infinity Pro Theme.
 * 
 * Template Name: About
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
	$classes[] = 'about-page inner-page';
	return $classes;

}

function banner() {
	?><div class="inner-banner">
        <div class="custom-container">
            <h1><?php the_title();?></h1>
        </div>
    </div>
    <img src="/wp-content/uploads/2025/07/banner_wave_about.svg" alt="" />
    <?php
}


add_action( 'genesis_entry_header', 'banner');

add_action( 'genesis_entry_content', 'custom_content' );

function custom_content() {
    $title = get_field('title');
    $text_on_the_left = get_field('text_on_the_left');
    $image = get_field('image');
    $text_in_yellow_box = get_field('text_in_yellow_box');
    if(!empty($text_on_the_left) && !empty($image)) {
        ?><div class="full-container">
            <div class="custom-container">
                <?php if(!empty($title)) {
                    ?><h2 class="text-center inner-page-title"><?php echo $title;?></h2><?php
                }
                ?>
              
            
            <div class="grid two-columns">
                <div class="text-col">
                    <?php echo $text_on_the_left;?>
            </div>
                <div class="img-col">
                    <img src="<?php echo $image['url'];?>" alt="<?php echo $image['alt'];?>" />
                    <?php if(!empty($text_in_yellow_box)) {
                        ?>
                        <div class="yellow-box">
                            <img alt="" src="/wp-content/uploads/2025/06/Decorative-Triangle_green.svg" class="triangle">
                            <?php echo $text_in_yellow_box;?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            </div>

    <?php
    }
}

genesis();