<?php
/**
 * Site Search 
 *
 * This template is an absolute base example showing you what
 * you can do, for more customisation see the WordPress docs
 * and using template tags.
 *
 * http://codex.wordpress.org/Template_Tags
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! isset( $query ) ) {
	return;
}

if ( $query->have_posts() ) {
	?>

<p class="mt-5">Found <?php echo esc_html( $query->found_posts ); ?> Results </p>

	<!-- Keep the `.search-filter-query-posts` class to support the load more button -->
	<!--<div class="search-filter-query-posts">
		<?php
		while ( $query->have_posts() ) {
			$query->the_post();
			$desc = '';
		
			$external_link = get_field('external_link') ? get_field('external_link') : get_field('link');
			$link = $external_link ? $external_link : get_the_permalink();
			$link_text_default = $external_link ? 'Visit website' : 'Read more';
			$link_text = get_field('link_text') ? get_field('link_text') : $link_text_default;
			
			if (!empty(get_field('short_description'))) {
    			$desc = get_field('short_description');
				$desc = wp_strip_all_tags($desc); 
			} elseif(has_excerpt()) {
				$desc = get_the_excerpt();
			} else {
				// If there's no 'short_description', get the main content
				$desc = get_the_content();
			}
			$desc = preg_replace('/<h[23][^>]*>.*?<\/h[23]>/', '', $desc);
			$desc = wp_strip_all_tags($desc); 
			// Trim the content to 20 words
			$desc = wp_trim_words($desc, 41, '...');

			?>
			<div class="result-container">
				<h3><?php esc_html( the_title() ); ?></h3>
			
				<p><?php echo $desc;?></p>
		
		
				<a href="<?php echo $link;?>" aria-label="<?php echo $link_text;?> - <?php the_title();?>"><?php echo $link_text;?></a>
			</div>
			
			<?php
		}
		wp_reset_postdata();
		?>
	</div> -->
		<div class="search-filter-query-posts">
			<div class="news-container">

			<?php
			while ( $query->have_posts() ) {
				$query->the_post();
				$fallback_image_url = '/wp-content/uploads/2025/03/Image_Frome-edge-to-centre.png';
				$image_id = get_post_thumbnail_id(get_the_ID());
				$image_url = $image_id ? wp_get_attachment_url($image_id) : $fallback_image_url;
				$image_alt = $image_id ? get_post_meta($image_id, '_wp_attachment_image_alt', true) : '';

				// Get excerpt or content
				$excerpt = get_the_excerpt() ? get_the_excerpt() : get_field('short_description');
				$content = get_post_field('post_content', get_the_ID());
				$short_description_e = $excerpt ?: $content;
				$subtitle = get_field('subtitle');
				$short_description = $short_description_e;	 
				$external_link = get_field('external_link') ? get_field('external_link') : get_field('link');
				$link = $external_link ? $external_link : get_the_permalink();
				$link_text_default = $external_link ? 'Visit website' : 'Read more';
				$link_text = get_field('link_text') ? get_field('link_text') : $link_text_default;
				// Remove headings (h2, h3)
				$short_description = preg_replace('/<h[23][^>]*>.*?<\/h[23]>/', '', $short_description);

				// Strip all HTML tags after removing headings
				$short_description = wp_strip_all_tags($short_description);

				if (!empty(get_field('short_description'))) {
    			$desc = get_field('short_description');
				$desc = wp_strip_all_tags($desc); 
			} elseif(has_excerpt()) {
				$desc = get_the_excerpt();
			} else {
				// If there's no 'short_description', get the main content
				$desc = get_the_content();
			}
				$desc = preg_replace('/<h[23][^>]*>.*?<\/h[23]>/', '', $desc);
			$desc = wp_strip_all_tags($desc); 
			// Trim the content to 20 words
			$desc = wp_trim_words($desc, 25, '...');
				// Trim to 30 words
				$words = explode(' ', $short_description);
				$trimmed_description = wp_trim_words($short_description, 15, '...');
				$terms = get_the_terms(get_the_ID(), 'information-type');
				$publish_date = get_field('post_show_date');
				$class = get_field('is_image_a_logo') ? 'object-fit-contain' : 'object-fit-cover';

				?>
		<div class="rel-card custom-card read-more-link">
			<div class="card-content">

				<div>
					<img class="w-100 <?php echo $class;?>" src="<?php echo  $image_url;?>" alt="<?php echo $image_alt;?> "/>
				</div>
				<div class="card-c">

					<?php  if ($terms && !is_wp_error($terms)) {
								// Create an array to store term IDs
								$term_ids = array();
								?><div class="tags-c mt-0">

							<div class="terms gap-3 d-flex flex-wrap">
								<?php foreach ($terms as $term) {
								echo  '<a class="term-c" href="site-search-results/?_information-type=' . $term->slug . '">' . $term->name . '</a>';
							 }
								?>
								</div>


							</div>
							<?php

							} ?>

					<h3 class="exclude"> 
						<?php 

							echo get_the_title();

				?>

					</h3>

					<div class="custom-excerpt">
						<p>
							<?php echo $desc;?>
						</p>
					</div>

				</div>
			</div>
			<div class="card-c link-container">
			
		
		<a class="arrow-link d-flex align-items-center gap-3" href="<?php echo $link;?>" aria-label="<?php echo $link_text;?> <?php the_title();?>">
			<span><?php echo $link_text;?></span>
			<img class="arrow icon" src="/wp-content/uploads/2025/04/arrow-right-solid.svg" alt="">
			</a>
			</div>
		</div>
				<?php
			}
			wp_reset_postdata();
			?>
		</div>

	</div>

	<?php
} else {
	?><p class="mt-4"> 
	<?php echo 'No Results Found';?>	
</p>
<?php
}
?>
