<?php
/**
 * Resources results
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

if ($query->have_posts()) {
?>
	<!-- Keep the `.search-filter-query-posts` class to support the load more button -->
	<div class="search-filter-query-posts events-cards" id="resources">
		<?php
		while ($query->have_posts()) {
			$query->the_post();
			$date_text = get_field('date_text');
			$event_description = get_field('event_description');
			$short_description = get_field('short_description');
			$description = get_field('description');
			$intro = get_field('intro');

			if(!empty($event_description)) {
				$cleaned_description = preg_replace('/<h[1-6][^>]*>.*?<\/h[1-6]>/is', '', $event_description);
				$plain_text = strip_tags($cleaned_description);
				$words = explode(' ', $plain_text);
				$summary = implode(' ', array_slice($words, 0, 30));
			} elseif(!empty($short_description)) {
				$cleaned_description = preg_replace('/<h[1-6][^>]*>.*?<\/h[1-6]>/is', '', $short_description);
				$plain_text = strip_tags($cleaned_description);
				$words = explode(' ', $plain_text);
				$summary = implode(' ', array_slice($words, 0, 30));
			} elseif(!empty($description)) {
				$cleaned_description = preg_replace('/<h[1-6][^>]*>.*?<\/h[1-6]>/is', '', $description);
				$plain_text = strip_tags($cleaned_description);
				$words = explode(' ', $plain_text);
				$summary = implode(' ', array_slice($words, 0, 30));
			} elseif(!empty($intro)) {
				$cleaned_description = preg_replace('/<h[1-6][^>]*>.*?<\/h[1-6]>/is', '', $intro);
				$plain_text = strip_tags($cleaned_description);
				$words = explode(' ', $plain_text);
				$summary = implode(' ', array_slice($words, 0, 30));
			}  else {
				$summary = '';
			}
			
			$organiser_logo = get_field('organiser_logo');
			$venue = get_field('venue');
			$post_id = get_the_ID(); // or use a specific post ID

				// Get featured image ID
				$thumbnail_id = get_post_thumbnail_id($post_id);

				// Get image URL
				$image_url = wp_get_attachment_url($thumbnail_id);

				// Get image alt text
				$image_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);

		
				?><div class="card full-card grid-card clickable-card">
						<div class="img-col">
							<img src="<?php echo $image_url;?>" alt="<?php echo $image_alt;?>" />
						</div>
						<div class="text-col">
							<h3>
								<?php the_title();?>
							</h3>
							<?php if(!empty($organiser_logo)) {
								?><img class="logo org object-fit-contain" src="<?php echo $organiser_logo['url'];?>" alt="<?php echo $organiser_logo['alt'];?>" /><?php
							}
							?>
							<div class="event-details">
								<?php if(!empty($venue)) {
									?>
									<p class="text-icon d-flex gap-3">
									<img class="icon" src="/wp-content/uploads/2025/06/Icon_location.svg" alt="" />
									<span><?php echo $venue['name'];?></span>
									</p>
									<?php
								}
								?>
								<?php if(!empty($date_text)) {
									?>
									<p class="text-icon d-flex gap-3 align-items-start">
										<img class="icon" src="/wp-content/uploads/2025/06/Icon_calendar.svg" alt="" />
										<span><?php echo $date_text;?></span>
									</p>
									<?php
								}
								?>
							</div>
							<?php if(!empty($summary)) {
								?><div class="summary">
									<p><?php echo $summary;?></p>
								</div>
								<?php
							}
							?>
							<?php if(!empty($external_link)) {
								$link_text = 'Visit Website';

								// Get lowercase file extension
								$extension = strtolower(pathinfo(parse_url($external_link, PHP_URL_PATH), PATHINFO_EXTENSION));

								switch ($extension) {
									case 'pdf':
										$link_text = 'Download PDF';
										break;
									case 'doc':
										$link_text = 'Download DOC';
										break;
									case 'docx':
										$link_text = 'Download DOCX';
										break;
								}
								?> <a href="<?php echo $external_link;?>" class="custom-button learn-more d-flex" aria-label="<?php echo $link_text;?> of <?php the_title();?>">
									<span><?php echo $link_text;?></span>
								<img class="arrow arrow-more" src="/wp-content/uploads/2025/06/Arrow-right.svg" alt=""/>
								</a>
							<?php
								
							} else {
								?> <a href="<?php the_permalink();?>" class="custom-button learn-more d-flex" aria-label="Learn more about <?php the_title();?>">
									<span>Learn more</span>
								<img class="arrow arrow-more" src="/wp-content/uploads/2025/06/Arrow-right.svg" alt=""/>
								</a>
							<?php
							}
							?>
							
						</div>
				  </div>
					<?php
			




        }
        ?>
	</div>
<?php
	wp_reset_postdata();
} else {
	?><p class="mt-4">
	<?php echo 'No Results Found';?>	
</p>
<?php
}

?>