<?php if(have_rows('quick_links')) {
	while(have_rows('quick_links')) {
		the_row();
		$title = get_sub_field('title') ? get_sub_field('title') : 'Quick links';
		$add_h3 = get_sub_field('include_h3');

		
?>		  
<div id="toc-placeholder" class="quick-links">
        <h2 class="exclude"><?php echo $title;?></h2>
	<?php if($add_h3) {
			?> <script>
            jQuery(function($) {
                $(document).ready(function() {
					
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

                    $('.two-cols-container h2:not(.exclude), .two-cols-container h3:not(.exclude)').each(function() {
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
	<?php
		} else {
			?>
			<script>
            jQuery(function($) {
                $(document).ready(function() {
					
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

                    $('.two-cols-container h2:not(.exclude)').each(function() {
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
			<?php
		}
        ?>
	  </div>

<?php
			
}
}