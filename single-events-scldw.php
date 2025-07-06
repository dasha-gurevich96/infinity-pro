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
	$classes[] = 'inner-page event post';

	return $classes;

}

function banner() {
	get_template_part('/components/event-banner');
}


add_action( 'genesis_entry_header', 'banner');

function custom_content() {
    $date_text = get_field('date_text');
	$event_description = get_field('event_description');
    $accessibility = get_field('accessibility');
    $about_organiser = get_field('about_organiser');
    $organiser_logo = get_field('organiser_logo');
	$venue = get_field('venue');
	$post_id = get_the_ID(); // or use a specific post ID
	$thumbnail_id = get_post_thumbnail_id($post_id);
	$image_url = wp_get_attachment_url($thumbnail_id);
	$image_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
    $date_text_with_time = get_field('date_text_with_time');
?>
    <div class="pattern-right">
    </div>
    <div class="pattern-left">
    </div>
    <div class="custom-container event-container">
        <a href="/events">Go back to events</a>
        <?php if(!empty($image_url)) {
            ?><div class="event-banner">
                <img class="banner-img object-fit-cover" src="<?php echo $image_url;?>" alt="<?php echo $image_alt;?>" />
            </div>
            <?php
        }
        ?>
        <div class="logo-text-container">
            <div class="text">
             <h1><?php the_title();?></h1>
             <?php if(!empty($venue)) {
									?>
									<p class="text-icon d-flex gap-3">
									<img class="icon" src="/wp-content/uploads/2025/06/Icon_location.svg" alt="" />
									<span><?php echo $venue['address'];?></span>
									</p>
									<?php
								}
								?>
								<?php if(!empty($date_text)) {
									?>
									<p class="text-icon d-flex gap-3 align-items-start">
										<img class="icon" src="/wp-content/uploads/2025/06/Icon_calendar.svg" alt="" />
										<span><?php echo $date_text;?></span>
									</p>
									<?php
								}
								?>
            </div>
            <div class="logo-col">
                <?php if(!empty($organiser_logo)) {
						?><img class="logo org object-fit-contain" src="<?php echo $organiser_logo['url'];?>" alt="<?php echo $organiser_logo['alt'];?>" /><?php
					}
				?>
            </div>
        </div>
        <div class="eventinfo">
            <div class="event-details">
                <h2>Event times</h2>
                <?php echo $date_text_with_time;?>
            </div>
            <?php if(!empty($event_description)) {
                ?><div class="event-details">
                    <h2>About</h2>
                    <?php echo $event_description;?>
                </div>
                <?php
            }
            ?>
            <?php if(!empty($accessibility)) {
                ?><div class="event-details">
                    <h2>Acessibility</h2>
                    <?php echo $accessibility;?>
                </div>
                <?php
            }
            ?>
             <?php if(!empty($about_organiser)) {
                ?><div class="event-details">
                    <h2>About organiser</h2>
                    <?php echo $about_organiser;?>
                </div>
                <?php
            }
            ?>
        </div>
       
</div>
       
<?php

}

add_action( 'genesis_entry_content', 'custom_content');


genesis();