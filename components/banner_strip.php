<?php 


$select_background_colour = get_field('select_background_colour') ? get_field('select_background_colour') : 'blue';
if($select_background_colour === 'lilac') {
	$class = 'lilac';
	$src = '/wp-content/uploads/2025/03/Purple_Pattern_large.svg';
} elseif($select_background_colour === 'pink') {
	$class = 'pink';
	$src = '/wp-content/uploads/2025/03/pink_Pattern.svg';
} else {
	$class = 'blue';
	$src = '/wp-content/uploads/2025/03/Resources_banner-Pattern.svg';
}

?><div class="full-container shaped banner-strip">
	<div class="custom-shape-divider-top banner-top" class="bg-<?php echo $class;?>">
		<svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
			<path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="shape-fill"></path>
		</svg>
	</div>
	<div class="content-shape position-relative <?php echo $class;?>">
		<img class="position-absolute pattern-banner" src="<?php echo $src;?>" />
		<div class="custom-container">
			<?php
			if (have_rows('page_title')) {
				while (have_rows('page_title')) {
				the_row();
				$light = get_sub_field('light_part');
				$bold = get_sub_field('bold_part');
				if (!empty($light) || !empty($bold)) {
					?>
					<h1 class="white-shape">
						<?php echo $light; ?>
						<strong><?php echo $bold; ?></strong>
					</h1>
					<?php
				} else {
				
				?>
					<h1 class="white-shape">
						<?php the_title();?>
					</h1>
				<?php
			
				}
			}
		} else {
				?>
					<h1 class="white-shape">
						<?php the_title();?>
					</h1>
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
</div>