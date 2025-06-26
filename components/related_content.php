<?php
$related_content = get_field('realted_content');
$heading = get_field('heading_above_slider');

if (!empty($related_content) && is_array($related_content)) {
	$count = count($related_content);
	if($count > 2 ) {
		$class = "related-content-slider";
		
	} else {
		$class = 'news-container';
	
	}
    ?>
    <div class="full-container light-lilac related-content">
        <div class="custom-container">
			<div class="related-content-text">
				
			
            <?php if (!empty($heading)) { ?>
                <h2 ><?php echo $heading; ?></h2>
            <?php } else {
				?><h2>
					Related content
				</h2>
				<?php
			}
			?>
			<?php if(!empty(get_field('text_above_slider'))) {
		?><div class="mb-5"><?php
				echo get_field('text_above_slider');
		?> </div><?php
				}
            ?>
				</div>
            <div class="<?php echo $class;?>  slider"> 
                <?php foreach ($related_content as $related_page_id) {
                    $fallback_image_url = '/wp-content/uploads/2025/03/Image_Frome-edge-to-centre.png';
                    $image_id = get_post_thumbnail_id($related_page_id);
                    $image_url = $image_id ? wp_get_attachment_url($image_id) : $fallback_image_url;
                    $image_alt = $image_id ? get_post_meta($image_id, '_wp_attachment_image_alt', true) : '';
					$link = get_field('external_link', $related_page_id) ? get_field('external_link', $related_page_id) : get_the_permalink($related_page_id);
					$link_text_default = get_field('external_link', $related_page_id) ? 'Visit website' : 'Read more';
					$link_text = get_field('link_text', $related_page_id) ? get_field('link_text', $related_page_id) : $link_text_default;

                    // Get excerpt or content
                   $excerpt = get_field('short_description', $related_page_id) ? get_field('short_description', $related_page_id) : get_the_excerpt($related_page_id);
                    $content = get_post_field('post_content', $related_page_id);
                    $short_description_e = $excerpt ?: $content;
                    $subtitle = get_field('subtitle', $related_page_id);
                    $short_description = $subtitle . ' ' . $short_description_e; 

                  
                    // Remove headings (h2, h3)
                    $short_description = preg_replace('/<h[23][^>]*>.*?<\/h[23]>/', '', $short_description);

                    // Strip all HTML tags after removing headings
                    $short_description = wp_strip_all_tags($short_description);

                    // Trim to 30 words
                    $trimmed_description = wp_trim_words($short_description, 25, '...');
                ?>
                <div class="rel-card custom-card clickable-card read-more-link">
					<div class="card-content">
						
				
                    <div>
                        <img class="w-100 object-fit-cover" src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" />
                    </div>
                    <div class="card-c">
                        <h3 class="exclude">
                           
                                <?php 
                                    if (!empty(get_field('title_for_the_home_page', $related_page_id))) {
                                        echo get_field('title_for_the_home_page', $related_page_id);
                                    } else {
                                        echo get_the_title($related_page_id);
                                    }
                                ?>
                            
                        </h3>
                        <div class="custom-excerpt">
                            <p><?php echo $trimmed_description; ?></p>
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
                <?php } ?>
            </div>
        </div>
    </div>
<?php
}
