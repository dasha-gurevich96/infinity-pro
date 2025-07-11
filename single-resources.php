<?php
/**
 * Infinity Pro.
 *
 * This file adds the single post template to the Infinity Pro Theme.
 * 
 * Template Name: Single Resource
 *
 *
 * @package Infinity
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/infinity/
 */


 remove_action('genesis_entry_content', 'genesis_do_post_content');
remove_action('genesis_entry_header', 'genesis_do_post_title');

remove_action('genesis_entry_content', 'genesis_do_post_content');
remove_action('genesis_entry_header', 'genesis_do_post_title');
// Add landing page body class to the head.
add_filter( 'body_class', 'infinity_add_body_class' );
function infinity_add_body_class( $classes ) {
	$classes[] = 'inner-page event post resource';

	return $classes;

}

function banner() {
	get_template_part('/components/resource-banner');
}


add_action( 'genesis_entry_header', 'banner');

function custom_content() {
    $post_id = get_the_ID(); // or use a specific post ID
	$thumbnail_id = get_post_thumbnail_id($post_id);
	$image_url = wp_get_attachment_url($thumbnail_id);
	$image_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
    $description = get_field('description');
    $contain_image = get_field('contain_image') ? 'object-fit-contain' : 'object-fit-cover';
			$background_colour = get_field('background_colour') ? get_field('background_colour') : 'white';
   
?>
    <div class="pattern-right">
    </div>
    <div class="pattern-left">
    </div>
    
    <div class="custom-container event-container respurce-container">
        <a href="/resources" class="back-to d-flex align-items-center gap-3">
            <img src="/wp-content/uploads/2025/06/Arrow-left.svg" alt="" class="arrow back" />
            <span>Go back to resources</span>
            
        </a>
        <?php if(!empty($image_url)) {
            ?><div class="event-banner" style="background-color: <?php echo $background_colour;?>">
                <img class="banner-img <?php echo $contain_image;?>"  src="<?php echo $image_url;?>" alt="<?php echo $image_alt;?>" />
            </div>
            <?php
        }
        ?>
        <h1><?php the_title();?></h1>
        <div class="eventinfo">
         
       
                   
                <?php
                if(!empty($description)) {
                    ?><div class='event-details'>
                        <?php echo $description;?>
                        </div>
                    <?php
                }
                if(have_rows('components')) {
                    while(have_rows('components')) {
                        the_row();
                        if (get_row_layout() === 'cards') {
                            ?><div class='event-details'><?php
				            get_template_part('/components/cards');
                            ?></div><?php
			            }  elseif (get_row_layout() === 'links') {
                            ?><div class='event-details'><?php
				            get_template_part('/components/links');
                            ?></div><?php
			            }  elseif (get_row_layout() === 'text') {
                            ?><div class='event-details'><?php
				            echo get_sub_field('text');?>
                            </div><?php
			            } 
                    }
                }
            ?>
            
       
            </div>
    </div>
       
<?php

}

add_action( 'genesis_entry_content', 'custom_content');


genesis();