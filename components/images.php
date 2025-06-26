<?php 
if(have_rows('images')) {
	?><div class="d-flex images-container justify-content-center align-items-stretch gap-3">
		<?php while(have_rows('images')) {
			the_row();
			$img = get_sub_field('image');
			$link = get_sub_field('link');
			$logo = get_sub_field('is_image_a_logo');
			$class = $logo ? 'logo object-fit-contain' : '';
			if(!empty($img) && !empty($link)) {
				?>
				<a href="<?php echo $link;?>" class="clickable-link">
					<img class="img <?php echo $class;?>" src="<?php echo $img['url'];?>" alt="<?php echo $img['alt'];?>" />
				</a>
		<?php
			} elseif(!empty($img)) {
				?>
				<img class="img <?php echo $class;?>" src="<?php echo $img['url'];?>" alt="<?php echo $img['alt'];?>" />
			<?php
			}
		}
	?>
	</div>
<?php
}