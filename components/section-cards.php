<?php 

$text = get_sub_field('text_above');
$background_colour = get_sub_field('select_background_colour');
$class = get_sub_field('icon_title_column') ? 'flex-column' : 'gap-3 align-items-center';
if(have_rows('cards')) {
	?><div class="full-container light-<?php echo $background_colour;?>">
	<div class="custom-container">
		<div class="text-above">
			<?php echo $text;?>
		</div>
			
		
	<div class="cards d-grid">
	<?php while(have_rows('cards')) {
		the_row();
		$icon = get_sub_field('icon');
		$title = get_sub_field('title');
		$text = get_sub_field('text');
		
		if(!empty($title) && !empty($text)) {
			?><div class="custom-col">
				<div class="custom-card">
					<?php if(!empty($icon)) {
						?>
				
						 
							<h3 class="icon-title d-flex <?php echo $class;?>">
								<img class="icon" src="<?php echo $icon;?>"/>
								<span><?php echo $title;?></span>
							</h3>
					
					
					<?php
					} else {
						?>
							<h3>
								<?php echo $title;?>
							</h3>
					<?php
					}
					?>
					<div>
						<?php echo $text;?>
					</div>
				</div>
			</div>
	<?php
		}
	}
	?>
</div>
		</div>
</div>
	<?php
}
