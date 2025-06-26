<?php
/**
 * Infinity Pro.
 *
 * This file adds the single post template to the Infinity Pro Theme.
 *
 *
 * @package Infinity
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/infinity/
 */

function formatDate($date) {
    $timestamp = DateTime::createFromFormat('Ymd', $date);
    return $timestamp ? $timestamp->format('jS F, Y') : "";
}




remove_action('genesis_entry_content', 'genesis_do_post_content');
remove_action('genesis_entry_header', 'genesis_do_post_title');
// Add landing page body class to the head.
add_filter( 'body_class', 'infinity_add_body_class' );
function infinity_add_body_class( $classes ) {
	$classes[] = 'inner-page post news-single resource';
	/*$hide_section = get_field('hide_donate_section');
	if($hide_section) {
		$classes[] = 'inner-page main-page border-bottom-page';
	} else {
		$classes[] = 'inner-page main-page';
	}*/

	return $classes;

}



function banner() {

$class = 'lilac';
$src = '/wp-content/uploads/2025/03/Purple_pattern_small.svg';
?><div class="full-container shaped banner-strip titleless">
	<div class="custom-shape-divider-top banner-top" class="bg-<?php echo $class;?>">
		<svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
			<path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="shape-fill"></path>
		</svg>
	</div>
	<div class="content-shape position-relative <?php echo $class;?>">
		<img class="position-absolute pattern-banner" src="<?php echo $src;?>" />
		<div class="custom-container two-cols-container">
			<?php
			/*if (have_rows('page_title', 84)) {
				while (have_rows('page_title', 84)) {
				the_row();
				$light = get_sub_field('light_part');
				$bold = get_sub_field('bold_part');
				if (!empty($light) && !empty($bold)) {
					?>
					<h1 class="white-shape">
						<?php echo $light; ?>
						<strong><?php echo $bold; ?></strong>
					</h1>
					<?php
				}
			}
		} else {
				?>
					<h1 class="white-shape">
						<?php echo get_the_title(84);?>
					</h1>
				<?php
			}*/
			?>
			
		</div>
	</div>
	<div class="custom-shape-divider-bottom links-shape-bottom">
    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="shape-fill"></path>
    </svg>
</div>
</div>

<?php
}


add_action( 'genesis_entry_header', 'banner');

add_action( 'genesis_entry_header', 'custom_genesis_breadcrumbs_resource' );
function custom_genesis_breadcrumbs_resource() {
    ?>
<div class="custom-container two-cols-container">
	
    <div class="screen-reader-text">You are here:</div>
	<div class="breadcrumb">
		<span>
			<span>
				<a href="/">Home</a>
			</span> > 
			<span><a href="/news/">News</a></span>
			>
			<span class="breadcrumb_last" aria-current="page"><?php the_title();?></span>
			
		</span>
	</div>
</div>
   
    <?php
}

add_action( 'genesis_entry_content', 'custom_content' );			

function custom_content() {
	$image_caption = get_field('image_caption');
		$image_id = get_post_thumbnail_id();
        $image_url = $image_id ? wp_get_attachment_url($image_id) : '';
        $image_alt = $image_id ? get_post_meta($image_id, '_wp_attachment_image_alt', true) : '';
		$terms = get_the_terms(get_the_ID(), 'category');
		$author = get_the_terms(get_the_ID(), 'authors-news');
		
	?><div class="post-content">
			<div class="custom-container two-cols-container heading">
				<div class="content-col">
									<h1>
										<?php the_title();?>
									</h1>
					<?php

					
	?>
					<div class="details">
						
					
	<div class="date">
		<p class="date-p mb-0">
					<?php 
					$date = get_the_date('jS F Y');
					$date = preg_replace('/(\d+)(st|nd|rd|th)/i', '$1<sup style="font-size: 0.6em;">$2</sup>', $date);
					echo $date;

					?>
				</p>
			</div>
					<?php if ($terms && !is_wp_error($terms)) {
						// Create an array to store term IDs
						$term_ids = array();
						?><div class="tags-c mt-0">
					
					<p class="mb-0">
				
					<?php foreach ($terms as $term) {
        				$term_links[] = '<a href="news/?_category=' . $term->slug . '">' . $term->name . '</a>';
    				 }
						echo implode('', $term_links);
						?>
					</p>
					</div>
					<?php

					} ?>
				</div>
				</div>
					<div class="right-content">
						<div class="social-col">


						<h2 class="exclude">
							Share this article
						</h2>
						<?php
						echo add_social_share_buttons_global();
						?>

						</div>
				</div>	
				</div>
		
		<div class="custom-container two-cols-container heading">
			<div class="content-col">
				<div class="authors-date">


				<?php if (!empty($author) && !is_wp_error($author)) {

			?>


					<div class="authors-container">
					<?php foreach ($author as $author_term) { 
						$author_image = get_field('author_image', 'authors-news_' . $author_term->term_id);

					?>
						<div class="author">
							<?php if (!empty($author_image) && isset($author_image['url'], $author_image['alt'])) { ?>
								<div class="img-author">
									<img class="circle object-fit-cover" src="<?php echo esc_url($author_image['url']); ?>" alt="<?php echo esc_attr($author_image['alt']); ?>"/>
								</div>
							<?php } else {
								?>
							<div class="img-author">
									<img class="circle object-fit-cover" src="/wp-content/uploads/2025/03/CAT_logo_horiz_black-1.png" alt=""/>
							</div>
								<?php
							}
				
							?>
							<div class="name-col">
								<p><?php echo esc_html($author_term->name); ?></p>
							</div>
						</div>
					<?php } ?>
				</div>

			<?php
			}
				?>
				
					
		</div>
				<?php
					if(!empty($image_url)) {
							?>
				<div class="banner-caption">
					<img class="resource-banner w-100 object-fit-cover" src="<?php echo $image_url;?>" alt="<?php echo $image_alt;?>" />
					<?php if(!empty($image_caption)) {
								?><div class="caption">
									<?php echo $image_caption;?>
								</div>
					<?php
							}
						?>
				</div>
								

						<?php
						}
				?>
		</div>
			<div class="right-container">
				<?php $add_quick_links = get_field('add_quick_links');?>
				<?php if($add_quick_links) {
					?>
				<div class="quick-links">
						<?php if(have_rows('quick_links')) {
								get_template_part('/components/quick-links-news');
							}
			?>
				</div>
				<?php
				}
				?>
			</div>
			</div>

				
			<div class="custom-container two-cols-container">
				
				<div>
					<?php if(has_excerpt()) {
					?> <p class="short-summary-article">
						<?php echo get_the_excerpt();?>
					</p>
					<?php
						}
	?>
					<?php the_content();?>
				</div>
				
			</div>
			<?php
	if(have_rows('page_components')) {
		?>
	<?php
		while(have_rows('page_components')) {
			the_row();
			if(get_row_layout() === 'text') {
				get_template_part('/components/text-post');
			} elseif (get_row_layout() === 'section_heading') {
				get_template_part('/components/section-title-post');
			} elseif (get_row_layout() === 'buttons') {
				get_template_part('/components/buttons');
			} elseif (get_row_layout() === 'quotes') {
			
				get_template_part('/components/quotes-posts');
			} elseif (get_row_layout() === 'collapsible_tabs') {
				get_template_part('/components/collapsibles');
			}
		}
	?><?php
	}
	get_template_part('/components/related_content_news');
	?>

</div>

<?php


	
}

//remove_action('genesis_before_footer', 'do_back');
genesis();