<?php
 if (have_rows('links')) : ?>
                    <div class="links d-flex flex-column gap-3">
                        <?php while (have_rows('links')) : the_row(); 
                            $link_text = get_sub_field("link_text");
                            $link = get_sub_field('link');

                            if (!empty($link_text) && !empty($link)) : ?>
                                <a class="d-flex download-file" href="<?= esc_url($link); ?>" target="_blank" rel="noopener noreferrer">
                                    <img src="/wp-content/uploads/2025/07/file-solid-1.svg" alt="">
                                    <?= esc_html($link_text); ?>
                                </a>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>

