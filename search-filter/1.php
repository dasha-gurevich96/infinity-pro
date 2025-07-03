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
	<div class="search-filter-query-posts">
		<?php
		while ( $query->have_posts() ) {
			$query->the_post();
			$image = get_field('image');
			$intro = get_field('intro');
		
			
			}
			wp_reset_postdata();
			?>
		</div>


	<?php
} else {
	?><p class="mt-4"> 
	<?php echo 'No Results Found';?>	
</p>
<?php
}
?>
