<?php
/**
 * Infinity Pro.
 *
 * This file adds the single post template to the Infinity Pro Theme.
 * 
 * Template Name: Single Story
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
	$classes[] = 'inner-page story post';

	return $classes;

}

add_action( 'genesis_entry_header', 'custom_genesis_breadcrumbs' );

function custom_genesis_breadcrumbs() {
    ?>
    <div class="screen-reader-text">You are here:</div>
    <nav aria-label="<?php esc_attr_e( 'Breadcrumbs', 'genesis' ); ?>">
        <?php genesis_do_breadcrumbs(); ?>
    </nav>
    <?php
}


function banner() {
	$banner_text_1 = get_field('banner_text_1');
    $banner_text_2 = get_field('banner_text_2');
    ?><div class="full-container banner-yellow">
        <div class="custom-container">
            <h1 class="screen-reader-text">
                <?php the_title();?>
            </h1>
            <?php if(!empty($banner_text_1)) {
                ?><div class="purple-bg banner-text-1">
                  </div>
                <?php
            }
            ?>
        </div>
     <?php
}


add_action( 'genesis_entry_header', 'banner');


genesis();