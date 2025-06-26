<?php

$text_1 = get_sub_field('text_column_1');
$text_2 = get_sub_field('text_column_2');
$add_line = get_sub_field('add_line') ? 'line-title' : '';

$add_pattern = get_sub_field('add_pattern');
$background_colour = get_sub_field('select_background_colour');
$pattern_position = get_sub_field('show_pattern_on_the');
$size = get_sub_field('select_pattern_size');

$pattern = '';


if ($add_pattern) {
	if ($background_colour === 'pink') {
		$pattern = '/wp-content/uploads/2025/03/Inner-pages_pattern_zigzaG.svg';
	} elseif ($background_colour === 'blue') {
		if ($pattern_position === 'left') {
			$pattern = '/wp-content/uploads/2025/03/Inner-pages_pattern_circles.svg';
		} else {
			$pattern = '/wp-content/uploads/2025/03/Inner-pages_pattern-circle-flipped.svg';
		}
	} elseif ($background_colour === 'lilac') {
		if ($size === 'large') {
			$pattern = '/wp-content/uploads/2025/03/Inner-pages_pattern_crosses_lager.svg';
		} else {
			$pattern = '/wp-content/uploads/2025/03/Inner-pages_pattern_cross.svg';
		}
	}
}

if (!empty($text_1) && !empty($text_2)) {
	
?>
	<div class="full-container light-<?php echo $background_colour; ?>">
		<?php if (!empty($pattern)) { ?>
			<img src="<?php echo $pattern; ?>" alt="" class="position-absolute pattern pattern-<?php echo $pattern_position; ?>"/>
		<?php } ?>

		<div class="custom-container">
			<div class="component-two-cols-text component-two-cols <?php echo $add_line;?>">
				<div class="custom-col-1">
						<div class="text">
							<?php echo $text_1; ?>
							<?php if (have_rows('buttons')) { ?>
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
							<?php } ?>
						</div>
				
				</div>

				<div class="custom-col-2">
					<div class="text">
							<?php echo $text_2; ?>
							<?php if (have_rows('buttons_column_2')) { ?>
								<div class="buttons-container">
									<?php
									while (have_rows('buttons_column_2')) {
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
							<?php } ?>
						</div>
				</div>

			</div>
		</div>
	</div>
<?php } ?>
