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
	$select_banner_type = get_field('select_banner_type');
	if($select_banner_type === 'with-detail') {
		get_template_part('/components/banner');
	} else {
		get_template_part('/components/banner_plain');
	}

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
                            <img alt="" src="/wp-content/uploads/2025/07/Decorative-Triangle-2_Decorative-Triangle_green.svg" class="triangle">
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

    if(have_rows('components')) {
		?><
	<?php
		while(have_rows('components')) {
			the_row();
			if (get_row_layout() === 'collapsibles') {
				get_template_part('/components/collapsibles');
			}
		}
	?><?php
	}
}

genesis();