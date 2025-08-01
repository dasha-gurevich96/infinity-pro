<?php
/**
 * Infinity Pro.
 *
 * This file adds the single post template to the Infinity Pro Theme.
 * 
 * Template Name: Single Story
 *
 *
 * @package Infinity
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/infinity/
 */


 remove_action('genesis_entry_content', 'genesis_do_post_content');
remove_action('genesis_entry_header', 'genesis_do_post_title');

remove_action('genesis_entry_content', 'genesis_do_post_content');
remove_action('genesis_entry_header', 'genesis_do_post_title');
// Add landing page body class to the head.
add_filter( 'body_class', 'infinity_add_body_class' );
function infinity_add_body_class( $classes ) {
	$classes[] = 'inner-page story post';

	return $classes;

}

add_action( 'genesis_entry_header', 'custom_genesis_breadcrumbs_post' );

function custom_genesis_breadcrumbs_post() {
    ?>
    <div class="screen-reader-text">You are here:</div>
    <nav aria-label="<?php esc_attr_e( 'Breadcrumbs', 'genesis' ); ?>">
        <div class="breadcrumb">
            <a href="/stories">
                Stories
            </a>
            >
            <span class="breadcrumb_last" aria-current="page"><?php the_title();?></span>
        </div>
        <?php genesis_do_breadcrumbs(); ?>
    </nav>
    <?php
}


function banner() {
	$banner_text_1 = get_field('banner_text_1');
    $banner_text_2 = get_field('banner_text_2');
    ?><div class="full-container banner-yellow">
        <div class="custom-container">
            <h1 class="screen-reader-text">
                <?php the_title();?>
            </h1>
            <?php if(!empty($banner_text_1)) {
                ?><div class="purple-bg banner-text-1 banner-text">
                  <p>  <?php echo $banner_text_1;?></p>
                  </div>
                <?php
            }
            ?>
             <?php if(!empty($banner_text_2)) {
                ?><div class="white-bg banner-text-2 banner-text">
                  <p>  <?php echo $banner_text_2;?></p>
                  </div>
                <?php
            }
            ?>
        </div>
        </div>
     <?php
}


add_action( 'genesis_entry_header', 'banner');

function custom_content() {
    $banner_text_1 = get_field('banner_text_1');
    $banner_text_2 = get_field('banner_text_2');
    $intro = get_field("intro");
    $text_in_speech_bubble = get_field('text_in_speech_bubble');
    $image = get_field('image');
    $name = get_field('name');
    if(!empty($intro)) {
            ?><div class="full-container purple-bg position-relative intro-story">
                <div class="custom-container">
                    <div class="smaller-width">
                        <?php echo $intro;?>
                    </div>

                </div>
        </div>
        <img class="purple-wave" src="/wp-content/uploads/2025/06/Stories_Purple-wave.svg" alt="" />
     <?php
    }
    ?>
    <div class="full-container">
        <div class="custom-container">
            <div class="title-img-container">
                <div class="title-quote">
                    <h2 class="meet">
                        <span> Meet </span>
                        <span>
                            <?php if(!empty($name)) {
                                echo $name;
                            } else {
                              the_title();
                            }
                            ?>
                    </span>
                    </h2>
                 
                    <?php
                    if(!empty($text_in_speech_bubble)) {
                        ?><div class="speech-bubble position-relative">
                            <div class="text position-relative">
                                <?php echo $text_in_speech_bubble;?>
                            </div>
                            <img class="quote-tail" src="/wp-content/uploads/2025/06/Quote_tail.svg" alt="" />
                            </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="image-col">
                    <div class="diamond-container position-relative img-diamond">
                        
                        <?php if(!empty($image)) {
                                ?><div class="img-wrapper"><img class="bio-img" src="<?php echo $image['url'];?>" alt="<?php echo $image['alt'];?>" />
                                </div>
                                <?php
                        } else {
                            ?><img src="/wp-content/uploads/2025/06/Stories_temporary-avatar.svg" alt="" class="logo-img"/>
                            <?php
                        }
                        ?>
                    
                    </div>
                </div>
            </div>
        </div>
</div>
        <?php
    if(have_rows('content')) {
        ?><div class="full-container">
            <div class="custom-container">
                <div class="smaller-width story-content">
            <?php
            while(have_rows('content')) {
                the_row();
                $title = get_sub_field('title');
                $text = get_sub_field('text');
                $youtube_id = get_sub_field('youtube_id');
                if((!empty($text) || !empty($youtube_id)) && !empty($title)) {
                    ?><div class="content-cont"><h2 class="content-title">
                        <?php echo $title;?>
                      </h2>
                      <div class="text">
                        <?php echo $text;?>
                    </div>
                    <?php if(!empty($youtube_id)) {
                        ?><div class="video-container-page" data-id="<?php echo $youtube_id;?>">
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $youtube_id;?>?rel=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                        <?php
                }
            }
    }
 
    ?>
    </div>
    </div>
</div>
<div class="full-container mb-0">
    <div class="custom-container">
        <div class="blue-share">
        <h3>Share <?php the_title();?>'s story </h3>
        <?php echo add_social_share_buttons_global();?>
</div>
</div>
</div>

<?php
}

add_action( 'genesis_entry_content', 'custom_content');


genesis();