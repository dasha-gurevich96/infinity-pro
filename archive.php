<?php
/**
 * Template for all taxonomy archives in Genesis.
 */

add_action( 'genesis_before_loop', 'custom_taxonomy_intro' );
function custom_taxonomy_intro() {
	$select_background_colour = get_field('select_background_colour') ? get_field('select_background_colour') : 'blue';
if($select_background_colour === 'lilac') {
	$class = 'lilac';
	$src = '/wp-content/uploads/2025/03/Purple_Pattern_large.svg';
} elseif($select_background_colour === 'pink') {
	$class = 'pink';
	$src = '/wp-content/uploads/2025/03/pink_Pattern.svg';
} else {
	$class = 'blue';
	$src = '/wp-content/uploads/2025/03/Resources_banner-Pattern.svg';
}
	?>
<div class="full-container shaped banner-strip">
	<div class="custom-shape-divider-top banner-top" class="bg-<?php echo $class;?>">
		<svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
			<path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="shape-fill"></path>
		</svg>
	</div>
	<div class="content-shape position-relative <?php echo $class;?>">
		<img class="position-absolute pattern-banner" src="<?php echo $src;?>" />
		<div class="custom-container">
					<h1 class="white-shape">
						<?php single_term_title();?>
					</h1>
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

//remove default loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

//add custom loop
add_action( 'genesis_loop', 'custom_taxonomy_loop' );
function custom_taxonomy_loop() {
	if ( have_posts() ) {
		global $wp_query;
$total_results = $wp_query->found_posts;

		?>

<div class="custom-container news-container taxonomy-results">
			
		<?php
		while (have_posts() ) {
			the_post();
			$taxonomies = get_object_taxonomies( get_post_type(), 'objects' );
			$fallback_image_url = '/wp-content/uploads/2025/03/Image_Frome-edge-to-centre.png';
			$image_id = get_post_thumbnail_id(get_the_ID());
			$image_url = $image_id ? wp_get_attachment_url($image_id) : $fallback_image_url;
			$image_alt = $image_id ? get_post_meta($image_id, '_wp_attachment_image_alt', true) : '';

			// Get excerpt or content
			$excerpt = has_excerpt() ? get_the_excerpt() : get_field('short_description');
			$content = get_post_field('post_content', get_the_ID());
			$short_description_e = $excerpt ?: $content;
			$subtitle = get_field('subtitle');
			$short_description = $short_description_e;	 
			$link = get_field('external_link') ? get_field('external_link') : get_the_permalink();
			$link_text_default = get_field('external_link') ? 'Visit website' : 'Read more';
			$link_text = get_field('link_text') ? get_field('link_text') : $link_text_default;
			// Remove headings (h2, h3)
			$short_description = preg_replace('/<h[23][^>]*>.*?<\/h[23]>/', '', $short_description);

			// Strip all HTML tags after removing headings
			$short_description = wp_strip_all_tags($short_description);

			// Trim to 30 words
			$words = explode(' ', $short_description);
			$trimmed_description = wp_trim_words($short_description, 25, '...');
			$terms = get_the_terms(get_the_ID(), 'category');
			$publish_date = get_field('post_show_date');
			$class = get_field('is_image_a_logo') ? 'object-fit-contain' : 'object-fit-cover';
			

			?>
	<div class="rel-card custom-card clickable-card read-more-link">
		<div class="card-content">
			
	
			<div>
				<img class="w-100 <?php echo $class;?>" src="<?php echo  $image_url;?>" alt="<?php echo $image_alt;?> "/>
			</div>
		<div class="card-c">
			
			
             
			<h3 class="exclude"> 
				<?php 
				
					echo get_the_title();
				
		?>
				
			</h3>
			
			<div class="custom-excerpt">
				<p>
					<?php echo $trimmed_description;?>
				</p>
			</div>
			</div>
			
		</div>
		<div class="card-c link-container">
			
		
		<a class="arrow-link d-flex align-items-center gap-3" href="<?php echo $link;?>" aria-label="<?php echo $link_text;?> <?php echo get_the_title();?>">
			<span><?php echo $link_text;?></span>
			<img class="arrow icon" src="/wp-content/uploads/2025/04/arrow-right-solid.svg" alt="" />
			</a>
			</div>
	</div>
			<?php
		}
		
		?>
	</div>
<?php
	}
}

genesis();