<?php
/**
 * Infinity Pro.
 *
 * This file adds the main page template to the Infinity Pro Theme.
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
	$classes[] = 'inner-page tech-justice';
	/*$hide_section = get_field('hide_donate_section');
	if($hide_section) {
		$classes[] = 'inner-page main-page border-bottom-page';
	} else {
		$classes[] = 'inner-page main-page';
	}*/

	return $classes;

}

function banner() {
	$select_banner_type = get_field('select_banner_type');
	if($select_banner_type === 'two-columns') {
		get_template_part('/components/banner_two_columns');
	} else {
		get_template_part('/components/banner_strip');
	}

}


add_action( 'genesis_entry_header', 'banner');

add_action( 'genesis_entry_content', 'custom_content' );

function custom_content() {
	$select_banner_type = get_field('select_banner_type');
	$content = apply_filters('the_content', get_the_content());
	
	$thumbnail_id = get_post_thumbnail_id(); // Get the featured image ID
$img_url = wp_get_attachment_image_url($thumbnail_id, 'large'); // Get the image URL
$alt_text = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
	$hide_featured_image = get_field('hide_featured_image');
	if($select_banner_type !== 'two-columns' && !empty($img_url) && !$hide_featured_image) {
		?><div class="full-container">
			<div class="custom-container">
				<img class="resource-banner page-banner w-100 object-fit-cover" src="<?php echo $img_url;?>" alt="<?php echo $alt;?>" />
			</div>
		</div>
<?php
	}
	
	?>


<?php

	if(!empty($content) && $select_banner_type !== 'two-columns') {
		?><div class="full-container">
		<div class="custom-container">
				<?php the_content();?>
		</div>	
	</div>
<?php
	}
	if(get_field('add_quick_links')) {
		
		get_template_part('/components/quick-links-pages');
	}
	if(have_rows('page_components')) {
		?><div class="page-component">
	<?php
		while(have_rows('page_components')) {
			the_row();
			if(get_row_layout() === 'text') {
				get_template_part('/components/text');
			} elseif (get_row_layout() === 'section_heading') {
				get_template_part('/components/section_title');
			} elseif (get_row_layout() === 'section_with_cards') {
				get_template_part('/components/section-cards');
			} elseif (get_row_layout() === 'current_projects') {
				get_template_part('/components/current_projects');
			} elseif (get_row_layout() === 'quotes') {
				get_template_part('/components/quote');
			} elseif (get_row_layout() === 'two_columns') {
				get_template_part('/components/two-columns');
			} elseif (get_row_layout() === 'two-columns-text') {
			
				get_template_part('/components/two-cols-text');
			} elseif (get_row_layout() === 'collapsible_tabs') {
				get_template_part('/components/collapsibles');
			}
		}
	?></div><?php
	}
	if(!empty(get_field('realted_content'))) {
?><div class="page-component"><?php
		get_template_part('/components/related_content');
		?></div><?php
	}
	
}

genesis();