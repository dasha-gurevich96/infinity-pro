<?php if (have_rows('page_title')) {
	?>
	<div class="full-container pb-0">
		<div class="custom-container title-container banner-tow-cols-title">
			<?php
			while (have_rows('page_title')) {
				the_row();
				$light = get_sub_field('light_part');
				$bold = get_sub_field('bold_part');
				if (!empty($light) && !empty($bold)) {
					?>
					<h1>
						<?php echo $light; ?>
						<strong><?php echo $bold; ?></strong>
					</h1>
					<?php
				}
			}
			?>
		</div>
	</div>
	<?php
} else {
	?> <div class="full-container">
		<div class="custom-container title-container">
			<h1>
				the_title();
			</h1>
		</div>
</div>
<?php
}
$banner_title = get_field('banner_title');
$thumbnail_id = get_post_thumbnail_id(); // Get the featured image ID
$thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'large'); // Get the image URL
$alt_text = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
$add_overlay = get_field('add_overlay');
if($add_overlay) {
	$class="overlay-img";
	$style = 'filter: grayscale(100%);';
} else {
	$class="";
	$style = '';
}

$overlay_colour = get_field('overlay_colour');

if(!empty($overlay_colour)) {
	$colour = $overlay_colour;
} else {
	$colour ='';
}

if(!empty($thumbnail_url)) {
	$img_url = $thumbnail_url;
} else {
	$img_url="/wp-content/uploads/2025/03/Image_Frome-edge-to-centre.png";
}

if(!empty($alt_text)) {
	$alt = $alt_text;
} else {
	$alt = '';
}
?><div class="full-container">
	<div class="custom-container">
		<div class="banner-two-cols">
			<div class="banner-col position-relative col-img d-none <?php echo $class;?>">
				<?php if($add_overlay) {
								?><img class="frame frame-top position-absolute" src="/wp-content/uploads/2025/04/Photo-overlay_top-corner.png"/>
								 <img class="frame frame-bottom position-absolute" src="/wp-content/uploads/2025/04/Photo-overlay_bottom-corner.png"/><?php
							}
							?>
				<img class="img-banner" src="<?php echo $img_url;?>" alt="<?php echo $alt;?>" />
				<?php if($add_overlay) {
								?><div class="position-absolute colour <?php echo $colour;?>"></div><?php
							}
							?>
			</div>
			<div class="banner-col position-relative ">
				<?php if(!empty($banner_title)) {
			?><h2>
				<?php echo $banner_title;?>
			</h2>
			<?php 
			}
			?>
			<div class="desc">
				<?php the_content();?>
			</div>
			
			</div>
			<div class="banner-col col-img position-relative <?php echo $class;?>">
				<?php if($add_overlay) {
								?><img class="frame frame-top position-absolute" src="/wp-content/uploads/2025/04/Photo-overlay_top-corner.png"/>
								 <img class="frame frame-bottom position-absolute" src="/wp-content/uploads/2025/04/Photo-overlay_bottom-corner.png"/><?php
							}
							?>
				<img class="img-banner" src="<?php echo $img_url;?>" alt="<?php echo $alt;?>" />
				<?php if($add_overlay) {
								?><div class="position-absolute colour <?php echo $colour;?>"></div><?php
							}
							?>
			</div>
		
		</div>
	</div>
	
</div>
<?php