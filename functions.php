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
	wp_enqueue_style( 'custom-stylesheet', get_stylesheet_directory_uri() . '/style-p4s.css', array(), '2.16.4' );
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
//remove_action( 'genesis_header', 'genesis_do_header' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

add_action('genesis_before_header', 'infinity_socials', 12 );

function infinity_socials() {
    if(have_rows('social','options')) {
        ?> 
        <div class="top-bar blue-bg">
            <div class="custom-container d-flex justify-content-end">
                <?php while(have_rows('social', 'options')) {
                    the_row();
                    $media = get_sub_field('select_channel');
                    $link = get_sub_field('link');
                    if(!empty($media) && !empty($link)) {
                        $src= '';
                        $class = 'flickr';
                        if($media ==='Facebook') {
                            $class="";
                            $src="/wp-content/uploads/2025/06/Asset-1.svg";
                        } elseif($media ==='X') {
                            $class="";
                            $src="/wp-content/uploads/2025/06/Asset-2.svg";
                        } elseif($media ==='Vimeo') {
                            $src="/wp-content/uploads/2025/06/Asset-4.svg";
                            $class="";
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
        </div>
        <?php
    }
}

add_action('genesis_header', 'logo_button', 2);

function logo_button() {
    $logo = get_field('logo', 'options');
    $button = get_field('button', 'options');
  
        ?><div class="full-container logo-btn-container">
            <div class="custom-container d-flex justify-content-between align-items-center">
               <div class="title-area"><h1 itemprop="headline"><a  class="site-title" href="/"><?php bloginfo('name'); ?></a> </h1></div>  
          
            <?php if(!empty($button)) {
            
                $link = $button['link'];
                $text = $button['text'];
                if(!empty($link) && !empty($text)) {
                    ?><a class="custom-button dark-green" href="<?php echo $link;?>"><?php echo $text;?></a><?php
                }
            }
            ?></div></div><?php
    
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
	$logo_f= get_field('footer_logo', 'options');
	$email = get_field('email_address', 'options');
	$phone = get_field('phone', 'options');
	
	?><div class="full-container footer-container">
		<div class="logo-col">
			<div class="footer-combined d-flex">
				<img src="https://scldw-com.stackstaging.com/wp-content/uploads/2025/06/Footer_yellow.svg" alt="" class="yellow-1 shape-diamond">
				<img src="https://scldw-com.stackstaging.com/wp-content/uploads/2025/06/Footer_green.svg" alt="" class="green-1 shape-diamond">
				<img src="https://scldw-com.stackstaging.com/wp-content/uploads/2025/06/Footer_blue.svg" alt="" class="blue-1 shape-diamond">
			</div>
			<div class="logo-footer-cont position-relative">
				<img src="/wp-content/uploads/2025/06/Footer_white.svg" alt="" class="diamond position-absolute" />
			<a href="/">
				<img class="footer-logo" alt="Scottish Learning Disability Week logo - link to the home page" src="<?php echo $logo_f['url'];?>"/>
			</a>
</div>
		</div>
		<div class="details d-flex">

			<?php if(!empty($phone) || !empty($email)) {
				?>
				<div class="contact">
				<h2 class="footer-title">
					Contact us
				</h2>
			<?php
			if(!empty($email)) {
				?><a href="<?php echo $email;?>"><?php echo $email;?></a><?php
			}
			if(!empty($phone)) {
				$phone_number = $phone['phone_number'];
				$int_phone = $phone['int_phone'];
				if(!empty($phone_number) && !empty($int_phone)) {
					?><a href="tel:<?php echo $int_phone;?>">
					<?php echo $phone_number;?>
					</a>
					<?php
				}
			}
			?></div><?php
			}

		if(have_rows('social','options')) {
        ?> 
        <div class="social-share">
			<h2 class="footer-title">
					Follow us
				</h2>
            <div class="custom-container d-flex">
                <?php while(have_rows('social', 'options')) {
                    the_row();
                    $media = get_sub_field('select_channel');
                    $link = get_sub_field('link');
                    if(!empty($media) && !empty($link)) {
                        $src= '';
                        $class = 'flickr';
                        if($media ==='Facebook') {
                            $class="";
                            $src="/wp-content/uploads/2025/06/Asset-1.svg";
                        } elseif($media ==='X') {
                            $class="";
                            $src="/wp-content/uploads/2025/06/Asset-2.svg";
                        } elseif($media ==='Vimeo') {
                            $src="/wp-content/uploads/2025/06/Asset-4.svg";
                            $class="";
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
        </div>
        <?php
    }
			?>
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
		// Create an array of social networks and their respective sharing URLs
		$social_networks = array(
            'Facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . $url,
            'X' => 'https://twitter.com/intent/tweet?text=' . $title . '!&url=' . $url,
        );

		// Initialize the share buttons HTML
		$share_buttons = '<div class="social-media d-flex">';
		foreach ($social_networks as $network => $share_url) {
			$img = '';
			if($network === 'Facebook') {
				$img = '<img src="/wp-content/uploads/2025/06/Asset-1.svg" alt="">';
			} elseif($network === 'X') {
				$img = '<img src="/wp-content/uploads/2025/06/Asset-2.svg" alt="">';
			} 
			$share_buttons .= '<a class="social-icon" href="' . esc_url($share_url) . '" target="_blank" rel="noopener" aria-label="Share via ' . esc_attr($network) . ' (opens in a new tab)">' . $img . '</a>';
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

