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
	?><div class="full-container section-title <?php echo $background_colour;?> shaped text-container" id="<?php echo strtolower(str_replace(' ', '-', $text));?>">
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
		<h2 class="mb-0">
			
			<?php echo $text;?>
			</h2>
			<?php if(!empty(get_sub_field('subtitle'))) {
		?><p><?Php
		echo get_sub_field('subtitle');?>
			</p>
			<?php
	}
	?>
			</div>
	</div>
	<div class="custom-shape-divider-bottom section-bottom">
    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="shape-fill"></path>
    </svg>
</div>
</div>
<?php
}