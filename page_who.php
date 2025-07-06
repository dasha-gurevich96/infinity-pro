<?php

 /**
 * Infinity Pro.
 *
 * This file adds the main page template to the Infinity Pro Theme.
 * 
 * Template Name: Who are we
 *
 *
 * @package Infinity
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/infinity/
 */

remove_action('genesis_entry_content', 'genesis_do_post_content');
remove_action('genesis_entry_header', 'genesis_do_post_title');
// Add landing page body class to the head.
add_filter( 'body_class', 'infinity_add_body_class' );
function infinity_add_body_class( $classes ) {
	$classes[] = 'who-page inner-page';
	return $classes;

}

function banner() {
	get_template_part('/components/banner');
}


add_action( 'genesis_entry_header', 'banner');

add_action( 'genesis_entry_content', 'custom_content' );

function custom_content() {
    $title = get_field("title");
    $title_w = get_field('title_working_group');
    $cardCount = 0; // used to manage rows
    $pairIndex = 0; // used for button IDs

    ?>
    <div class="full-container">
        <div class="custom-container">
            <?php if (!empty($title)) { ?>
                <h2 class="text-center thanks-title"><?php echo $title; ?></h2>
            <?php }

            if (have_rows('working_group_cards')) { ?>
                <div class="group">
                    <?php if (!empty($title_w)) { ?>
                        <h3 class="text-center title-w"><?php echo $title_w; ?></h3>
                    <?php } ?>

                     <p class="screen-reader-text">
                            Below is the slider with the working group members.
                            On desktop devicies each slide has information about two working group members. On mobueles each slide has information about one working group member.
                    </p>

                    <div class="working-group-cards">
                       
                        <?php while (have_rows('working_group_cards')) {
                            the_row();
                            $name = get_sub_field('name');
                            $role = get_sub_field('role');
                            $bio = get_sub_field('bio');

                            if (!empty($name) && !empty($role)) {
                                // Open new row if this is the first or every odd card
                                if ($cardCount % 2 === 0) {
                                    echo '<div class="bio-row d-flex justify-content-center">';
                                }

                                $pairIndex++;
                                ?>
                                <div class="bio-card">
                                    <div class="container-bio-card">
                                        <div class="detail"></div>
                                        <div class="column-1">
                                            <div class="logo-diamond-container position-relative">
                                                <img class="diamond" src="/wp-content/uploads/2025/07/Diamond-with-purple-border.svg" alt="" />
                                                <img class="logo" src="/wp-content/uploads/2025/07/SCLD_Logo.svg" alt="" />
                                            </div>
                                            <div class="text">
                                                <div>
                                                    <h3><?php echo $name; ?></h3>
                                                    <p><?php echo $role; ?></p>
                                                </div>
                                                <?php if (!empty($bio)) { ?>
                                                    <button id="toggleButton<?php echo $pairIndex; ?>" class="d-flex custom-button dark-green bio-button" aria-controls="bio-content<?php echo $pairIndex; ?>" aria-expanded="false">
                                                        <span class="text">Read bio</span>
                                                        <img src="/wp-content/uploads/2025/06/Arrow-right.svg" alt="" class="arrow icon"/>
                                                    </button>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <?php if (!empty($bio)) { ?>
                                            <div class="column-2 d-none" id="bio-content<?php echo $pairIndex; ?>">
                                                <div class="line"></div>
                                                <p><?php echo $bio; ?></p>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php

                                $cardCount++;

                                // Close row after every 2nd card
                                if ($cardCount % 2 === 0) {
                                    echo '</div>'; // close bio-row
                                }
                            }
                        }

                        // If odd number of cards, close last open row
                        if ($cardCount % 2 !== 0) {
                            echo '</div>'; // close last unclosed .bio-row
                        }
                        ?>
                    </div>
                </div>
            <?php } ?>
            <?php
            $title_partners = get_field('title_partners');
            if(have_rows('supporting_partners')) {
                ?><div class="group logos-grpup">
                    <?php
                 if (!empty($title_partners)) { ?>
                        <h3 class="text-center title-p"><?php echo $title_partners; ?></h3>
                    <?php }
                    ?><div class="logos-cards">
                        <?php while(have_rows('supporting_partners')) {
                            the_row();
                            $logo = get_sub_field('logo');
                            $organisation_name = get_sub_field('organisation_name');
                            $link = get_sub_field('link');
                            $class = '';
                            if(!empty($link)) {
                                $class="clickable-card";
                            } else {
                                $class='';
                            }
                            if(!empty($logo) && !empty($organisation_name)) {
                                ?><div class="logo-card <?php echo $class;?>">
                                        <img class="logo object-fit-contain" src="<?php echo  $logo['url'];?>" alt="<?php echo  $logo['alt'];?>" />
                                        <h3>
                                        <?php if(!empty($link)) {
                                          ?><a href="<?php echo $link;?>">
                                          <?php echo $organisation_name;?>
                                          </a>
                                          <?php  
                                        } else {
                                          ?> <?php echo $organisation_name;?>
                                          <?php  
                                        }
                                        ?>
                                        </h3>
                                    </div>
                                <?php
                            }
                        }
                        ?>
                        </div>
                    </div>
                    <?php
            }

            $title_f = get_field('title_funded_by');
            if(have_rows('funders')) {
                ?><div class="group funders-group">
                      <?php
                 if (!empty($title_f)) { ?>
                        <h3 class="text-center title-p"><?php echo $title_f; ?></h3>
                    <?php }
                    ?>
                    <div class="funders-cards">
                        <?php while(have_rows('funders')) {
                            the_row();
                            $logo = get_sub_field('logo');
                            $organisation_name = get_sub_field('organisation_name');
                            $text = get_sub_field('text');
                            $link = get_sub_field('link');
                            if(!empty($logo) && !empty($organisation_name)) {
                                ?><div class="card full-card">
                                    <div class="logo-diamond-container position-relative">
                                        <img class="diamond" src="/wp-content/uploads/2025/07/Diamond-with-purple-border.svg" alt="">
                                        <img class="logo" src="<?php echo $logo['url'];?>" alt="<?php echo $logo['alt'];?>" />
                                    </div>
                                    <div class="text">
                                        <h4><?php echo $organisation_name;?></h4>
                                        <?php if(!empty($text)) {
                                            ?><p><?php echo $text;?></p><?php
                                        }
                                        ?>
                                    </div>
                                    </div>
                                <?php
                            }

                        }
                        ?>
                    </div>
                 
                    </div>

                    <?php
            }

            ?>
        </div>
    </div>
    <?php
}


genesis();