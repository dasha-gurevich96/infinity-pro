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
    

    <!-- Keep the `.search-filter-query-posts` class to support the load more button -->
    <div class="search-filter-query-posts">
        <div class="stories-cards">
        <?php
        while ( $query->have_posts() ) {
            $query->the_post();
            $image = get_field('image');
            $intro = get_field('intro');

            $intro_no_headings = preg_replace('#<h[1-6][^>]*>.*?</h[1-6]>#is', '', $intro);
            $intro_clean = strip_tags($intro_no_headings);
            $words = preg_split('/\s+/', trim($intro_clean));
            $desc  = implode(' ', array_slice($words, 0, 20));
            ?>
            <div class="story-card">
                <div class="img-col">
                    <div class="img-container">
                        <?php if ( ! empty( $image ) ) { ?>
                            <img class="story-img" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                        <?php } else { ?>
                            <img class="logo-img" src="/wp-content/uploads/2025/06/Stories_temporary-avatar.svg" alt="" />
                        <?php } ?>
                    </div>
                </div>

                <div class="text-col">
                    <h3>
						<a href="<?php the_permalink();?>">
						<?php the_title(); ?>'s Story
						</a>
					</h3>
                    <div class="text">
                        <p><?php echo $desc; ?></p>
                    </div>
                </div>
            </div> <!-- closes .story-card -->
            <?php
        }
        wp_reset_postdata();
        ?>
        </div> <!-- closes .stories-cards -->
    </div> <!-- closes .search-filter-query-posts -->
    <?php
} else {
    ?>
    <p class="mt-4">No Results Found</p>
    <?php
}
?>

