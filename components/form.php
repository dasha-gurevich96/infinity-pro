<?php
$title = get_sub_field('title');
$text = get_sub_field('text');
$shortcode = get_sub_field('shortcode');

if(!empty($shortcode)) {
    ?><div class="full-container">
        <div class="custom-container form-container">
        <?php if(!empty($title)) {
            ?><h2><?php echo $title;?><?php
        }
        if(!empty($text)) {
            ?><div class="text">
                <?php echo $text;?>
                </div>
                <?php
        }
        echo do_shortcode($shortcode);?>
            
            </div>
        </div>
        <?php
}