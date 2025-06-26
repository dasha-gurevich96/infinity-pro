<?php
$section_heading = get_sub_field('section_heading');
$content = get_sub_field('text');
if(have_rows('quotes')) {
	?><div class="full-container">
	<div class="custom-container two-cols-container">
		<div>
			
		
	<?php if(!empty($section_heading)) {
		?>
		<h2>
		<?php echo $section_heading;?>
	</h2>
		<?php
	}
	if(!empty($content)) {
		echo $content;
	}
	?>
	<div class="quotes">
		<?php while(have_rows('quotes')) {
			the_row();
			$text = get_sub_field('text');
			$author = get_sub_field('author');
			$image = get_sub_field('author_image');
			if(!empty($text)) {
				?><blockquote>
				<?php echo $text;?>
				<?php 
				if(!empty($author)) {
					?>
						<div class="author">
							<?php if(!empty($image)) {
								?> <div class="img-author">
								<img class="circle object-fit-cover" src="<?php echo $image['url'];?>" alt="<?php echo $image['alt'];?>">
							</div>
							<?php
							}
							?>
							<div class="name-col">
								<p><cite><?php echo $author;?></cite></p>
							</div>
						</div>
				<?php
				}
				?>
				</blockquote>
			<?php
			}
	}
	?>
		</div>
		</div>
	</div>
</div>
	<?php
}