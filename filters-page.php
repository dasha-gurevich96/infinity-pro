<?php
/**
 * Infinity Pro.
 * 
 * Template Name: Page with filters
 *
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
	$classes[] = 'inner-page filters-page news larger-width';
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
	if($select_banner_type === 'two columns') {
		get_template_part('/components/banner_two_columns');
	} else {
		get_template_part('/components/banner_strip');
	}
	
}

add_action( 'genesis_entry_content', 'banner');

add_action( 'genesis_entry_content', 'custom_content' );
function custom_content() {
	$select_banner_type = get_field('select_banner_type');
	$filters = get_field('filters_shortcode');
	$results = get_field('results_shortcode');
	$content = apply_filters('the_content', get_the_content());
	
	if($select_banner_type === 'colour strip' && !empty($content)) {
		?>
	<div class="full-container">
	

		<div class="custom-container">
	<div class="limited-width">
		<?php the_content();?>
			</div>
			
		
		</div>
	</div>
<?php 
	
	
	
	}
		if(!empty($filters) || !empty($results)) {
			?><div class="full-container">
			<div class="custom-container">
				<?php if(!empty($filters)) {
				?><div class="filters-container position-relative">
				
				</div><div class="filters">
				<?php echo do_shortcode($filters);?>
				</div>
			
			
			
				<?php
			} 
		
				
			if(!empty($results)) {
				?><div class="results-container">
				<?php echo do_shortcode($results);?>
				<?php echo do_shortcode(get_field('load_more_shortcode'));?>
				</div>
				<?php
			}
			?>
			</div>
				</div>
			<?php
		}
	if(have_rows('page_components')) {
		?><div class="page-component">
	<?php
		while(have_rows('page_components')) {
			the_row();
			if(get_row_layout() === 'text') {
				get_template_part('/components/text-flat');
			} elseif (get_row_layout() === 'section_heading') {
				get_template_part('/components/section_title');
			} elseif (get_row_layout() === 'section_with_cards') {
				get_template_part('/components/section-cards');
			} elseif (get_row_layout() === 'current_projects') {
				get_template_part('/components/current_projects');
			} elseif (get_row_layout() === 'quotes') {
				get_template_part('/components/quote');
			} elseif (get_row_layout() === 'two_columns_text') {
				get_template_part('/components/two-cols-text');
			} elseif (get_row_layout() === 'two_columns') {
				get_template_part('/components/two-columns');
			}
		}
	?></div><?php
	}
	?>

	
<?php

}

genesis();