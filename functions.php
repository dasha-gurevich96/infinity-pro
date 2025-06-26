<?php
/**
 * Infinity Pro.
 *
 * This file adds functions to the Infinity Pro Theme.
 *
 * @package Infinity
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/infinity/
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Infinity Pro' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/infinity/' );
define( 'CHILD_THEME_VERSION', '1.2.0' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Include customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Add image upload and color select to theme customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Add the required WooCommerce functions.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Add the required WooCommerce custom CSS.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Include notice to install Genesis Connect for WooCommerce.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );

add_action( 'after_setup_theme', 'genesis_child_gutenberg_support' );
/**
 * Adds Gutenberg opt-in features and styling.
 *
 * Allows plugins to remove support if required.
 *
 * @since 1.2.0
 */
function genesis_child_gutenberg_support() {

	require_once get_stylesheet_directory() . '/lib/gutenberg/init.php';

}

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'infinity_localization_setup' );
function infinity_localization_setup(){
	load_child_theme_textdomain( 'infinity-pro', get_stylesheet_directory() . '/languages' );
}

// Enqueue scripts and styles.
add_action( 'wp_enqueue_scripts', 'infinity_enqueue_scripts_styles' );
function infinity_enqueue_scripts_styles() {

	wp_enqueue_style( 'infinity-fonts', '//fonts.googleapis.com/css?family=Cormorant+Garamond:400,400i,700|Raleway:700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'infinity-ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), CHILD_THEME_VERSION );

	wp_enqueue_script( 'infinity-match-height', get_stylesheet_directory_uri() . '/js/match-height.js', array( 'jquery' ), '0.5.2', true );
	wp_enqueue_script( 'infinity-global', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery', 'infinity-match-height' ), '1.0.0', true );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'infinity-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menus' . $suffix . '.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'infinity-responsive-menu',
		'genesis_responsive_menu',
		infinity_responsive_menu_settings()
	);

}

// Define our responsive menu settings.
function infinity_responsive_menu_settings() {

	$settings = array(
		'mainMenu'         => __( 'Menu', 'infinity-pro' ),
		'menuIconClass'    => 'ionicons-before ion-ios-drag',
		'subMenu'          => __( 'Submenu', 'infinity-pro' ),
		'subMenuIconClass' => 'ionicons-before ion-chevron-down',
		'menuClasses'      => array(
			'others' => array(
				'.nav-primary',
			),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Add accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'width'           => 400,
	'height'          => 130,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

// Add image sizes.
add_image_size( 'mini-thumbnail', 75, 75, TRUE );
add_image_size( 'team-member', 600, 600, TRUE );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Remove header right widget area.
unregister_sidebar( 'header-right' );

// Remove secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Remove site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Remove output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

// Remove navigation meta box.
add_action( 'genesis_theme_settings_metaboxes', 'infinity_remove_genesis_metaboxes' );
function infinity_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );
}

// Remove skip link for primary navigation.
add_filter( 'genesis_skip_links_output', 'infinity_skip_links_output' );
function infinity_skip_links_output( $links ) {

	if ( isset( $links['genesis-nav-primary'] ) ) {
		unset( $links['genesis-nav-primary'] );
	}

	return $links;

}

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Header Menu', 'infinity-pro' ), 'secondary' => __( 'Footer Menu', 'infinity-pro' ) ) );

// Reposition primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Reposition the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

// Add offscreen content if active.
add_action( 'genesis_after_header', 'infinity_offscreen_content_output' );
function infinity_offscreen_content_output() {

	$button = '<button class="offscreen-content-toggle"><i class="icon ion-ios-close-empty"></i> <span class="screen-reader-text">' . __( 'Hide Offscreen Content', 'infinity-pro' ) . '</span></button>';

	if ( is_active_sidebar( 'offscreen-content' ) ) {

		echo '<div class="offscreen-content-icon"><button class="offscreen-content-toggle"><i class="icon ion-ios-more"></i> <span class="screen-reader-text">' . __( 'Show Offscreen Content', 'infinity-pro' ) . '</span></button></div>';

	}

	genesis_widget_area( 'offscreen-content', array(
		'before' => '<div class="offscreen-content"><div class="offscreen-container"><div class="widget-area"><div class="wrap">',
		'after'  => '</div>' . $button . '</div></div></div>',
	));

}

// Reduce secondary navigation menu to one level depth.
add_filter( 'wp_nav_menu_args', 'infinity_secondary_menu_args' );
function infinity_secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

// Modify size of the Gravatar in the author box.
add_filter( 'genesis_author_box_gravatar_size', 'infinity_author_box_gravatar' );
function infinity_author_box_gravatar( $size ) {
	return 100;
}

// Modify size of the Gravatar in the entry comments.
add_filter( 'genesis_comment_list_args', 'infinity_comments_gravatar' );
function infinity_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;

	return $args;

}

