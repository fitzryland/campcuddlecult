<?php
/**
 * campcuddlecult functions and definitions
 *
 * @package campcuddlecult
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'campcuddlecult_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function campcuddlecult_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on campcuddlecult, use a find and replace
	 * to change 'campcuddlecult' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'campcuddlecult', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'campcuddlecult' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'campcuddlecult_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // campcuddlecult_setup
add_action( 'after_setup_theme', 'campcuddlecult_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function campcuddlecult_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'campcuddlecult' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'campcuddlecult_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function campcuddlecult_scripts() {
	wp_enqueue_style( 'campcuddlecult-style', get_stylesheet_uri() );

	wp_enqueue_script( 'campcuddlecult-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'campcuddlecult-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'campcuddlecult_scripts' );

function load_fonts() {
	wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Raleway:100,400');
	wp_enqueue_style( 'googleFonts');
}

add_action('wp_print_styles', 'load_fonts');


// add PayPal shortcode
function paypal_shortcode_function( $atts ) {
	$html = '<div class="donation-form-wrap">';
	if (isset($atts['description']) && $atts['description'] != "") {
		$html .= '<div class="donation-form-description">' . $atts['description'] . '</div>';
	}
	$html .= '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_donations">
				<label for="amount">$</label>
				<input TYPE="text" name="amount" value="" size="5">
				<input TYPE="submit" name="submit" value="Donate">
				<input TYPE="hidden" name="business" value="cuddlecult2014@gmail.com">
				<input TYPE="hidden" name="item_name" value="Donation to Camp Cuddle Cult!">
				<input TYPE="hidden" name="return" value="http://www.campcuddlecult.com/thank-you/">
				<input TYPE="hidden" name="cancel_return" value="http://www.campcuddlecult.com/donation-canceled/">
				<img alt="" border="0" width="1" height="1" src="https://www.paypal.com/en_US/i/scr/pixel.gif" >
			</form>
		</div><!--.donation-form-wrap-->';
	return $html;
}
add_shortcode('donate', 'paypal_shortcode_function');


/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
