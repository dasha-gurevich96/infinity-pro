<?php

$title = get_sub_field('title_above');
$count = 0;

if (have_rows('logos')) {
	while(have_rows('logos')) {
		the_row();
		$count++;
	}
}
if (have_rows('logos')) {
	if($count > 1 ) {
		$class = "logos-slider";
		
	}  else {
		$class = 'logo-container';
	
	}
	?><div class="full-container">
	<div class="custom-container">
		<div class="logos-main">
	
<?php
	if(!empty($title)) {
		?><h2>
			<?php echo $title;?>
		</h2>
		<?php
	}
	?><div class="<?php echo $class;?> logos">
	<?php
	while(have_rows('logos')) {
		the_row();
		$image = get_sub_field('image');
		$link = get_sub_field('link');
		$organisation_title = get_sub_field('organisation_title');
		if(!empty($image) && !empty($organisation_title)) {
			?><div class="logo-container clickable-card">
	<?php if(!empty($link)) {
				?>
				<a aria-label="Logo link of <?php echo $organisation_title;?> - opens in a new window" href="<?php echo $link;?>">
					<img src="<?php echo $image['url'];?>" alt="" />
		</a>
	<?php
			} else {
				$alt = $image['alt'] ? $image['alt'] : 'logo of ' . $organisation_title;?> 
			  <img src="<?php echo $image['url'];?>" alt="" /><?php
			}
				?>
			</div>
			<?php
		}
	}
	?> </div>
		</div>
	</div>
</div><?php
}