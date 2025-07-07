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
                ?><div class="card importance-card resource-card">
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
                    <a href="">Link text</a>
                </div>
                <?php
            }


        }
    ?>
    </div>
    <?php
}