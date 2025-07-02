<?php

$text_above = get_sub_field('text_above_collapsibles');
$background_colour = get_sub_field('background_colour');


if (have_rows('collapsibles')) {
	?> <div class="full-container <?php echo $background_colour;?>-bg">
	<?php
    $counter = rand(1, 10000);
    $counter_tabs = rand(1, 10000);
?> <div class=""><div class="custom-container"><?php
	if(!empty($text_above)) {
		?>
				<?php echo $text_above;?>
	
		<?php
	}
    ?>
    <div class="collapsibles" <?php if (!empty($id)) { ?>id="<?php echo $id; ?>"<?php } ?>>

        <div class="accordion accordion-flush" id="accordion-<?php echo $counter; ?>">
            <?php 
            while (have_rows('collapsibles')) {
                the_row();
                $collapsible_title = get_sub_field('collapsible_title');
				$icon = get_sub_field('icon');
                $counter_tabs++;
                if (!empty($collapsible_title) && have_rows('collapsible_description')) { ?>
                    <div class="accordion-item tab">
                        <h2 class="accordion-header exclude" id="heading-<?php echo $counter_tabs; ?>">
                            <button class="accordion-button d-flex collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $counter_tabs; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $counter_tabs; ?>">
								<?php if(!empty($icon)) {
									?><img class="icon" src="<?php echo $icon;?>" alt="" /><?php
									}
								?>
                                <span class="tab-title"><?php echo $collapsible_title; ?></span>
                            </button>
                        </h2>
                        <div id="collapse-<?php echo $counter_tabs; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $counter_tabs; ?>" data-bs-parent="#accordion-<?php echo $counter; ?>" role="tabpanel">
                            <div class="accordion-body">
                                <?php 
                                while (have_rows('collapsible_description')) {
                                    the_row(); 
                                    if(get_row_layout() === 'text') {
										$text = get_sub_field('text');
										if(!empty($text)) {
											?>
												<div class="custom-container">
													<?php echo $text;?>
												</div>	
											
										<?php
										}
									} elseif(get_row_layout() === 'buttons') {
										if(have_rows('buttons')) {
											?>
											<div class="custom-container">
														<div class="buttons-container d-flex">
																	<?php while(have_rows('buttons')) {
																		the_row();
																		$btn_link = get_sub_field('button_link');
																		$btn_text = get_sub_field('button_text');
																		$bg = get_sub_field('button_background_colour');
																		if(!empty($btn_link) && !empty($btn_text)) {
																			?>
																			<a href="<?php echo $btn_link;?>" class="button button-<?php echo $bg;?>">
																				<?php echo $btn_text;?>
																			</a>
																		<?php
																		}
																	}
																?>
																</div>
											</div>
											
										<?php
										}
									} elseif(get_row_layout() === 'images') {
										if(have_rows('images')) {
											?>
											<div class="custom-container">
												<div class="d-flex images-container justify-content-center align-items-stretch gap-5">
																<?php while(have_rows('images')) {
																	the_row();
																	$img = get_sub_field('image_tab');
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
											</div>
										<?php
										}
										
									}
                                } 
                                ?>
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
	</div>

</div>
<?php
}
?>
