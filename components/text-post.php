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
			$pattern = '/wp-content/uploads/2025/03/Inner-pages_pattern_circles.svg';
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
	?><div class="full-container light-<?php echo $background_colour;?> text-container">

	<?php if(!empty($pattern)) {
		?><img src="<?php echo $pattern;?>" alt="" class="position-absolute pattern pattern-<?php echo $pattern_position;?>"/><?php
	}
	?>
	<div class="custom-container two-cols-container">
		<div>
			
		<?php echo $text;?>
			</div>
	</div>

</div>
<?php
}