<?php
/**
 * Tijus Theme functions and definitions
 *
 * @package tijus-theme
 */

if ( ! function_exists( 'tijus_theme_setup' ) ) :
	function tijus_theme_setup() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Switch default core markup for search form, comment form, and comments
		// to output valid HTML5.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add support for core custom logo.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
        
        // Elementor supports
        add_theme_support( 'elementor' );
        
        // Register menus
        register_nav_menus(
            array(
                'tijus-menu'         => esc_html__( 'Tijus Menu', 'tijus-theme' ),
                'header-right'       => esc_html__( 'Header Right Buttons', 'tijus-theme' ),
                'footer-category'    => esc_html__( 'Footer: Category', 'tijus-theme' ),
                'footer-quick-links' => esc_html__( 'Footer: Quick Links', 'tijus-theme' ),
            )
        );
	}
endif;
add_action( 'after_setup_theme', 'tijus_theme_setup' );

/**
 * Enqueue scripts and styles.
 * Note: Most theme styles are hardcoded in header.php/footer.php from the template,
 * but we enqueue the main style.css for WordPress standards and Elementor compatibility.
 */
function tijus_theme_scripts() {
	wp_enqueue_style( 'tijus-theme-style', get_stylesheet_uri(), array(), '1.0.0' );

	wp_enqueue_script( 'tijus-modernizr', get_template_directory_uri() . '/assets/js/vendor/modernizr-3.11.2.min.js', array(), '3.11.2', true );
	wp_enqueue_script( 'tijus-plugins',   get_template_directory_uri() . '/assets/js/plugins.min.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'tijus-main',      get_template_directory_uri() . '/assets/js/main.js', array( 'jquery', 'tijus-plugins' ), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'tijus_theme_scripts' );

/**
 * Filter to transfer specific classes to the anchor tag for styling the buttons
 */
function tijus_menu_link_classes( $atts, $item, $args ) {
    if ( in_array( 'sign-in', $item->classes ) ) {
        $atts['class'] = isset( $atts['class'] ) ? $atts['class'] . ' sign-in' : 'sign-in';
    }
    if ( in_array( 'sign-up', $item->classes ) ) {
        $atts['class'] = isset( $atts['class'] ) ? $atts['class'] . ' sign-up' : 'sign-up';
    }
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'tijus_menu_link_classes', 10, 3 );

// Theme Customizer settings.
require_once get_template_directory() . '/inc/theme-customizer.php';

// Theme Options admin sidebar page.
if ( is_admin() ) {
	require_once get_template_directory() . '/inc/theme-options-page.php';
}

// Elementor home page seeder (admin tool).
if ( is_admin() ) {
	require_once get_template_directory() . '/inc/elementor-home-seeder.php';
}

// About page seeder (admin tool).
if ( is_admin() ) {
	require_once get_template_directory() . '/inc/about-page-seeder.php';
}

/**
 * Helper: return social links array [{label, icon, url}, ...].
 * Falls back to legacy individual theme mods if the JSON mod isn't set yet.
 */
function tijus_get_social_links() {
	$raw = get_theme_mod( 'tijus_social_links', '' );
	if ( $raw ) {
		$links = json_decode( $raw, true );
		if ( is_array( $links ) ) {
			return $links;
		}
	}
	return [
		[ 'label' => 'Facebook',  'icon' => 'flaticon-facebook',  'url' => get_theme_mod( 'tijus_facebook_url',  '#' ) ],
		[ 'label' => 'Twitter',   'icon' => 'flaticon-twitter',   'url' => get_theme_mod( 'tijus_twitter_url',   '#' ) ],
		[ 'label' => 'Skype',     'icon' => 'flaticon-skype',     'url' => get_theme_mod( 'tijus_skype_url',     '#' ) ],
		[ 'label' => 'Instagram', 'icon' => 'flaticon-instagram', 'url' => get_theme_mod( 'tijus_instagram_url', '#' ) ],
	];
}

/**
 * Helper: return the theme logo URL (custom upload, or default theme logo).
 */
function tijus_get_logo_url() {
	$custom = get_theme_mod( 'tijus_logo', '' );
	return $custom ? esc_url( $custom ) : esc_url( get_template_directory_uri() . '/assets/images/logo.png' );
}
