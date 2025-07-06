<?php
/**
 * Infinity Pro.
 *
 * This file adds the single post template to the Infinity Pro Theme.
 * 
 * Template Name: Single Event
 *
 *
 * @package Infinity
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/infinity/
 */

function enqueue_google_map_and_jquery() {
    // Enqueue jQuery
    wp_enqueue_script('jquery');

    // Enqueue Google Maps script
    wp_enqueue_script(
        'google-maps',
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyClkhXlN5K5UPahjImKxAg59rKKP5GoCDo',
        array('jquery'), // Set dependency on jQuery
        null,
        true // Load in footer
    );

    // Enqueue your custom map script (inline)
    wp_add_inline_script(
        'google-maps',
        "
        jQuery(function($) {
            function initMap( \$el ) {
                var \$markers = \$el.find('.marker');
                var mapArgs = {
                    zoom: \$el.data('zoom') || 16,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map( \$el[0], mapArgs );
                map.markers = [];
                \$markers.each(function(){
                    initMarker( \$(this), map );
                });
                centerMap( map );
                return map;
            }

            function initMarker( \$marker, map ) {
                var lat = \$marker.data('lat');
                var lng = \$marker.data('lng');
                var latLng = { lat: parseFloat(lat), lng: parseFloat(lng) };
                var marker = new google.maps.Marker({ position: latLng, map: map });
                map.markers.push(marker);
                if (\$marker.html()) {
                    var infowindow = new google.maps.InfoWindow({ content: \$marker.html() });
                    google.maps.event.addListener(marker, 'click', function() {
                        infowindow.open(map, marker);
                    });
                }
            }

            function centerMap(map) {
                var bounds = new google.maps.LatLngBounds();
                map.markers.forEach(function(marker) {
                    bounds.extend({ lat: marker.position.lat(), lng: marker.position.lng() });
                });
                if (map.markers.length == 1) {
                    map.setCenter(bounds.getCenter());
                } else {
                    map.fitBounds(bounds);
                }
            }

            $(document).ready(function() {
                $('.acf-map').each(function() {
                    var map = initMap($(this));
                });
            });
        });
        "
    );
}
add_action('wp_enqueue_scripts', 'enqueue_google_map_and_jquery', 10);
?>


<style type="text/css">
.acf-map {
    width: 100%;
    height: 550px;
    border: #ccc solid 1px;
}


.acf-map img {
   max-width: inherit !important;
}
</style>
<?php
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
                        <span><?php the_title();?></span>
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
                if(!empty($text) && !empty($title)) {
                    ?><div class="content-cont"><h2 class="content-title">
                        <?php echo $title;?>
                      </h2>
                      <div class="text">
                        <?php echo $text;?>
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