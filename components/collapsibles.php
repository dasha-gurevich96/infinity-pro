<?php

$text_above = get_sub_field('text_above');
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
                $collapsible_title = get_sub_field('collapsible_tab_title');
				$link_to_page = get_sub_field('link_to_page');
				$link = get_sub_field('link');
                $counter_tabs++;
				if(!empty($collapsible_title) && $link_to_page && !empty($link)) {
					?>
					<h2 class="accordion-header">
                            <a class="accordion-button d-flex collapsed" href="<?php echo $link;?>"  >
                                <span class="tab-title"><?php echo $collapsible_title; ?></span>
								<img src="/wp-content/uploads/2025/06/Icon-other-page.svg" alt="" class="icon" />
							</a>
							
                        </h2>
					<?php
				} elseif (!empty($collapsible_title) && have_rows('collapsible_description')) { ?>
                    <div class="accordion-item tab">
                        <h2 class="accordion-header exclude" id="heading-<?php echo $counter_tabs; ?>">
                            <button class="accordion-button d-flex collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $counter_tabs; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $counter_tabs; ?>">
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
												
													<?php echo $text;?>
											
											
										<?php
										}
									} elseif(get_row_layout() === 'buttons') {
										if(have_rows('buttons')) {
											?>
										
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
											
											
										<?php
										}
									} elseif(get_row_layout() === 'image') {
										if(have_rows('image')) {
											$contain_image = get_sub_field('contain_image') ? 'object-fit-contain' : 'object-fit-cover' ;
											$background_colour = get_sub_field('background_colour');
											$image = get_sub_field('image');
											if(!empty($image)) {
												?><img class="tab-image <?php echo $contain_image;?>" style="background-color: <?php echo $background_colour;?> "src="<?php echo $image['url'];?>" alt="<?php echo $image['alt'];?>" />
												<?php
											}
											?>
											 
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
