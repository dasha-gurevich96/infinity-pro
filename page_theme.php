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
	$classes[] = 'get-involved-page inner-page';
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

    if(!empty($banner_text)) {
        ?><div class="full-container yellow-container">
            <div class="custom-container">
                <div class="theme-container">
                    <div class="text-col">
                        <?php echo $text;?>
                    </div>
                    <div class="img-col">
                        <img class="theme-img" src="<?php $banner_image['url'];?>" alt="<?php $banner_image['alt'];?>" />
                    </div>
                </div>
            </div>
        </div>
    <?php
    }

   
?> <div class="full-container mb-0">

		<div class="custom-container">
			<div class="transparent-share d-flex gap-3 align-items-center">
				<h3 class="mb-0">Don’t forget to like and share!</h3>
				<?php echo add_social_share_buttons_global();?>
			</div>
		</div>
	</div>
    <?php
    

}

genesis();