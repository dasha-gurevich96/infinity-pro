<?php

 /**
 * Infinity Pro.
 *
 * This file adds the main page template to the Infinity Pro Theme.
 * 
 * Template Name: Contact 
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
	$classes[] = 'who-page contact-page inner-page';
	return $classes;

}

function banner() {
	get_template_part('/components/banner');
}


add_action( 'genesis_entry_header', 'banner');

add_action( 'genesis_entry_content', 'custom_content' );

function custom_content() {
    $text = get_field('text');
    $text_above_cards = get_field("text_above_cards");
    $text_above_form = get_field("text_above_form");


    if(have_rows('components')) {
		?>
	<?php
		while(have_rows('components')) {
			the_row();
			if (get_row_layout() === 'collapsibles') {
				get_template_part('/components/collapsibles');
			}
		}
	?><?php
	}
if(!empty($text_above_cards) || have_rows('cards')) {
    ?><div class="full-container">
        <div class="custom-container">
            <?php if(!empty($text_above_cards)) {
                ?><div class="text-cards">
                    <?php echo $text_above_cards;?>
                    <?php
            }
     
    if(have_rows('contact_cards')) {
        ?><div class="contact cards cards">
            <?php while(have_rows('contact_cards')) {
                the_row();
                $icon = get_sub_field('icon');
                $text = get_sub_field('text');
                $title = get_sub_field('title');
                if(!empty($icon) && !empty($text)) {
                    ?><div class="card contact-card">
                        <img class="icon" src="<?php echo $icon['url'];?>" alt="<?php echo $icon['alt'];?>" />
                        <div>
                            <?php if(!empty($title)) {
                                ?><h3><?php echo $title;?></h3><?php
                            }
                         echo $text;
                         ?>
                </div>
                        </div>
                    <?php
                }
            }
            ?>
        </div>
        <?php
    }
    ?></div>
    </div>
    <?php
}
?><div class="full-container">
    <div class="custom-container text-above-form mt-5 mb-5">

        <div id="error-summary" class="error-summary" role="alert" style="" tabindex="-1">
        <h2 id="error-summary-title">Please fix the following errors:</h2>
        <ul></ul>
        </div>
</div>
    <div class="custom-container form-container">
        <div class="form-text mb-5">
        <div class="text">
        <?php echo $text_above_form;?>
        </div>
         </div>
        <?php echo do_shortcode('[fluentform id="1"]');?>
</div>
</div>
<?php

}


genesis();