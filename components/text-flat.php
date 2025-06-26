<?php
$text = get_sub_field('text');
$background_colour = get_sub_field('select_background_colour');
$add_pattern = get_sub_field('add_pattern');
$pattern_position = get_sub_field('show_pattern_on_the');
$size = get_sub_field('select_pattern_size');
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

if(!empty($text)) {
	?><div class="full-container <?php echo $background_colour;?> shaped text-container">
	<div class="custom-shape-divider-top section-top">
    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="shape-fill"></path>
    </svg>
</div>
	<?php if(!empty($pattern)) {
		?><img src="<?php echo $pattern;?>" alt="" class="position-absolute pattern pattern-<?php echo $pattern_position;?>"/><?php
	}
	?>
	<div class="custom-container">
		<div class="content-shape">
			<div class="limited-width">
				
			
		<?php echo $text;?>
			
		<?php if(have_rows('button')) {
		while(have_rows('button')) {
			the_row();
			$text = get_sub_field('text');
			$link = get_sub_field('link');
			$colour = get_sub_field('select_background_colour') ? get_sub_field('select_background_colour') : 'black';
			if(!empty($text) && !empty($link) ) {
		?> <a class="custom-button <?php echo $colour;?>" href="<?php echo $link;?>"><?php echo $text;?></a><?php
			}
		}
	}
	?>
				</div>
			</div>
	</div>

</div>
<?php
}