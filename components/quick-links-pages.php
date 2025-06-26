<?php
function add_social_share_buttons() {
		// Get the current page URL
		$url = esc_url(get_permalink());

		// Get the current page title
		$title = urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8'));

		// Create an array of social networks and their respective sharing URLs
		$social_networks = array(
			'Facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . $url,
			'LinkedIn' => 'https://www.linkedin.com/shareArticle?url=' . $url . '&title=' . $title,
			'Bluesky' => $url . '??share=bluesky&nb=1',
		
		);

		// Initialize the share buttons HTML
		$share_buttons = '<div class="social-media d-flex">';
		foreach ($social_networks as $network => $share_url) {
			$img = '';
			if($network === 'Facebook') {
				$img = '<img src="/wp-content/uploads/2025/03/facebook-f-brands.svg" alt="Share on Facebook">';
			} elseif($network === 'LinkedIn') {
				$img = '<img src="/wp-content/uploads/2025/03/linkedin-in-brands.svg" alt="Share on LinkedIn">';
			} /*elseif($network === 'X (Twitter)') {
				$img = '<img src="/wp-content/uploads/2025/03/x-twitter-brands.svg" alt="Share on X (formerly Twitter)">';
			}*/ elseif($network === 'Bluesky') {
				$img = '<img src="/wp-content/uploads/2025/04/bluesky-brands.svg" alt="Share on Bluesky">';
			} 

			$share_buttons .= '<a class="social-icon move-up" href="' . esc_url($share_url) . '" target="_blank" rel="noopener" aria-label="Share via ' . esc_attr($network) . ' (opens in a new tab)">' . $img . '</a>';
		}
		// Close the share buttons HTML
		$share_buttons .= '</div>';


		return $share_buttons;
	}
   ?>
<div class="full-container shaped links">
	<div class="custom-shape-divider-top links-top">
    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="shape-fill"></path>
    </svg>
</div>
	<div class="content-shape">

	  <div class="custom-container links-socials">
		  <div class="links-col">
			  
		
<?php if(have_rows('quick_links')) {
	while(have_rows('quick_links')) {
		the_row();
		$title = get_sub_field('title') ? get_sub_field('title') : 'Quick links';
		$add_social_icons = get_sub_field('add_social_icons');
		$links_to_create = get_sub_field('include_h3') ? '.page-component h2:not(.exclude), .page-component h3:not(.exclude)' : '.page-component h2:not(.exclude)';
		
?>		  
<div id="toc-placeholder" class="quick-links">
        <h2 class="exclude"><?php echo $title;?></h2>
        <script>
            jQuery(function($) {
                $(document).ready(function() {
					var headingsSelector = "<?php echo $links_to_create; ?>";
                    function convertToId(text) {
                        return text.toLowerCase()
                            .replace(/[^a-z0-9\s]/g, '') // Remove non-alphanumeric characters
                            .trim()
                            .replace(/\s+/g, '-'); // Replace spaces with dashes
                    }

                    var $tocContainer = $('#toc-placeholder');
                    var $tocList = $('<ul></ul>');
          

                    var $currentH2ListItem = null;
                    var $subList = null;

                    $(headingsSelector).each(function() {
                        var $heading = $(this);
                        var id = convertToId($heading.text());
                        $heading.attr('id', id);

                        var $listItem = $('<li></li>');
                        var $link = $('<a></a>').attr('href', '#' + id).text($heading.text());
                    
                        $listItem.append($link);

                        if ($heading.is('h2')) {
                            // Start a new top-level list item
                            $currentH2ListItem = $listItem;
                            $subList = $('<ul></ul>'); // Create a new sub-list for future h3s
                            $tocList.append($currentH2ListItem);
                        } else if ($heading.is('h3') && $currentH2ListItem) {
                            // Append to the current h2's sublist
                            $subList.append($listItem);
                            $currentH2ListItem.append($subList);
                        }
                    });

                    $tocContainer.append($tocList);
                });
            });
        </script>
	  </div>
    </div>
		  <?php if($add_social_icons) {
			?> <div class="social-col">
			  <?php 
					?><h2 class="exclude">
			  			Share this article
			  	</h2>
			  <div>
				  <?php echo add_social_share_buttons();?>
			  </div>
			  <?php
			
			  ?>
		  </div>
		  <?php
		}
		?>
		  
	   </div>
	   </div> 
	<div class="custom-shape-divider-bottom links-shape-bottom">
    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="shape-fill"></path>
    </svg>
</div>
	<img src="/wp-content/uploads/2025/03/Inner-pages_pattern_cross.svg" alt="" class="pattern pattern-right"/>
</div>
<?php
			}
}
