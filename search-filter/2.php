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
	<div class="search-filter-query-posts resources-cards">
		<?php
		while ($query->have_posts()) {
			$query->the_post();

			$title = get_field('title_for_the_home_page') ? get_field('title_for_the_home_page') : get_the_title();
            
            // Get external link (ACF field)
            $external_link = get_field('external_link');
            
            // Use external link if set, otherwise use the permalink
            $link = $external_link ? $external_link : get_permalink();
            
            // Get excerpt (limit to 30 words)
            $excerpt = wp_trim_words(get_the_excerpt(), 18, '...');
			$terms = get_the_terms(get_the_ID(), 'resource-topics');
            
            ?>
            <div class="resource-card">
				<div>
                <h3><a href="<?php echo esc_url($link); ?>"><?php echo esc_html($title); ?></a></h3>
                <p><?php echo esc_html($excerpt); ?></p>
				</div>
                <?php if (!empty($terms) && !is_wp_error($terms)) { ?>
                    <div class="tags">
                        <?php foreach ($terms as $term) { ?>
						<!--<div class="term-container">-->
							<a class="term" href="<?php echo esc_url('/resources/?_resource-topics=' . $term->slug); ?>">
                                <?php if($term->name === 'Beyond diversity, equity and inclusion') {
									echo 'Beyond DEI';
								} else {
									echo $term->name;
								}
														 ?>
                            </a>
						<!--</div>-->
                            
                        <?php } ?>
                    </div>
                <?php } ?>
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