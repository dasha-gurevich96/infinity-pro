<?php
$text = get_sub_field('text');
$image = get_sub_field('image_1');
$show_img = get_sub_field('show_image_on_the');
$add_pattern = get_sub_field('add_pattern');
$background_colour = get_sub_field('select_background_colour');
$pattern_position = get_sub_field('show_pattern_on_the');
$size = get_sub_field('select_pattern_size');
$add_overlay = get_sub_field('add_overlay');
$pattern_colour = get_sub_field('select_pattern_colour');
$pattern ='';
if($add_pattern) {
	if($background_colour === 'pink'  || $pattern_colour === 'pink' ) {
		$pattern = '/wp-content/uploads/2025/03/Inner-pages_pattern_zigzaG.svg';
	} elseif($background_colour === 'blue' || $pattern_colour === 'blue') {
		if($pattern_position === 'left') {
			$pattern = '/wp-content/uploads/2025/03/Inner-pages_pattern_circles.svg';
		} else {
			$pattern = '/wp-content/uploads/2025/03/Inner-pages_pattern-circle-flipped.svg';
		}
	} elseif($background_colour === 'lilac' || $pattern_colour === 'lilac') {
		if($size === 'large') {
			$pattern = '/wp-content/uploads/2025/03/Inner-pages_pattern_crosses_lager.svg';
		} else {
			$pattern = '/wp-content/uploads/2025/03/Inner-pages_pattern_cross.svg';
		}

	}
}

if($add_overlay) {
	$class="overlay-img";
	$style = 'filter: grayscale(100%);';
} else {
	$class="";
	$style = '';
}

$overlay_colour = get_sub_field('overlay_colour');

if(!empty($overlay_colour)) {
	$colour = $overlay_colour;
} else {
	$colour ='';
}



if (!empty($text) && !empty($image)) {
?>
	<div class="full-container light-<?php echo $background_colour; ?> show-<?php echo $show_img;?>">
		<?php if (!empty($pattern)) { ?>
			<img src="<?php echo $pattern; ?>" alt="" class="position-absolute pattern pattern-<?php echo $pattern_position; ?>"/>
		<?php } ?>

		<div class="custom-container">
			<div class="component-two-cols">
				<div class="custom-col-1">
					<?php if ($show_img === 'Left') { ?>
						<div class="img-col position-relative <?php echo $class;?>">
							<?php if($add_overlay) {
								?><img class="frame frame-top position-absolute" src="/wp-content/uploads/2025/04/Photo-overlay_top-corner.png"/>
								 <img class="frame frame-bottom position-absolute" src="/wp-content/uploads/2025/04/Photo-overlay_bottom-corner.png"/><?php
							}
							?>
							<img class="img" src="<?php echo $image["url"]; ?>" alt="<?php echo $image['alt']; ?>" <?php echo $style;?>/>
							<?php if($add_overlay) {
								?><div class="position-absolute colour <?php echo $colour;?>"></div><?php
							}
							?>
						</div>
					<?php } else { ?>
					<div class="img-col position-relative d-none <?php echo $class;?>">
							<?php if($add_overlay) {
								?><img class="frame frame-top position-absolute" src="/wp-content/uploads/2025/04/Photo-overlay_top-corner.png"/>
								 <img class="frame frame-bottom position-absolute" src="/wp-content/uploads/2025/04/Photo-overlay_bottom-corner.png"/><?php
							}
							?>
							<img class="img" src="<?php echo $image["url"]; ?>" alt="<?php echo $image['alt']; ?>" <?php echo $style;?>/>
							<?php if($add_overlay) {
								?><div class="position-absolute colour <?php echo $colour;?>"></div><?php
							}
							?>
						</div>
					
						<div class="text">
							<?php echo $text; ?>
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
					<?php } ?>
				</div>

				<div class="custom-col-2">
					<?php if ($show_img === 'Right') { ?>
						<div class="img-col position-relative <?php echo $class;?>">
							<?php if($add_overlay) {
								?><img class="frame frame-top position-absolute" src="/wp-content/uploads/2025/04/Frames_decoration_top_.png"/>
								 <img class="frame frame-bottom position-absolute" src="/wp-content/uploads/2025/04/Frames_decoration_bottom_.png"/><?php
							}
							?>
							<img class="img" src="<?php echo $image["url"]; ?>" alt="<?php echo $image['alt']; ?>" <?php echo $style;?>/>
							<?php if($add_overlay) {
								?><div class="position-absolute colour <?php echo $colour;?>"></div><?php
							}
							?>
						</div>
					<div class="text d-none">
							<?php echo $text; ?>
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
					<?php } else { ?>
						<div class="text">
							<?php echo $text; ?>
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
					<?php } ?>
				</div>

			</div>
		</div>
	</div>
<?php } ?>
