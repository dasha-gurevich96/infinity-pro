<?php
$terms = get_the_terms(get_the_ID(), 'resource-topics');

// Check if terms are found
if ($terms && !is_wp_error($terms)) {
    // Create an array to store term IDs
    $term_ids = array();

    // Loop through the terms and collect term IDs
    foreach ($terms as $term) {
        $term_ids[] = $term->term_id;
    }

    // Create WP_Query to get resource-articles that have these terms
    $args = array(
        'post_type' => 'resource-articles', // Replace with your custom post type if needed
        'posts_per_page' => -1,  // -1 for all posts, adjust as needed
		'post__not_in' => array(get_the_ID()), 
        'tax_query' => array(
            array(
                'taxonomy' => 'resource-topics',
                'field'    => 'term_id',
                'terms'    => $term_ids, // Query for posts with any of the terms
                'operator' => 'IN', // Matches any of the terms
            ),
        ),
    );

$query = new WP_Query($args);
$heading = get_field('heading_above_slider');
if ($query->have_posts()) {
	?><div class="full-container light-lilac related-slider">
	<div class="custom-container">
		<div class="related-content-text">
		<?php if(!empty($heading)) {
		?><h2 class="related-content-title">
			<?php echo $heading;?>
		</h2>
	<?php
	} else {
		?><h2 class="related-content-title">
		Related content
		</h2>
	<?php } ?>
		</div>
	<div class="related-content-slider">
		<?php
	while($query->have_posts()) {
	$query->the_post();?>
		<?php
		$fallback_image_url = '/wp-content/uploads/2025/03/Image_Frome-edge-to-centre.png';
		$image_id = get_post_thumbnail_id(get_the_ID());
        $image_url = $image_id ? wp_get_attachment_url($image_id) : $fallback_image_url;
        $image_alt = $image_id ? get_post_meta($image_id, '_wp_attachment_image_alt', true) : '';

        // Get excerpt or content
        $excerpt = get_the_excerpt() ? get_the_excerpt() : get_field('short_description');
        $content = get_post_field('post_content', get_the_ID());
        $short_description_e = $excerpt ?: $content;
		$short_description = $short_description_e;	 
		$link = get_field('external_link', $related_page_id) ? get_field('external_link') : get_the_permalink();
        // Remove headings (h2, h3)
        $short_description = preg_replace('/<h[23][^>]*>.*?<\/h[23]>/', '', $short_description);

        // Strip all HTML tags after removing headings
        $short_description = wp_strip_all_tags($short_description);

        // Trim to 30 words
        $words = explode(' ', $short_description);
        $trimmed_description = wp_trim_words($short_description, 25, '...');
		$terms = get_the_terms(get_the_ID(), 'resource-topics');
		
		?>
		<div class="rel-card custom-card clickable-card">
			<div>
				<img class="w-100 object-fit-cover" src="<?php echo  $image_url;?>" alt="<?php echo $image_alt;?> "/>
			</div>
		<div class="card-c">
			
			<?php if (!empty($terms) && !is_wp_error($terms)) { ?>
                    <div class="tags-light d-flex">
						
                        <?php foreach ($terms as $term) { ?>
						<div class="term-container">
							<span class="term-c">
                                <?php 
								if($term->name === 'Beyond diversity, equity and inclusion') {
									echo 'Beyond DEI';
								} else {
									echo $term->name;
								}
								?>						 
                            </span>
						</div>
                            
                        <?php } ?>
                    </div>
                <?php } ?>
			<h3 class="exclude"> <a href="<?php echo $link;?>">
				<?php 
				if(!empty(get_field('title_for_the_home_page'))) {
						echo get_field('title_for_the_home_page');
				} else {
					echo get_the_title();
				}
		?>
				</a>
			</h3>
			<div class="custom-excerpt">
				<p>
					<?php echo $trimmed_description;?>
				</p>
			</div>
		</div>
	</div>


	<?php
}
	?></div></div></div><?php
	 wp_reset_postdata();
}
}
