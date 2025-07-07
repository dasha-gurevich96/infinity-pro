<?php
if(have_rows('cards')) {
    ?><div class="cards cards-extra slider-mobile">
        <?php while(have_rows('cards')) {
            the_row();
            $image = get_sub_field("image");
            $title = get_sub_field('title');
            $text = get_Sub_field('text');
            $link = get_sub_field('link');
          

            if(!empty($image) && !empty($title) && !empty($link)) {
                ?><div class="card importance-card resource-card clickable-card">
                    <div>
                    <div class="graphics">
                        <img class="card-img" src="<?php echo $image['url'];?>" alt="<?php echo $image['alt'];?>""/>
                    </div>
                    <div class="text">
                        <h3><?php echo $title;?></h3>
                        <?php if(!empty($text)) {
                            ?><p>
                                <?php echo $text;?>
                            </p>
                        <?php
                        }
                        ?>
                    </div>
                    </div>
                    <?php   
                if(!empty($link)) {
				$link_text = 'Learn more';
                // Get lowercase file extension
				$extension = strtolower(pathinfo(parse_url($link, PHP_URL_PATH), PATHINFO_EXTENSION));

				switch ($extension) {
					case 'pdf':
					$link_text = 'Download PDF';
					break;
					case 'doc':
					$link_text = 'Download DOC';
					break;
					case 'docx':
					$link_text = 'Download DOCX';
					break;
					}
					?> <a href="<?php echo $link;?>" class="custom-button learn-more d-flex" aria-label="<?php echo $link_text;?> of <?php the_title();?>">
						<span><?php echo $link_text;?></span>
						<img class="arrow arrow-more" src="/wp-content/uploads/2025/06/Arrow-right.svg" alt=""/>
						</a>
						<?php
								
				}
                ?>
                </div>
                <?php
            }


        }
    ?>
    </div>
    <?php
}