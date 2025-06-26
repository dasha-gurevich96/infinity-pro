<?php
/**
 * Grants
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
	<div class="search-filter-query-posts resources-cards grants-cards">
		<?php
		while ($query->have_posts()) {
			$query->the_post();

			$title = get_the_title();
            
          
			$terms = get_the_terms(get_the_ID(), 'focus-area');
			$terms_status = get_the_terms(get_the_ID(), 'current-status');
			$funder_name = get_field('funder_name');
			$eligibility_restrictions = get_field('eligibility_restrictions');
			$website = get_field('website');
			$grantnav = get_field('grantnav_or_annual_report_link');
			$deadlines = get_field('deadlines');
            $how_to_stay_informed = get_field('how_to_stay_informed');
			$last_updated = get_field('last_updated_date');
			$raw_date = get_field('last_updated_date');
			$date = DateTime::createFromFormat('Ymd', $raw_date);
			// Format it to 'jS F Y' (e.g., 17th April 2025)
			$formatted_date = $date ? $date->format('jS F Y') : '';
            ?>
            <div class="resource-card grant-card">
				<div>
                <h3><?php echo $title; ?></h3>
					<?php if(!empty($funder_name)) {
				?> 
						<h4 class="funder-name">
							<?php echo $funder_name;?>	
						</h4>
					
				
					<?php
					}
			
			?><div class="tags-c"><div class="terms gap-3 d-flex flex-wrap"><?php
			if (!empty($terms) && !is_wp_error($terms)) { ?>
                  
                        <?php foreach ($terms as $term) { ?>
					
							<a class="term-c" href="<?php echo esc_url('/grant-funding-opportunities/?_focus-area=' . $term->slug); ?>">
								<?php echo $term->name;?>

                            </a>
						
                            
                        <?php } ?>
                   
                <?php } ?>
				<?php if (!empty($terms_status) && !is_wp_error($terms_status)) { ?>
                   
                        <?php foreach ($terms_status as $term) { ?>
						
							<a class="term-c" href="<?php echo esc_url('/grant-funding-opportunities/?_current-status=' . $term->slug); ?>">
								<?php echo $term->name;?>

                            </a>
						
                            
                        <?php } ?>
                    
                <?php } 
			?> </div></div>
					<?php if(!empty($formatted_date)) {
				?> <div class="info date d-flex gap-3 align-items-center mt-5 mb-3">
						<h4 class="icon-title gap-3 d-flex align-items-center mt-0 mb-0">
							<img class="icon" src="/wp-content/uploads/2025/04/pen-to-square-regular.svg" alt="" />
							<span>Last updated:</span>
						</h4>
					<p class="line-height-1 mt-0 mb-0"><?php echo $formatted_date;?></p>
					</div>
					<?php
					} ?>
					<?php if(!empty($deadlines)) {
				?> <div class="info deadlines">
						<h4 class="icon-title gap-3 d-flex align-items-center">
							<img class="icon" src="/wp-content/uploads/2025/04/calendar.svg" alt="" />
							<span>Deadlines:</span>
						</h4>
						<?php echo $deadlines;?>
					</div>
					<?php
					}
				
				if(!empty($eligibility_restrictions)) {
				?> <div class="info">
					<h4 class="icon-title gap-3 d-flex">
						<img class="icon" src="/wp-content/uploads/2025/04/card-text.svg" alt="" />
						<span>Eligibility restrictions:</span>
					</h4>
						
						<?php echo $eligibility_restrictions;?>
					</div>
					<?php
					}
			if (!empty($grantnav)) {
				
				 //$grantnav = html_entity_decode($grantnav);
				$decoded = html_entity_decode($grantnav);
				preg_match_all('/https?:\/\/[^\s<>"\'()]+/i', $decoded, $matches);
			

				
				?><div class="links">
					<h4 class="icon-title gap-3 d-flex">
						<img class="icon" src="/wp-content/uploads/2025/04/globe2.svg" alt="" />
						<span>Grantnav and/or annual report links:</span>
					</h4>
					<ul>
						
					
				<?php
				foreach ($matches[0] as $link) {
					
						if (filter_var($link, FILTER_VALIDATE_URL)) {
							echo '<li><a href="' . esc_url($link) . '">' . esc_html($link) . '</a></li>';
						}
					}
						?></ul></div><?php
				}
				if( !empty($how_to_stay_informed)) {
					?><div class="links">
					<h4 class="icon-title gap-3 d-flex">
						<img class="icon" src="/wp-content/uploads/2024/04/lightbulb-regular.svg" alt="" />
						<span>How to stay informed:</span>
					</h4>
					<ul>
					<?php
				}
			/*if(!empty($grantnav)) {
				?> 
					
					<li>	<a aria-label="Grantnav or annual report  link of the <?Php echo $funder_name;?>" href="<?php echo $grantnav;?>">Grantnav or annual report  link</a></li>
					
						
						
					
					<?php
					}*/
			
			if(!empty($how_to_stay_informed)) {
				?> 
						
						<li><?php echo $how_to_stay_informed;?></li>
					
					<?php
					}
		if(!empty($how_to_stay_informed)) {
						?></ul>
					</div>
					<?php
				}
			?></div><?php
			if(!empty($website)) {
				?> 
					
	
						
						<a class="custom-button black" href="<?php echo $website;?>" aria-label="More about funding opportunity of <?php echo $funder_name;?>">More about funding opportunity</a>
					
				
					<?php
					}
                ?>
				
                
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