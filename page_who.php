<?php

 /**
 * Infinity Pro.
 *
 * This file adds the main page template to the Infinity Pro Theme.
 * 
 * Template Name: Who are we
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
	$classes[] = 'who-page inner-page';
	return $classes;

}

function banner() {
	get_template_part('/components/banner');
}


add_action( 'genesis_entry_header', 'banner');

add_action( 'genesis_entry_content', 'custom_content' );

function custom_content() {
    $title = get_field("title");
    $title_w = get_field('title_working_group');
    ?><div class="full-container">
        <div class="custom-container">
            <?php if(!empty($title)) {
                ?><h2 class="text-center"><?php echo $title;?></h2>
                <?php
            }
            if(have_rows('working_group_cards')) {
                ?><div class="group">
                    <?php if(!empty($title_w)) {
                        ?><h2 class="text-center"><?php echo $title_w;?></h2><?php
                    } 
                    while(have_rows('working_group_cards')) {
                        the_row();
                        $name = get_sub_field('name');
                        $role = get_sub_field('role');
                        $bio = get_sub_field('bio');
                        if(!empty($name) && !empty($role)) {
                            ?><div class="bio-card">
                                <div class="column-1">
                                    <div class="logo-diamond-container position-relative">
                                        <img class="diamond" src="/wp-content/uploads/2025/07/Diamond-with-purple-border.svg" alt="" />
                                        <img class="logo" src="/wp-content/uploads/2025/07/SCLD_Logo.svg" alt="" />
                                    </div>
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

genesis();