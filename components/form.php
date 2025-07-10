<?php
$title = get_sub_field('title');
$text = get_sub_field('text');
$shortcode = get_sub_field('shortcode');

if(!empty($shortcode)) {
    ?><div class="full-container">
        <div class="custom-container form-container">
            <div class="form-text mb-5">
        <?php if(!empty($title)) {
            ?><h2><?php echo $title;?></h2><?php
        }
        if(!empty($text)) {
            ?><div class="text">
                <?php echo $text;?>
                </div>
                <?php
        }
        ?></div>
        <div id="error-summary" class="error-summary" role="alert"  style="display:none;">
  <h2 id="error-summary-title">Please fix the following errors:</h2>
  <ul></ul>
</div>
        <?php
        echo do_shortcode($shortcode);?>
            
            </div>
        </div>
        <?php
}