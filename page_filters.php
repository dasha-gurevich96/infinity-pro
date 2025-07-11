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
    $selected_fields = get_field('selected_fields');
    $hide_filters = get_field('hide_filters');
    $text_in_filters = get_field('text_in_filters');
    ?>
    <div class="pattern-right">
        </div>
    <div class="pattern-left">
        </div>
        <?php

    if(!empty($filters) && !empty($submit_buttons)) {
        ?>
        <div class="full-container">
            <div class="custom-container">
        <div class="filters-box">
            <?php 
             if(!empty($title)) {
                ?><h2><?php echo $title;?></h2><?php
            }
            if(!empty($text_in_filters)) {
                ?><div class="text mt-5 mb-5">
                    <?php echo $text_in_filters;?>
                    </div>
                <?php
            }
            ?>
            <?php if(!$hide_filters) {

            
            ?>
            <div class="filters">
                <?php echo do_shortcode($filters);?>
            </div>
            <div class="buttons">
                <?php echo do_shortcode($submit_buttons);?>
            </div>
            <?php if(!empty($selected_fields)) {
                ?><div class="selected-fields">
                    <p class="screen-reader-text">Select each button to remove it from filters</p>
                    <?php echo do_shortcode($selected_fields);?>
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

    if(!empty($results)) {
        ?><div class="full-container"><div class="custom-container">
            <div class="results">
            <?php echo do_shortcode($results);?>
            </div>
    </div>
    </div>
            <?php
    }

}

genesis();