// Setup widget counts.
function infinity_count_widgets( $id ) {

	$sidebars_widgets = wp_get_sidebars_widgets();

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

// Determine the widget area class.
function infinity_widget_area_class( $id ) {

	$count = infinity_count_widgets( $id );

	$class = '';

	if ( $count == 1 ) {
		$class .= ' widget-full';
	} elseif ( $count % 3 == 1 ) {
		$class .= ' widget-thirds';
	} elseif ( $count % 4 == 1 ) {
		$class .= ' widget-fourths';
	} elseif ( $count % 2 == 0 ) {
		$class .= ' widget-halves uneven';
	} else {
		$class .= ' widget-halves';
	}

	return $class;

}

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Register widget areas.
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => __( 'Front Page 1', 'infinity-pro' ),
	'description' => __( 'This is the front page 1 section.', 'infinity-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'Front Page 2', 'infinity-pro' ),
	'description' => __( 'This is the front page 2 section.', 'infinity-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => __( 'Front Page 3', 'infinity-pro' ),
	'description' => __( 'This is the front page 3 section.', 'infinity-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-4',
	'name'        => __( 'Front Page 4', 'infinity-pro' ),
	'description' => __( 'This is the front page 4 section.', 'infinity-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-5',
	'name'        => __( 'Front Page 5', 'infinity-pro' ),
	'description' => __( 'This is the front page 5 section.', 'infinity-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-6',
	'name'        => __( 'Front Page 6', 'infinity-pro' ),
	'description' => __( 'This is the front page 6 section.', 'infinity-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-7',
	'name'        => __( 'Front Page 7', 'infinity-pro' ),
	'description' => __( 'This is the front page 7 section.', 'infinity-pro' ),
) );

genesis_register_sidebar( array(
	'id'          => 'front-page-8',
	'name'        => __( 'Front Page 8', 'infinity-pro' ),
	'description' => __( 'This is the front page 8 section.', 'infinity-pro' ),
) );

genesis_register_sidebar( array(
	'id'          => 'front-page-9',
	'name'        => __( 'Front Page 9', 'infinity-pro' ),
	'description' => __( 'This is the front page 9 section.', 'infinity-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'lead-capture',
	'name'        => __( 'Lead Capture', 'infinity-pro' ),
	'description' => __( 'This is the lead capture section.', 'infinity-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'offscreen-content',
	'name'        => __( 'Offscreen Content', 'infinity-pro' ),
	'description' => __( 'This is the offscreen content section.', 'infinity-pro' ),
) );


/***PASSION4SOCIAL CODE
================================*/

/*** ENQUEUE STYLES
-----------------------------*/
add_action( 'wp_enqueue_scripts', 'infinity_custom_styles', 999);  

function infinity_custom_styles() {
	wp_enqueue_style( 'infinity-bootstrap', get_stylesheet_directory_uri() . '/bootstrap/bootstrap.min.css', array(), '1.0.0' );
	wp_enqueue_style( 'custom-stylesheet', get_stylesheet_directory_uri() . '/style-p4s.css', array(), '2.10.1' );
	wp_enqueue_script('external-links-js', get_stylesheet_directory_uri() . '/js/external-links.js', array(), '1.0', true);
	wp_enqueue_script('clickable-card-js', get_stylesheet_directory_uri() . '/js/clickable-card.js', array(), '1.0', true);
	wp_enqueue_script('menu-top-js', get_stylesheet_directory_uri() . '/js/accessible-top-menu.js', array(), '1.0', true);
	wp_enqueue_script('read-js', get_stylesheet_directory_uri() . '/js/read-more.js', array(), '1.0', true);
	//wp_enqueue_script('fixed-js', get_stylesheet_directory_uri() . '/js/add-fixed-class.js', array(), '1.0', true);
	wp_enqueue_script('site-search-js', get_stylesheet_directory_uri() . '/js/site-search.js', array(), '1.0', true);
	wp_enqueue_script('bootstrap-js', get_stylesheet_directory_uri() . '/bootstrap/bootstrap.min.js', array(), '1.0', true);
}

/*** BACK TO TOP
--------------------*/
/*** BACK TO TOP
-------------------*/
add_action('genesis_before_footer', 'do_back');
function do_back() {
	?>
	<a href="#page-top" id="backToTop" class="back-to-top custom-button" aria-label="Back to top">Back to top</a>
<?php
}

add_action('genesis_before', 'do_container');
function do_container() {
	?>
<span id="page-top"></span>
<?php
}


add_action('wp_footer', function () {
    ?>
    <script>
        jQuery(document).ready(function($) {
			const $backToTopLink = $('#backToTop');
			const $footer = $('footer'); // Adjust if your footer has a different selector

			$(window).on('scroll resize', function() {
				const scrollTop = $(window).scrollTop();
				const windowHeight = $(window).height();
				const footerOffsetTop = $footer.offset().top;

				// Show/hide back-to-top button
				if (scrollTop > 100) {
					$backToTopLink.css('display', 'block');
				} else {
					$backToTopLink.css('display', 'none');
				}

				// Detect if button is overlapping footer
				const buttonBottom = scrollTop + windowHeight;
				if (buttonBottom > footerOffsetTop) {
					$backToTopLink.addClass('over-footer'); // Add class for styling
				} else {
					$backToTopLink.removeClass('over-footer');
				}
			});

			// Scroll to top on click
			$backToTopLink.click(function(e) {
				$('#page-top').attr('tabindex', '-1').focus();
			});
	});

    </script>
    <?php
});


/*** DISABLE SUPERFISH
--------------------------*/
function infinity_remove_superfish_nav_primary( $args ) {
 if( 'primary' == $args['theme_location'] ) {
 $args['menu_class'] = 'menu genesis-nav-menu menu-primary';
   }
return $args;
}

add_filter( 'wp_nav_menu_args', 'infinity_remove_superfish_nav_primary' );

/*** PHP SUPPORT
---------------------*/
//Enable PHP support in text widget 
function php_execute($html){
	if(strpos($html,"<"."?php")!==false){
		ob_start(); 
		eval("?".">".$html); 
		$html=ob_get_contents();
		ob_end_clean(); 
	}
return $html; 
}
add_filter('widget_text','php_execute',100);

// Disable Editor in the Text Widget
add_action( 'admin_init', function() {
	global $wp_scripts;
    if ( $wp_scripts ) {
            $wp_scripts->remove( 'text-widgets' );
        }
    });
add_action('in_widget_form', function( $widget, $return, $instance )
		   {
        if ($widget->id_base=='text')
        {
            $filter = isset( $instance['filter'] ) ? $instance['filter'] : 0;
            $title = isset( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : '';
            $text = isset( $instance['text'] ) ? esc_textarea( $instance['text']) : '';
            ?>
            <p>
                <label for="<?php echo $widget->get_field_id('title'); ?>"><?php esc_html_e( 'Title', 'deepsoul'); ?>:</label>
                <input class="widefat" id="<?php echo $widget->get_field_id('title'); ?>" name="<?php echo $widget->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            </p>
            <p>
                <label for="<?php echo $widget->get_field_id('text'); ?>"><?php esc_html_e( 'Content', 'deepsoul' ); ?>:</label>
                <textarea class="widefat" rows="16" cols="20" id="<?php echo $widget->get_field_id('text'); ?>" name="<?php echo $widget->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
            </p>
            <p>
                <input id="<?php echo $widget->get_field_id('filter'); ?>" name="<?php echo $widget->get_field_name('filter'); ?>" type="checkbox"<?php checked( $filter ); ?> class="checkbox onoff"/>
                <label for="<?php echo $widget->get_field_id('filter'); ?>"><?php esc_html_e( 'Automatically add paragraphs', 'deepsoul' ); ?></label>
            </p>
            <?php
        }
    }, 10, 3);
add_filter('widget_update_callback', function( $instance, $new_instance, $old_instance, $widget )
    {
        if ( $widget->id_base == 'text' )
        {
            $instance['filter'] = ! empty( $new_instance['filter'] );
        }
        return $instance;
    }, 10, 4);

remove_filter('widget_text_content', 'wpautop');
		   

// allow .svg files
function add_svg_to_upload_mimes($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'add_svg_to_upload_mimes');


/*** HEADER
================================*/
// Remove the default Genesis header function
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_do_nav', 12 );

add_action('genesis_before_header', 'infinity_socials', 12 );

function infinity_socials() {
    if(have_rows('social','options')) {
        ?> 
        <div class="top-bar blue-bg">
            <?php while(have_rows('social', 'options')) {
                the_row();
                $media = get_sub_field('select_channel');
                $link = get_sub_field('link');
                if(!empty($media) && !empty($link)) {
					$src= '';
                    $class = 'flickr';
					if($media ==='Facebook') {
						$src="/wp-content/uploads/2025/06/Asset-1.svg";
					} elseif($media ==='X') {
						$src="/wp-content/uploads/2025/06/Asset-2.svg";
					} elseif($media ==='Vimeo') {
						$src="/wp-content/uploads/2025/06/Asset-4.svg";
					} elseif($media ==='Flickr') {
						$src="/wp-content/uploads/2025/06/Asset-3.svg";
                        $class="flickr";
					}
                    ?><a class="social-icon <?php echo $class;?>" href="<?php echo $link;?>" aria-label="<?php echo $media;?> profile - opens in a new window"><img src="<?php echo $src;?>" alt="" /></a>
                    <?php
				}

            }
            ?>
        </div>
        <?php
    }
}

function buttons_header() {
    	if(have_rows('social_media_buttons', 'options')) {
			?><div class="social-media d-flex">
			<?php while(have_rows('social_media_buttons','options')) {
				the_row();
				$media = get_sub_field('media');
				$link = get_sub_field('link');
				if(!empty($media) && !empty($link)) {
					$src= '';
					if($media ==='Facebook') {
						$src="/wp-content/uploads/2025/03/Youtube_icon_grey-e1742386530501.png";
					} elseif($media ==='Instagram') {
						$src="/wp-content/uploads/2025/03/linked-in-icon_grey-e1742386512950.png";
					} elseif($media ==='Medium') {
						$src="/wp-content/uploads/2025/03/medium_icon_grey-e1742386489104.png";
					}
			?><a class="social-icon move-up" href="<?php echo $link;?>" aria-label="<?php echo $media;?> profile - opens in a new window"><img src="<?php echo $src;?>" alt="" /></a>
			<?php
				}
			}
			?>
			</div>
			<?php
		}

	$button_text = get_field('button_text', 'options');
	$button_link = get_field('button_link', 'options');
	?><div class="buttons-header">
		<div class="custom-container">
			<?php if(!empty($button_text) && !empty($button_link)) {
				?><a href="<?php echo $button_link;?>" class="move-up header-btn lilac">
					<?php echo $button_text;?></a>
				<?php
			}
	
			?>
			
	  </div>
	</div>
<?php
}


//add_action('genesis_header', 'buttons_header', 2);

// Add a custom header function without link around logo
//add_action( 'genesis_header', 'custom_genesis_header' );
function custom_genesis_header() {
    ?><div class="title-area"><h1 itemprop="headline"><a  class="site-title" href="/"><?php bloginfo('name'); ?></a> </h1></div>
<?php
} 

/*** FOOTER
================*/
remove_action('genesis_footer', 'genesis_do_footer');
add_action('genesis_footer', 'genesis_do_custom_footer');

function genesis_do_custom_footer() {
	$logo = get_field('logo', 'options');
	$text_logo = get_field('text_under_logo', 'options');
	$title_above_links = get_field('title_above_links', 'options');
	$contact_us_title = get_field('contact_us_title', 'options');
	$title_above_social_media = get_field('title_above_social_media', 'options')
	?><div class="full-container">
		<div class="custom-container">
			<div class="footer-columns row">
				<div class="col footer-col">
					<?php if(!empty($logo)) {
						?><div class="ath-container">
								<a href="/">
									<img alt="Catalyst logo - link to the home page" src="<?php echo $logo['url'];?>"/>
								</a>
							</div>
					<?php 
					}
					if(!empty($text_logo)) {
						?><div class="des-container">
					<?php echo $text_logo;?>
							</div>
					<?php
					}
	?>
				</div>
				<div class="col contact-us footer-col">
					<div>
						<?php if(!empty($title_above_links)) {
							?><h2 class="footer-title">
								<?php echo $title_above_links;?>
								</h2>
						<?php
						}
					if(have_rows('links', 'options')) {
						?><div class="links"><?php
						while(have_rows('links', 'options')) {
							the_row();
							$text = get_sub_field('text');
							$link = get_sub_field('link');
							?><a href="<?php echo $link;?>"><?php echo $text;?></a><?php
						}
						?></div><?php
					}
	?>
					
					</div>
				</div>
				<div class="col socials">
					<div>
						<?php if(!empty($title_above_social_media)) {
							?><h2 class="footer-title">
								<?php echo $title_above_social_media;?>
								</h2>
						<?php
							if(have_rows('social_media_buttons', 'options')) {
								?><div class="social-media d-flex">
								<?php while(have_rows('social_media_buttons','options')) {
									the_row();
									$media = get_sub_field('media');
									$link = get_sub_field('link');
									if(!empty($media) && !empty($link)) {
										$src= '';
										if($media ==='Youtube') {
											$src="/wp-content/uploads/2025/03/Youtube_icon_grey-e1742386530501.png";
										} elseif($media ==='Instagram') {
											$src="/wp-content/uploads/2025/03/linked-in-icon_grey-e1742386512950.png";
										} elseif($media ==='Medium') {
											$src="/wp-content/uploads/2025/03/medium_icon_grey-e1742386489104.png";
										}
								?><a class="social-icon move-up" href="<?php echo $link;?>" aria-label="<?php echo $media;?> profile - opens in a new window"><img src="<?php echo $src;?>" alt="" /></a>
								<?php
									}
								}
								?>
								</div>
								<?php
							}
						}
	
	
					
	?>
					</div>
				
					<?php
					$text_above_funders = get_field('text_above_funders', 'options');
					$select_funders = get_field('select_funders', 'options');
					if(!empty($text_above_funders) && !empty($select_funders)) {
						
						?>
						<div class="funders">


						<h2>
								<?php echo $text_above_funders;?>
							 </h2>
							<div class="logos logos-slider-footer">
								<?php
							foreach($select_funders as $funder_id) {
								$img_f = get_field('image', $funder_id);
								$link_f = get_field('external_link', $funder_id);
								if(!empty($img_f) && !empty($link_f)) {
									?><a href="<?php echo $link_f;?>" aria-label="Logo link of the <?php echo get_the_title($funder_id);?>">
										<img class="logo" src="<?php echo $img_f;?>" alt="" />
										</a><?php
								} elseif(empty($link_f)) {
									?><img class="logo" src="<?php echo $img_f;?>" alt="Logo of <?php echo  get_the_title($funder_id);?>" /><?php
								}
							}
								?>
							</div>
						</div>
					<?php
					}
	
				?>
			
					
					
				</div>
				
				
			
				
					<?php if(have_rows('policy_links', 'options')) {
					?><div class="policies d-flex"><?php
						while(have_rows('policy_links', 'options')) {
							the_row();
							$link = get_sub_field('link');
							$link_text = get_sub_field('text');
							if(!empty($link) && !empty($link_text)) {
								?><a class="policy" href="<?php echo $link;?>"><?php echo $link_text;?></a><?php
							}
						}
					?></div><?php
					}
	?>
				
				
			</div>
		</div>
	</div>
<?php
}


/*** SLICK SLIDER
======================+*/
function enqueue_slick_assets() {
    
        // Enqueue Slick CSS in the <head>
        wp_enqueue_style('slick-core', '//cdn.jsdelivr.net/npm/@accessible360/accessible-slick@1.0.1/slick/slick.min.css', [], null);
        wp_enqueue_style('slick-theme', '//cdn.jsdelivr.net/npm/@accessible360/accessible-slick@1.0.1/slick/slick-theme.min.css', ['slick-core'], null);
        wp_enqueue_style('accessible-slick-theme', '//cdn.jsdelivr.net/npm/@accessible360/accessible-slick@1.0.1/slick/accessible-slick-theme.min.css', ['slick-core'], null);

        // Enqueue Slick JS in the footer
        wp_enqueue_script('slick-js', '//cdn.jsdelivr.net/npm/@accessible360/accessible-slick@1.0.1/slick/slick.min.js', ['jquery'], null, true);
		wp_enqueue_script('custom-slick-init', get_stylesheet_directory_uri() . '/js/slickr-init.js', ['jquery', 'slick-js'], null, true);
  
}
add_action('wp_enqueue_scripts', 'enqueue_slick_assets');


/*** SOCIAL SHARE
=======================*/
function add_social_share_buttons_global() {
		// Get the current page URL
		$url = esc_url(get_permalink());

		// Get the current page title
		$title = urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8'));
		$bluesky_text = $title . ' ' . $url;
		// Create an array of social networks and their respective sharing URLs
		$social_networks = array(
			'Facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . $url,
			'LinkedIn' => 'https://www.linkedin.com/shareArticle?url=' . $url . '&title=' . $title,
			'Bluesky' => 'https://bsky.app/intent/compose?text=' . $bluesky_text,
		
		);

		// Initialize the share buttons HTML
		$share_buttons = '<div class="social-media d-flex">';
		foreach ($social_networks as $network => $share_url) {
			$img = '';
			if($network === 'Facebook') {
				$img = '<img src="/wp-content/uploads/2025/03/facebook-f-brands.svg" alt="Share on Facebook">';
			} elseif($network === 'LinkedIn') {
				$img = '<img src="/wp-content/uploads/2025/03/linkedin-in-brands.svg" alt="Share on LinkedIn">';
			} /*elseif($network === 'X (Twitter)') {
				$img = '<img src="/wp-content/uploads/2025/03/x-twitter-brands.svg" alt="Share on X (formerly Twitter)">';
			}*/ elseif($network === 'Bluesky') {
				$img = '<img src="/wp-content/uploads/2025/04/bluesky-brands.svg" alt="Share on Bluesky">';
			} 

			$share_buttons .= '<a class="social-icon move-up" href="' . esc_url($share_url) . '" target="_blank" rel="noopener" aria-label="Share via ' . esc_attr($network) . ' (opens in a new tab)">' . $img . '</a>';
		}
		// Close the share buttons HTML
		$share_buttons .= '</div>';


		return $share_buttons;
	}


/*** DATE
================*/
function update_post_show_date_on_publish($post_id) {
    // Ensure it's not an autosave or a non 'resource-article' post
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    if (get_post_type($post_id) !== 'post') {
        return $post_id;
    }

    // Get the post's publish date
    $post_date = get_the_date('Y-m-d', $post_id); // Get the full date of the post

    // Get the current year
    $current_year = date('Y');
    
    // Convert the post date to a DateTime object
    $date_obj = DateTime::createFromFormat('Y-m-d', $post_date);

    if ($date_obj) {
        // Check if the post is from the current year
        if ($date_obj->format('Y') == $current_year) {
            // Format the date as 'd M' (without the year) if it's the current year
            $formatted_date = $date_obj->format('d M');
        } else {
            // Otherwise, include the year (for past years)
            $formatted_date = $date_obj->format('d M Y');
        }

        // Update the ACF field 'post_show_date' with the formatted date
        update_field('post_show_date', $formatted_date, $post_id);
    }

    return $post_id;
}

// Hook into WordPress save post action to update the post_show_date field when a post is published
add_action('save_post', 'update_post_show_date_on_publish');





/***BREADCRUMBS
----------------*/
//add_filter( 'genesis_breadcrumb_args', 'customize_breadcrumb_args' );

add_filter( 'genesis_breadcrumb_args', 'sp_breadcrumb_args' );
function sp_breadcrumb_args( $args ) {
    $args['labels']['prefix'] = '';
	$args['sep'] = ' - ';
	return $args;
}

// Remove breadcrumbs from their default location
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//add_action( 'genesis_after_header', 'custom_genesis_breadcrumbs' );

function custom_genesis_breadcrumbs() {
    ?>
    <div class="screen-reader-text">You are here:</div>
    <nav aria-label="<?php esc_attr_e( 'Breadcrumbs', 'genesis' ); ?>">
        <?php genesis_do_breadcrumbs(); ?>
    </nav>
    <?php
}


/*** NAVIGATION TO NEXT PAGE BASED ON MENU
---------------------------------------------*/
//add_action('genesis_before_footer', 'adjacent_entry_nav_c', 999);

function display_previous_next_page_links($menu_id) {
    // Get the current page
    $current_page_id = get_the_ID();

    // Get the menu assigned to the specified menu ID
    $menu_items = wp_get_nav_menu_items($menu_id);
    if (!$menu_items) {
        return;
    }
	

    // Find the current page's position in the menu
    $current_page_position = null;
    foreach ($menu_items as $key => $menu_item) {
        if ($menu_item->object_id == $current_page_id) {
            $current_page_position = $key;
            break;
        }
    }

    if ($current_page_position === null) {
        return;
    }

    // Get the IDs of the previous and next pages based on the menu order
    $previous_page_id = ($current_page_position > 0) ? $menu_items[$current_page_position - 1]->object_id : null;
    $next_page_id = ($current_page_position < count($menu_items) - 1) ? $menu_items[$current_page_position + 1]->object_id : null;

    if (!$previous_page_id && !$next_page_id) {
        return;
    }

    echo '<div class="page-nav"><div class="custom-container"><nav class="pager w-100"><div class="page-footer-nav  adjacent-entry-pagination">';

    // Output previous page link
    if ($previous_page_id) {
        $previous_page_title = $menu_items[$current_page_position - 1]->title;
       	echo '<a rel="prev" class="arrow-link nav-button prev" href="' . get_permalink($previous_page_id) . '">';
		echo '<img src="/wp-content/uploads/2025/03/Arrow_left_white.svg" alt=""/>';
        echo '<span>Go to ' . $previous_page_title . '</span>';
        echo '</a>';;
    }

    // Output next page link
    if ($next_page_id) {
        $next_page_title = $menu_items[$current_page_position + 1]->title;

        echo '<a rel="next" class="arrow-link nav-button next" href="' . get_permalink($next_page_id) . '">';
        echo '<span>Go to ' . $next_page_title . '</span>';
		echo '<img src="/wp-content/uploads/2025/03/Left_Arrow.svg" alt=""/>';
        echo '</a>';

    }

    echo '</div></div></nav></div>';
}

function adjacent_entry_nav_c() {
    // Check if the navigation function exists
    if (!function_exists('the_post_navigation') || is_single()) {
        return;
    }

    // Get the current page ID
    $current_page_id = get_the_ID();

    // Get all registered navigation menus
    $registered_menus = get_terms('nav_menu', array('hide_empty' => true));
    if (!$registered_menus) {
        return;
    }

    // Initialize a variable to store the menu ID
    $selected_menu_id = null;

    // Iterate through each registered menu
    foreach ($registered_menus as $menu) {
     // header menu
        if ($menu->term_id === 2) {
            continue;
        }
		//main support menu
		 if ($menu->term_id === 9 && !is_page_template('page_landing_ccvs.php')) {
            continue;
        }
		//main volunteering menu
		 if ($menu->term_id === 91 && !is_page_template('page_landing_ccvs.php')) {
            continue;
        }
		

        // Get the menu items for the current menu
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        if (!$menu_items) {
            continue;
        }

        // Check if any menu item corresponds to the current page
        foreach ($menu_items as $item) {
            if ($item->object == 'page' && $item->object_id == $current_page_id) {
                $selected_menu_id = $menu->term_id;
                break 2; // Break both the inner and outer loops
            }
        }
    }

    if ($selected_menu_id) {
        echo '<div class="entry-content"><div class="text-content">';
        display_previous_next_page_links($selected_menu_id);
        echo '</div></div></div>';
    } else {
		echo '<div class="components-below-sidebar page-nav"><div class="custom-container"></div></div>';
	}
}


/**/
function set_featured_image_from_title($post_id) {
    if (get_post_type($post_id) !== 'resource-articles') {
        return;
    }

    $post_title = get_the_title($post_id);
    
    // Match the image URL and alt text
    if (preg_match('/(https?:\/\/[^\s\|]+)\|([^\]]+)/', $post_title, $matches)) {
        $image_url = esc_url_raw($matches[1]);
        $alt_text = sanitize_text_field($matches[2]);

        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        // Download the image and add it to the media library
        $attachment_id = media_sideload_image($image_url, $post_id, '', 'id');

        if (!is_wp_error($attachment_id)) {
            // Set alt text
            update_post_meta($attachment_id, '_wp_attachment_image_alt', $alt_text);
            
            // Set as featured image
            set_post_thumbnail($post_id, $attachment_id);
        }
    }
}

function clean_post_title($post_id) {
    if (get_post_type($post_id) !== 'resource-articles') {
        return;
    }

    $post_title = get_the_title($post_id);
    
    // Remove the image URL, alt text, and trailing `]`
    $clean_title = preg_replace('/\s*https?:\/\/[^\s\|]+\|[^\]]+\]?/', '', $post_title);

    // Trim to remove any extra spaces left behind
    $clean_title = trim($clean_title, " \t\n\r\0\x0B]");

    // Update the post title only if it has changed
    if ($clean_title !== $post_title) {
        remove_action('save_post', 'clean_post_title'); // Prevent infinite loop
        wp_update_post([
            'ID' => $post_id,
            'post_title' => $clean_title,
        ]);
        add_action('save_post', 'clean_post_title'); // Re-add action after update
    }
}


// Hook both functions separately
//add_action('save_post', 'set_featured_image_from_title');
//add_action('save_post', 'clean_post_title');

function update_post_date_from_taxonomy($post_id) {
    if (get_post_type($post_id) !== 'resource-articles') {
        return;
    }

    // Get the term associated with the 'date_1' taxonomy
    $terms = get_the_terms($post_id, 'date_2');

    if ($terms && !is_wp_error($terms)) {
        // Get the first term's name (assuming one term per post)
        $date_string = $terms[0]->name;

        // Extract the date part from the string (we only need the date)
        // Remove the extra details like timezone info after the actual date-time
        preg_match('/(.*)\sGMT[^\)]+/', $date_string, $matches);

        if (isset($matches[1])) {
            // Convert the date string to a valid DateTime object
            $date = DateTime::createFromFormat('D M d Y H:i:s', $matches[1]);

            if ($date) {
                // Format the date to 'Y-m-d H:i:s'
                $formatted_date = $date->format('Y-m-d H:i:s');
                // Get the GMT equivalent of the formatted date
                $formatted_date_gmt = get_gmt_from_date($formatted_date);

                // Update the post's publish date
                remove_action('save_post', 'update_post_date_from_taxonomy'); // Prevent infinite loop
                wp_update_post([
                    'ID'           => $post_id,
                    'post_date'    => $formatted_date,
                    'post_date_gmt'=> $formatted_date_gmt, // Ensure GMT time is also updated
                ]);
                add_action('save_post', 'update_post_date_from_taxonomy'); // Re-add action after update
            }
        }
    } else {
        // If no term is found or there's an error, update the post status to 'draft'
        remove_action('save_post', 'update_post_date_from_taxonomy'); // Prevent infinite loop
        wp_update_post([
            'ID'          => $post_id,
            'post_status' => 'draft', // Change status to draft
        ]);
        add_action('save_post', 'update_post_date_from_taxonomy'); // Re-add action after update
        return $post_id;
    
	}
}

// Hook the function to save_post action
//add_action('save_post', 'update_post_date_from_taxonomy');
function update_authors_news_terms($post_id) {
    if (get_post_type($post_id) !== 'post') {
        return;
    }

    // Get the 'authors-news' terms for the post
    $terms = get_the_terms($post_id, 'authors-news');

    // If terms exist, proceed to update
    if ($terms && !is_wp_error($terms)) {
        // Initialize an empty array to store term slugs
        $new_term_slugs = [];

        foreach ($terms as $term) {
            // Check if the term name contains a semicolon (';')
            if (strpos($term->name, ';') !== false) {
                // Split the term name by ';' to get individual terms
                $new_terms = explode(';', $term->name);

                // Process each term and add it to the array
                foreach ($new_terms as $new_term) {
                    $new_term = trim($new_term);  // Trim any extra spaces

                    // Check if the term already exists by slug
                    $new_term_obj = term_exists($new_term, 'authors-news');
                    
                    // If the term doesn't exist, create it
                    if (!$new_term_obj) {
                        // Create term and get the term ID
                        $new_term_obj = wp_insert_term($new_term, 'authors-news');
                    }

                    // Get the term slug (not the term ID)
                    if (isset($new_term_obj['term_id'])) {
                        $new_term_slug = get_term($new_term_obj['term_id'])->slug;
                        $new_term_slugs[] = $new_term_slug;  // Add the slug to the array
                    }
                }
            }
        }

        // Assign the new term slugs to the post (by slug)
        if (!empty($new_term_slugs)) {
            wp_set_post_terms($post_id, $new_term_slugs, 'authors-news');
        }
    }
}

// Hook the function to run when a post is saved
//add_action('save_post', 'update_authors_news_terms');

function update_authors_news_term_and_image($post_id) {
    // Ensure we're working with 'authors-catalyst' custom post type
    if (get_post_type($post_id) !== 'authors-catalyst') {
        return;
    }

    // Get the post title and slug
    $post_title = get_the_title($post_id);
    $post_slug = get_post_field('post_name', $post_id); // Get the slug of the post

    // Get the post content to extract the image
    $post_content = get_post_field('post_content', $post_id);

    // Extract the image URL from the post content (assuming it's already in the Media Library)
    preg_match_all('/<img[^>]+src="([^">]+)"[^>]*alt="([^">]*)"/', $post_content, $matches);

    // If an image URL is found, proceed with updating the term and ACF field
    if (!empty($matches[1])) {
        // Extract the first image's URL
        $image_url = $matches[1][0];

        // Get the attachment ID from the image URL
        $attachment_id = attachment_url_to_postid($image_url);

        // If the image is found in the Media Library, proceed
        if ($attachment_id) {
            // Get the term by slug in the 'authors-news' taxonomy
            $term = get_term_by('slug', $post_slug, 'authors-news');

            if ($term) {
                // Update the term name with the post title
                wp_update_term($term->term_id, 'authors-news', [
                    'name' => $post_title, // Set term name to post title
                ]);

                // Update the ACF field with the attachment ID for the term (Image field)
                // The value must be an array with the attachment ID
                update_field('author_image', ['ID' => $attachment_id], 'authors-news_' . $term->term_id);
            }
        }
    }
}

// Hook the function to run when a post is saved in 'authors-catalyst'
//add_action('save_post', 'update_authors_news_term_and_image');

function update_external_link_from_content($post_id) {
    // Ensure it's not a WordPress autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // Only target the 'resource-articles' custom post type
    if (get_post_type($post_id) != 'resource-articles') {
        return $post_id;
    }

    // Get the post content
    $post_content = get_post_field('post_content', $post_id);

    // Regular expression to match all URLs starting with https://
    preg_match_all('/https:\/\/[^\s"]+/', $post_content, $matches);

    // Check if there's only one URL and no other content
    if (count($matches[0]) === 1 && trim($post_content) === $matches[0][0]) {
        // Only one URL is found and it is the only content, update ACF field
        $external_link = $matches[0][0]; // Get the URL

        // Update the ACF field with the extracted URL
        update_field('external_link', $external_link, $post_id);
    } else {
        // Optionally, if there's no URL or other content, you can set the field to empty
        update_field('external_link', '', $post_id);
    }

    return $post_id;
}

// Hook into WordPress save post action to update the external link when a post is saved
//add_action('save_post', 'update_external_link_from_content');
//
//


function display_airtable_data() {
    $api_token = 'patZBBgePOK34glkK.f6dccabe9d86cd8065f4a8813d9714ac646705b445f648df818af43566d36b7d';
    $base_id = 'appO2hsv7Dkq2w5RK';
    $table_name = 'tblOwYr0TJsMFDvcU';
    $url = "https://api.airtable.com/v0/$base_id/$table_name";

    $response = wp_remote_get($url, array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_token,
            'Content-Type'  => 'application/json'
        )
    ));

    if (is_wp_error($response)) {
        return 'Error fetching data';
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    var_dump($data);
    if (!empty($data['records'])) {
       
        foreach ($data['records'] as $record) {
            $fields = $record['fields'];
            
            // Output the "Programme / Fund name"
            $programme_name = isset($fields['Programme / Fund name']) ? esc_html($fields['Programme / Fund name']) : 'No Name Provided';
            $funder_name = isset($fields['Funder name']) ? esc_html($fields['Funder name']) : 'No Funder name';
			$current_status = isset($fields['Current status']) ? esc_html($fields['Current status']) : 'No Current status';
			$focus_area = isset($fields['Focus area']) ? esc_html($fields['Focus area']) : 'No Focus area';
			$grantnav = isset($fields['GrantNav or annual report link']) ? esc_html($fields['GrantNav or annual report link']) : 'No grantnav';
			$deadlines = isset($fields['Any deadlines?']) ? esc_html($fields['Any deadlines?']) : 'No deadlines';
			$stay_informed = isset($fields['How to stay informed']) ? esc_html($fields['How to stay informed']) : 'No info'; 
			$last_updated = isset($fields['Last updated']) ? esc_html($fields['Last updated']) : 'No update info';
            // Output the "Website"
            $website = isset($fields['Website']) ? esc_url($fields['Website']) : '#';

            // Output the "Eligibility restrictions"
            $eligibility = isset($fields['Eligibility restrictions']) ? esc_html($fields['Eligibility restrictions']) : 'No restrictions listed';


            echo '<h3>' . $programme_name . '</h3>';
			$focus_area = isset($fields['Focus area']) ? $fields['Focus area'] : [];
        $focus_area_html = '';
        foreach ($focus_area as $focus) {
            $focus_area_html .= '<span class="focus-area">' . esc_html($focus) . '</span> ';
        }
        $focus_area_html = rtrim($focus_area_html);
        echo '<p><strong>Funder Name:</strong> ' . $funder_name . '</p>';
        echo '<p><strong>Current Status:</strong> ' . $current_status . '</p>';
        echo '<p><strong>Focus Area:</strong> ' . $focus_area_html . '</p>';
		
        echo '<p><strong>GrantNav/Annual Report:</strong> <a href="' . $grantnav . '" target="_blank">' . $grantnav . '</a></p>';
        echo '<p><strong>Deadlines:</strong> ' . $deadlines . '</p>';
        echo '<p><strong>How to Stay Informed:</strong> <a href="' . esc_url($stay_informed) . '" target="_blank">' . $stay_informed . '</a></p>';
        echo '<p><strong>Website:</strong> <a href="' . $website . '" target="_blank">' . $website . '</a></p>';
        echo '<p><strong>Eligibility:</strong> ' . $eligibility . '</p>';
        echo '<p><strong>Last Updated:</strong> ' . $last_updated . '</p>';
        echo '<p><strong>Status:</strong> ' . $current_status . '</p>';
          
        }
        
    } else {
        echo '<p>No data found.</p>';
    }
}

//display_airtable_data();
function fetch_grants_1() {
    $api_token = 'patZBBgePOK34glkK.f6dccabe9d86cd8065f4a8813d9714ac646705b445f648df818af43566d36b7d';
    $base_id = 'appO2hsv7Dkq2w5RK';
    $table_name = 'tblOwYr0TJsMFDvcU';
    $url = "https://api.airtable.com/v0/$base_id/$table_name";

    $response = wp_remote_get($url, array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_token,
            'Content-Type'  => 'application/json'
        )
    ));

    // Check for errors
    if (is_wp_error($response)) {
        return 'Error: ' . $response->get_error_message();
    }

    // Parse response
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    // Validate JSON response
    if (json_last_error() !== JSON_ERROR_NONE) {
        return 'Error: Invalid JSON response';
    }
var_dump($data);
    return $data;
}

//fetch_grants_1();


// add editor the privilege to edit theme

// get the the role object
$role_object = get_role( 'editor' );

// add $cap capability to this role object
$role_object->add_cap( 'edit_theme_options' );

/** UPDATE TERMS ON INIT
===============================*/
//add_action('init', 'assign_news_term_to_all_posts');

function assign_news_term_to_all_posts() {
	// Only run this once
	if ( get_option('r_term_assigned') ) {
		return;
	}

	// Get all published posts
	$all_posts = get_posts([
		'post_type'      => 'resource-articles',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
	]);

	foreach ($all_posts as $post) {
		wp_set_post_terms($post->ID, ['Resource'], 'information-type', true); // true = append to existing terms
	}

	// Set flag so this doesn't run again
	update_option('r_term_assigned', true);
}


/** GET IMAGE CAPTION
==========================*/
function update_image_caption_for_all_posts_old() {
    // Query to get all posts
    $args = array(
        'post_type' => 'post', // Assuming you're working with posts; adjust if needed
        'posts_per_page' => -1, // Get all posts
        'post_status' => 'publish', // Only published posts
    );

    $query = new WP_Query($args); // Custom WP_Query for handling posts

    // Check if we have posts
    if ($query->have_posts()) {
        // Loop through each post
        while ($query->have_posts()) {
            $query->the_post(); // Set up the current post

            $post_id = get_the_ID();
            $content = get_the_content(); // Get the post content

            // Use regular expressions to find the <p id="">—</p> followed by <p> starting with "Photo by"
            $pattern = '/(Photo by.*?)(<\/p>)/i';
			$pattern_2 = '/(Image credit.*?)(<\/p>)/i';
			$pattern_3 = '/(Image.*?)(<\/p>)/i';

            // Perform the regex match and check if there's a match
            if (preg_match($pattern, $content, $matches)) {
                $photo_by_text = trim($matches[1]); // Get the "Photo by" text

                // Update the ACF field 'image_caption' with the extracted "Photo by" value
                update_field('image_caption', $photo_by_text, $post_id);
            } elseif(preg_match($pattern_2, $content, $matches)) {
                $photo_by_text_2 = trim($matches[1]); // Get the "Photo by" text

                // Update the ACF field 'image_caption' with the extracted "Photo by" value
                update_field('image_caption', $photo_by_text_2, $post_id);
            } elseif(preg_match($pattern_3, $content, $matches)) {
                $photo_by_text_3 = trim($matches[1]); // Get the "Photo by" text

                // Update the ACF field 'image_caption' with the extracted "Photo by" value
                update_field('image_caption', $photo_by_text_3, $post_id);
            }
        }

        // Reset post data after the custom query
        wp_reset_postdata();
    }
}

add_action('init', 'update_image_caption_for_all_posts');

function update_image_caption_for_all_posts() {
    $args = array(
        'post_type'      => 'resource-articles',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $post_id = get_the_ID();
            $post = get_post($post_id); // Get full post object
            $content = $post->post_content; // Raw content

            $original_content = $content;

            $patterns = [
                '/<p[^>]*>(Photo by.*?<\/p>)/i',
                '/<p[^>]*>(Image credit.*?<\/p>)/i'
            ];

            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $content, $matches)) {
                    // Optional: update ACF field from inner text
                    if (preg_match('/>(.*?)<\/p>/', $matches[0], $innerMatch)) {
                        $caption = trim($innerMatch[1]);
                
                    }

                    // Remove entire matched <p> element
                    $content = str_replace($matches[0], '', $content);
                    break;
                }
            }

            if ($content !== $original_content) {
                wp_update_post([
                    'ID'           => $post_id,
                    'post_content' => $content,
                ]);
            }
        }

        wp_reset_postdata();
    }
}



function update_image_caption_for_all_res() {
    // Query to get all posts
    $args = array(
        'post_type' => 'resource-articles', // Assuming you're working with posts; adjust if needed
        'posts_per_page' => -1, // Get all posts
        'post_status' => 'publish', // Only published posts
    );

    $query = new WP_Query($args); // Custom WP_Query for handling posts

    // Check if we have posts
    if ($query->have_posts()) {
        // Loop through each post
        while ($query->have_posts()) {
            $query->the_post(); // Set up the current post

            $post_id = get_the_ID();
            $content = get_the_content(); // Get the post content

            // Use regular expressions to find the <p id="">—</p> followed by <p> starting with "Photo by"
            $pattern = '/(Photo by.*?)(<\/p>)/i';
			$pattern_2 = '/(Image credit.*?)(<\/p>)/i';
			$pattern_3 = '/(Image by.*?)(<\/p>)/i';

            // Perform the regex match and check if there's a match
            if (preg_match($pattern, $content, $matches)) {
                $photo_by_text = trim($matches[1]); // Get the "Photo by" text

                // Update the ACF field 'image_caption' with the extracted "Photo by" value
                update_field('image_caption', $photo_by_text, $post_id);
            } elseif(preg_match($pattern_2, $content, $matches)) {
                $photo_by_text_2 = trim($matches[1]); // Get the "Photo by" text

                // Update the ACF field 'image_caption' with the extracted "Photo by" value
                update_field('image_caption', $photo_by_text_2, $post_id);
            } elseif(preg_match($pattern_3, $content, $matches)) {
                $photo_by_text_3 = trim($matches[1]); // Get the "Photo by" text

                // Update the ACF field 'image_caption' with the extracted "Photo by" value
                update_field('image_caption', $photo_by_text_3, $post_id);
            }
        }
       }

        // Reset post data after the custom query
        wp_reset_postdata();
    }



//add_action('init', 'update_image_caption_for_all_res');
//
//
//
add_action('template_redirect', function () {
    if (is_admin()) return;

    $request_uri = $_SERVER['REQUEST_URI'];
    $parsed_url = parse_url($request_uri);
    $path = rtrim($parsed_url['path'], '/');

    // Check if the URL starts with /news/
    if (preg_match('#^/news/(.+)$#', $path, $matches)) {
        $new_path = '/' . $matches[1] . '/';
        wp_redirect(home_url($new_path), 301);
        exit;
    }
});


function move_trashed_posts_to_old_news() {
    $args = array(
        'post_type'   => 'post', // Original post type
        'post_status' => 'trash',
        'numberposts' => -1,
    );

    $trashed_posts = get_posts($args);

    foreach ($trashed_posts as $post) {
        // Change post type to 'old-news'
        wp_update_post(array(
            'ID'        => $post->ID,
            'post_type' => 'old-news',
            'post_status' => 'draft' // Set to draft so it's not still "trashed"
        ));

     
    }
}
//add_action('admin_init', 'move_trashed_posts_to_old_news');


