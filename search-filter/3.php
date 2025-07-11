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
			$image_resources = get_field('image_resources');
			$external_link = get_field('external_link');

			if (!empty($event_description)) {
				$source_text = $event_description;
				$word_limit = 20;
			} elseif (!empty($short_description)) {
				$source_text = $short_description;
				$word_limit = 30;
			} elseif (!empty($description)) {
				$source_text = $description;
				$word_limit = 30;
			} elseif (!empty($intro)) {
				$source_text = $intro;
				$word_limit = 30;
			} else {
				$summary = '';
				return;
			}

			// Remove <h1>-<h6> tags
			$cleaned_description = preg_replace('/<h[1-6][^>]*>.*?<\/h[1-6]>/is', '', $source_text);

			// Strip all HTML
			$plain_text = strip_tags($cleaned_description);

			// Split into words
			$words = preg_split('/\s+/', trim($plain_text));

			// Slice and rebuild summary
			$summary_words = array_slice($words, 0, $word_limit);
			$summary = implode(' ', $summary_words);

			// Add ellipsis if original had more words
			if (count($words) > $word_limit) {
				$summary .= '...';
			}

			$date_text_with_time = get_field('date_text_with_time');
			$organiser_logo = get_field('organiser_logo');
			$venue = get_field('venue');
			$post_id = get_the_ID(); // or use a specific post ID

				// Get featured image ID
				$thumbnail_id = get_post_thumbnail_id($post_id);

				// Get image URL
				$image_url = wp_get_attachment_url($thumbnail_id);

				// Get image alt text
				$image_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);

		$post_type = get_post_type(get_the_ID());
				?><div class="card full-card grid-card <?php if(!get_field('remove_link_to_the_page')) { echo 'clickable-card';};?>">
						<div class="img-col">
							<?php if(!empty($image_url)) {
									?> <img src="<?php echo $image_url;?>" alt="<?php echo $image_alt;?>" /><?php
							} elseif(!empty($image_resources)) {
								?> <img src="<?php echo $image_resources['url'];?>" alt="<?php echo $image_resources['alt'];?>" /><?php
							} else {
								?><img class="object-fit-contain" src="/wp-content/uploads/2025/06/Stories_temporary-avatar.svg" alt="" /><?php
							}
							?>
						</div>
						<div class="text-col">
							<h3>
							
								<?php if($post_type === 'stories-scld') {
									the_title();?>'s story <?php
								} else {
									the_title();
								}
								?>
							</h3>
							<!--<?php if(!empty($organiser_logo)) {
								?><img class="logo org object-fit-contain" src="<?php echo $organiser_logo['url'];?>" alt="<?php echo $organiser_logo['alt'];?>" /><?php
							}
							?> -->
							<?php if(!empty($venue) || !empty($date_text)) {
								?>
							<div class="event-details">
								<?php if(!empty($venue)) {
									
									?>
									<p class="text-icon d-flex gap-3">
									<img class="icon" src="/wp-content/uploads/2025/06/Icon_location.svg" alt="" />
									<span><?php echo $venue['name'];?></span>
									</p>
									<?php
								} else {
									
									$online_text = get_field('online_text') ? get_field('online_text') : 'Online';
                                    ?>
									<p class="text-icon d-flex gap-3">
									<img class="icon" src="/wp-content/uploads/2025/06/Icon_location.svg" alt="" />
									<span><?php echo $online_text;?></span>
									</p>
									<?php
								}
								?>
								<?php 
								
								if(!empty($date_text_with_time)) {
									 
									?>
									<p class="text-icon d-flex gap-3 align-items-start">
										<img class="icon" src="/wp-content/uploads/2025/06/Icon_calendar.svg" alt="" />
										<span><?php echo $date_text_with_time;?></span>
									</p>
									<?php
								}
								?>
								</div>
								<?php
							}
							
							?>
							<?php if(!empty($summary)) {
								?><div class="summary">
									<p><?php echo $summary;?></p>
								</div>
								<?php
							}
							?>
							<?php 
							if(!get_field('remove_link_to_the_page')) {
							if(!empty($external_link)) {
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
									default:
										// Check if link is internal (on the same domain)
										$site_host = parse_url(home_url(), PHP_URL_HOST);
										$link_host = parse_url($external_link, PHP_URL_HOST);

										if (!empty($link_host) && $link_host === $site_host) {
											$link_text = 'Learn more';
										}
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