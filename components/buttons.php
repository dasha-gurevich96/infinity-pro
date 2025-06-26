<?php
if (have_rows('buttons')) { ?>
	
		<div class="custom-container">
			
		
<div class="buttons-container">
		<?php
		while (have_rows('buttons')) {
			the_row();
			$link = get_sub_field('link');
			$text_btn = get_sub_field('text');
			$select_background_colour = get_sub_field('select_background_colour');
			if (!empty($link) && !empty($text_btn)) { ?>
				<a href="<?php echo $link; ?>" class="custom-button <?php echo $select_background_colour; ?>">
					<?php echo $text_btn; ?>
				</a>
			<?php }
	} ?>
</div>
			</div>

<?php } ?>