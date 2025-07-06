<?php

 /**
 * Infinity Pro.
 *
 * This file adds the main page template to the Infinity Pro Theme.
 * 
 * Template Name: Page with filters
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
	$classes[] = 'filters-page inner-page';
	return $classes;

}

function banner() {
    get_template_part('/components/banner_plain');

}


add_action( 'genesis_entry_header', 'banner');

add_action( 'genesis_entry_content', 'custom_content' );

function custom_content() {
    $title = get_field('title_above_filters');
    $filters = get_field('filters');
    $submit_buttons = get_field('submit_buttons');
    $results = get_field('results_shortcode');

    if(!empty($filters) && !empty($submit_buttons)) {
        ?><div class="filters-box">
            <?php 
             if(!empty($title)) {
                ?><h2><?php echo $title;?></h2><?php
            }
            ?><div class="filters">
                <?php echo do_shortcode($filters);?>
            </div>
            <div class="buttons">
                <?php echo do_shortcode($submit_buttons);?>
            </div>
  
            </div>
            <?php
       
    }

    if(!empty($results)) {
        ?><div class="results">
            <?php echo do_shortcode($results);?>
            </div>
            <?php
    }

}

genesis();