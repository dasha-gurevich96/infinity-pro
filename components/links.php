<?php
$title = get_sub_field('title');
 if (have_rows('link')) : ?>
<?php if(!empty($title)) {
    ?><h3><?php echo $title;?></h3><?php
}
?>
                    <div class="links d-flex flex-column gap-3">
                        <?php while (have_rows('link')) : the_row(); 
                            $link_text = get_sub_field("link_text");
                            $link = get_sub_field('link');

                            if (!empty($link_text) && !empty($link)) : ?>
                                <a class="d-flex align-items-center gap-3 download-file" href="<?= esc_url($link); ?>" target="_blank" rel="noopener noreferrer">
                                    <img class="icon" src="/wp-content/uploads/2025/07/file-solid-1.svg" alt="">
                                    <?= esc_html($link_text); ?>
                                </a>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>

