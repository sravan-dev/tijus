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
	wp_add_inline_script( 'tijus-plugins', 'window.$ = window.jQuery;', 'before' );
	wp_enqueue_script( 'tijus-main',      get_template_directory_uri() . '/assets/js/main.js', array( 'jquery', 'tijus-plugins' ), '1.0.0', true );
	wp_localize_script( 'tijus-main', 'tijusAjax', [
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'tijus_courses_nonce' )
	] );
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
 * Color palettes available in Theme Options.
 */
function tijus_get_color_palettes() {
	return [
		'brand' => [
			'label'         => 'Brand',
			'primary'       => '#01A1E4',
			'primary_hover' => '#0181B6',
			'secondary'     => '#E6F5FC',
			'success'       => '#77DD77',
			'warning'       => '#F3D011',
			'danger'        => '#EE2A35',
			'dark'          => '#2E2B70',
		],
		'default' => [
			'label'         => 'Default (Blue)',
			'primary'       => '#6BB8E0',
			'primary_hover' => '#4A9AC5',
			'secondary'     => '#e0f0f8',
			'success'       => '#8DD87C',
			'warning'       => '#F2C84C',
			'danger'        => '#EF4836',
			'dark'          => '#2E3267',
		],
		'green' => [
			'label'         => 'Green',
			'primary'       => '#309255',
			'primary_hover' => '#267544',
			'secondary'     => '#e7f8ee',
			'success'       => '#198754',
			'warning'       => '#ffc107',
			'danger'        => '#dc3545',
			'dark'          => '#212832',
		],
		'purple' => [
			'label'         => 'Purple',
			'primary'       => '#7C3AED',
			'primary_hover' => '#6327C4',
			'secondary'     => '#f0e8ff',
			'success'       => '#10B981',
			'warning'       => '#F59E0B',
			'danger'        => '#EF4444',
			'dark'          => '#1E1B4B',
		],
		'orange' => [
			'label'         => 'Orange',
			'primary'       => '#EA7317',
			'primary_hover' => '#C75F0F',
			'secondary'     => '#FEF3E2',
			'success'       => '#22C55E',
			'warning'       => '#FACC15',
			'danger'        => '#E11D48',
			'dark'          => '#422006',
		],
		'red' => [
			'label'         => 'Red',
			'primary'       => '#DC2626',
			'primary_hover' => '#B91C1C',
			'secondary'     => '#FEE2E2',
			'success'       => '#16A34A',
			'warning'       => '#EAB308',
			'danger'        => '#E11D48',
			'dark'          => '#450A0A',
		],
		'teal' => [
			'label'         => 'Teal',
			'primary'       => '#0D9488',
			'primary_hover' => '#0F766E',
			'secondary'     => '#E0F7F5',
			'success'       => '#22C55E',
			'warning'       => '#F59E0B',
			'danger'        => '#EF4444',
			'dark'          => '#134E4A',
		],
	];
}

/**
 * Output CSS variable overrides for the selected color palette.
 */
function tijus_output_palette_css() {
	$palette_key = get_theme_mod( 'tijus_color_palette', 'default' );
	if ( $palette_key === 'default' ) {
		return; // Default colors are already in the stylesheet.
	}

	$palettes = tijus_get_color_palettes();
	if ( ! isset( $palettes[ $palette_key ] ) ) {
		return;
	}

	$p = $palettes[ $palette_key ];

	// Convert hex to RGB components.
	$to_rgb = function( $hex ) {
		$hex = ltrim( $hex, '#' );
		return intval( substr( $hex, 0, 2 ), 16 ) . ', '
			 . intval( substr( $hex, 2, 2 ), 16 ) . ', '
			 . intval( substr( $hex, 4, 2 ), 16 );
	};

	echo '<style id="tijus-palette-overrides">
:root {
  --bs-primary: ' . $p['primary'] . ';
  --bs-primary-rgb: ' . $to_rgb( $p['primary'] ) . ';
  --bs-secondary: ' . $p['secondary'] . ';
  --bs-secondary-rgb: ' . $to_rgb( $p['secondary'] ) . ';
  --bs-success: ' . $p['success'] . ';
  --bs-success-rgb: ' . $to_rgb( $p['success'] ) . ';
  --bs-warning: ' . $p['warning'] . ';
  --bs-warning-rgb: ' . $to_rgb( $p['warning'] ) . ';
  --bs-danger: ' . $p['danger'] . ';
  --bs-danger-rgb: ' . $to_rgb( $p['danger'] ) . ';
  --bs-dark: ' . $p['dark'] . ';
  --bs-dark-rgb: ' . $to_rgb( $p['dark'] ) . ';
  --bs-link-color: ' . $p['primary'] . ';
  --bs-link-hover-color: ' . $p['primary_hover'] . ';
}
</style>' . "\n";
}
add_action( 'wp_head', 'tijus_output_palette_css', 99 );

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

/**
 * Register Courses Custom Post Type and Taxonomy.
 */
function tijus_register_courses_cpt() {
	$labels = [
		'name'               => 'Courses',
		'singular_name'      => 'Course',
		'menu_name'          => 'Courses',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Course',
		'edit_item'          => 'Edit Course',
		'new_item'           => 'New Course',
		'view_item'          => 'View Course',
		'search_items'       => 'Search Courses',
		'not_found'          => 'No courses found',
		'not_found_in_trash' => 'No courses found in Trash',
	];

	$args = [
		'labels'              => $labels,
		'public'              => true,
		'has_archive'         => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-welcome-learn-more',
		'supports'            => [ 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ],
		'rewrite'             => [ 'slug' => 'course', 'with_front' => false ],
	];

	register_post_type( 'course', $args );

	// Register Course Category Taxonomy
	register_taxonomy( 'course_category', [ 'course' ], [
		'hierarchical'      => true,
		'labels'            => [
			'name'              => 'Course Categories',
			'singular_name'     => 'Course Category',
			'search_items'      => 'Search Categories',
			'all_items'         => 'All Categories',
			'parent_item'       => 'Parent Category',
			'parent_item_colon' => 'Parent Category:',
			'edit_item'         => 'Edit Category',
			'update_item'       => 'Update Category',
			'add_new_item'      => 'Add New Category',
			'new_item_name'     => 'New Category Name',
			'menu_name'         => 'Categories',
		],
		'show_ui'           => true,
		'show_admin_column' => true,
		'rewrite'           => [ 'slug' => 'course-category' ],
	] );
}
add_action( 'init', 'tijus_register_courses_cpt' );

/**
 * Register Meta Boxes for Courses.
 */
function tijus_add_course_meta_boxes() {
	add_meta_box(
		'tijus_course_details',
		'Course Details',
		'tijus_render_course_meta_box',
		'course',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'tijus_add_course_meta_boxes' );

function tijus_render_course_meta_box( $post ) {
	wp_nonce_field( 'tijus_save_course_data', 'tijus_course_meta_nonce' );

	$secondary_author = get_post_meta( $post->ID, '_course_secondary_author', true );
	$progress         = get_post_meta( $post->ID, '_course_progress', true );
	$duration         = get_post_meta( $post->ID, '_course_duration', true );
	$lectures         = get_post_meta( $post->ID, '_course_lectures', true );
	$regular_price    = get_post_meta( $post->ID, '_course_regular_price', true );
	$sale_price       = get_post_meta( $post->ID, '_course_sale_price', true );
	$rating           = get_post_meta( $post->ID, '_course_rating', true );
	$level            = get_post_meta( $post->ID, '_course_level', true );
	$language         = get_post_meta( $post->ID, '_course_language', true );
	$certificate      = get_post_meta( $post->ID, '_course_certificate', true );

	?>
	<table class="form-table">
		<tr>
			<th><label for="course_secondary_author">Secondary Author</label></th>
			<td><input type="text" id="course_secondary_author" name="course_secondary_author" value="<?php echo esc_attr( $secondary_author ); ?>" class="regular-text" placeholder="e.g. Ohula Malsh" /></td>
		</tr>
		<tr>
			<th><label for="course_progress">Progress % (for My Courses style)</label></th>
			<td><input type="number" id="course_progress" name="course_progress" value="<?php echo esc_attr( $progress ); ?>" class="small-text" placeholder="38" /> % Complete</td>
		</tr>
		<tr>
			<th><label for="course_duration">Course Duration</label></th>
			<td><input type="text" id="course_duration" name="course_duration" value="<?php echo esc_attr( $duration ); ?>" class="regular-text" placeholder="e.g. 08 hr 15 mins" /></td>
		</tr>
		<tr>
			<th><label for="course_lectures">Total Lectures</label></th>
			<td><input type="text" id="course_lectures" name="course_lectures" value="<?php echo esc_attr( $lectures ); ?>" class="regular-text" placeholder="e.g. 29 Lectures" /></td>
		</tr>
		<tr>
			<th><label for="course_regular_price">Regular Price ($)</label></th>
			<td><input type="text" id="course_regular_price" name="course_regular_price" value="<?php echo esc_attr( $regular_price ); ?>" class="small-text" placeholder="e.g. 440.00" /></td>
		</tr>
		<tr>
			<th><label for="course_sale_price">Sale Price ($) / 'Free'</label></th>
			<td><input type="text" id="course_sale_price" name="course_sale_price" value="<?php echo esc_attr( $sale_price ); ?>" class="small-text" placeholder="e.g. 385.00 or Free" /></td>
		</tr>
		<tr>
			<th><label for="course_rating">Rating (out of 5)</label></th>
			<td><input type="number" step="0.1" max="5" min="0" id="course_rating" name="course_rating" value="<?php echo esc_attr( $rating ); ?>" class="small-text" placeholder="4.9" /></td>
		</tr>
		<tr>
			<th><label for="course_level">Level</label></th>
			<td><input type="text" id="course_level" name="course_level" value="<?php echo esc_attr( $level ); ?>" class="regular-text" placeholder="e.g. Beginner, Secondary" /></td>
		</tr>
		<tr>
			<th><label for="course_language">Language</label></th>
			<td><input type="text" id="course_language" name="course_language" value="<?php echo esc_attr( $language ); ?>" class="regular-text" placeholder="e.g. English" /></td>
		</tr>
		<tr>
			<th><label for="course_certificate">Certificate</label></th>
			<td><input type="text" id="course_certificate" name="course_certificate" value="<?php echo esc_attr( $certificate ); ?>" class="small-text" placeholder="e.g. Yes" /></td>
		</tr>
	</table>
	<?php
}

function tijus_save_course_meta_data( $post_id ) {
	if ( ! isset( $_POST['tijus_course_meta_nonce'] ) || ! wp_verify_nonce( $_POST['tijus_course_meta_nonce'], 'tijus_save_course_data' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = [
		'course_secondary_author' => '_course_secondary_author',
		'course_progress'         => '_course_progress',
		'course_duration'         => '_course_duration',
		'course_lectures'         => '_course_lectures',
		'course_regular_price'    => '_course_regular_price',
		'course_sale_price'       => '_course_sale_price',
		'course_rating'           => '_course_rating',
		'course_level'            => '_course_level',
		'course_language'         => '_course_language',
		'course_certificate'      => '_course_certificate',
	];

	foreach ( $fields as $field => $meta_key ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}
}
add_action( 'save_post_course', 'tijus_save_course_meta_data' );

/**
 * Creates dummy courses automatically.
 */
function tijus_create_dummy_courses_once() {
	if ( ! get_option( 'tijus_dummy_courses_created_v1' ) ) {
		$dummy_courses = [
			[ 'title' => 'Data Science and Machine Learning with Python - Hands On!', 'secondary' => 'Ohula Malsh', 'progress' => '38', 'duration' => '08 hr 15 mins', 'lectures' => '29 Lectures', 'price' => '440.00', 'sale' => '385.00', 'rating' => '4.9' ],
			[ 'title' => 'Create Amazing Color Schemes for Your UX Design Projects',  'secondary' => 'Ohula Malsh', 'progress' => '80', 'duration' => '05 hr 10 mins', 'lectures' => '15 Lectures', 'price' => '',       'sale' => '420.00', 'rating' => '4.9' ],
			[ 'title' => 'Culture & Leadership: Strategies for a Successful Business', 'secondary' => 'Ohula Malsh', 'progress' => '15', 'duration' => '12 hr 30 mins', 'lectures' => '40 Lectures', 'price' => '340.00', 'sale' => '295.00', 'rating' => '4.9' ],
			[ 'title' => 'Finance Series: Learn to Budget and Calculate your Net Worth', 'secondary' => 'Ohula Malsh', 'progress' => '45', 'duration' => '03 hr 45 mins', 'lectures' => '12 Lectures', 'price' => '',     'sale' => 'Free',   'rating' => '4.9' ],
			[ 'title' => 'Build Brand Into Marketing: Tackling the New Marketing Landscape', 'secondary' => 'Ohula Malsh', 'progress' => '38', 'duration' => '09 hr 20 mins', 'lectures' => '35 Lectures', 'price' => '',   'sale' => '136.00', 'rating' => '4.9' ],
			[ 'title' => 'Graphic Design: Illustrating Badges and Icons with Geometric Shapes', 'secondary' => 'Ohula Malsh', 'progress' => '0', 'duration' => '06 hr 50 mins', 'lectures' => '22 Lectures', 'price' => '', 'sale' => '237.00', 'rating' => '4.8' ]
		];

		foreach ( $dummy_courses as $item ) {
			$post_id = wp_insert_post( [
				'post_title'   => $item['title'],
				'post_content' => 'This is a sample description for the course: ' . $item['title'],
				'post_status'  => 'publish',
				'post_type'    => 'course',
			] );

			if ( ! is_wp_error( $post_id ) ) {
				update_post_meta( $post_id, '_course_secondary_author', $item['secondary'] );
				update_post_meta( $post_id, '_course_progress', $item['progress'] );
				update_post_meta( $post_id, '_course_duration', $item['duration'] );
				update_post_meta( $post_id, '_course_lectures', $item['lectures'] );
				update_post_meta( $post_id, '_course_regular_price', $item['price'] );
				update_post_meta( $post_id, '_course_sale_price', $item['sale'] );
				update_post_meta( $post_id, '_course_rating', $item['rating'] );
			}
		}
		
		update_option( 'tijus_dummy_courses_created_v1', 1 );
	}
}
add_action( 'init', 'tijus_create_dummy_courses_once' );

/**
 * Flush rewrite rules once to fix 404 on single course pages.
 */
function tijus_flush_rules_once_fix() {
	if ( ! get_option( 'tijus_flush_rules_v1' ) ) {
		// Set permalink structure to something pretty (removes index.php dependency if possible)
		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure( '/%postname%/' );
		
		flush_rewrite_rules( false );
		update_option( 'tijus_flush_rules_v1', 1 );
	}
}
add_action( 'init', 'tijus_flush_rules_once_fix', 99 );

/**
 * AJAX handler for courses filtering.
 */
function tijus_ajax_filter_courses() {
	check_ajax_referer( 'tijus_courses_nonce', 'nonce' );

	$paged         = isset( $_POST['paged'] ) ? absint( $_POST['paged'] ) : 1;
	$current_cat   = isset( $_POST['course_category'] ) ? sanitize_text_field( wp_unslash( $_POST['course_category'] ) ) : '';
	$course_search = isset( $_POST['course_search'] ) ? sanitize_text_field( wp_unslash( $_POST['course_search'] ) ) : '';

	$args = [
		'post_type'      => 'course',
		'posts_per_page' => 12,
		'paged'          => $paged,
	];

	if ( ! empty( $current_cat ) ) {
		$args['tax_query'] = [
			[
				'taxonomy' => 'course_category',
				'field'    => 'slug',
				'terms'    => $current_cat,
			],
		];
	}

	if ( ! empty( $course_search ) ) {
		$args['s'] = $course_search;
	}

	$courses_query = new WP_Query( $args );

	ob_start();
	if ( $courses_query->have_posts() ) :
		while ( $courses_query->have_posts() ) : $courses_query->the_post();
			get_template_part( 'template-parts/content', 'course' );
		endwhile;
		wp_reset_postdata();
	else :
		echo '<div class="col-12"><p>No courses found.</p></div>';
	endif;
	$courses_html = ob_get_clean();

	ob_start();
	$total_pages = $courses_query->max_num_pages;
	if ( $total_pages > 1 ) {
		$current_page = max( 1, $paged );
		echo '<div class="col-12 mt-4 text-center pagination-area">';
		echo paginate_links( array(
			// Provide a clean format so JS can extract 'paged' easily from generated links
			'base'      => add_query_arg( 'paged', '%#%' ),
			'format'    => '',
			'current'   => $current_page,
			'total'     => $total_pages,
			'prev_text' => '<i class="icofont-rounded-left"></i>',
			'next_text' => '<i class="icofont-rounded-right"></i>',
		) );
		echo '</div>';
	}
	$pagination_html = ob_get_clean();

	wp_send_json_success( [
		'courses'    => $courses_html,
		'pagination' => $pagination_html,
	] );
}
add_action( 'wp_ajax_tijus_filter_courses', 'tijus_ajax_filter_courses' );
add_action( 'wp_ajax_nopriv_tijus_filter_courses', 'tijus_ajax_filter_courses' );

/**
 * Shortcode to display the dynamic Home Page courses tabbed section.
 */
function tijus_home_course_tabs_shortcode() {
    ob_start();
	$categories = get_terms( [
		'taxonomy'   => 'course_category',
		'hide_empty' => false,
	] );
	
	if ( empty($categories) || is_wp_error($categories) ) {
		$categories = [
			(object)['slug' => 'ui-ux-design', 'name' => 'UI/UX Design'],
			(object)['slug' => 'development', 'name' => 'Development'],
			(object)['slug' => 'data-science', 'name' => 'Data Science'],
			(object)['slug' => 'business', 'name' => 'Business'],
			(object)['slug' => 'financial', 'name' => 'Financial'],
			(object)['slug' => 'marketing', 'name' => 'Marketing'],
			(object)['slug' => 'design', 'name' => 'Design'],
		];
	}
	?>
	<!-- All Courses Tabs Menu Start -->
	<div class="courses-tabs-menu courses-active">
		<div class="swiper-container">
			<ul class="swiper-wrapper nav">
				<?php foreach ( $categories as $index => $category ) : ?>
					<li class="swiper-slide">
						<button class="<?php echo ( $index === 0 ) ? 'active' : ''; ?>" data-bs-toggle="tab" data-bs-target="#tabs-<?php echo esc_attr( $category->slug ); ?>">
							<?php echo esc_html( $category->name ); ?>
						</button>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<!-- Add Pagination -->
		<div class="swiper-button-next"><i class="icofont-rounded-right"></i></div>
		<div class="swiper-button-prev"><i class="icofont-rounded-left"></i></div>
	</div>
	<!-- All Courses Tabs Menu End -->

	<!-- All Courses tab content Start -->
	<div class="tab-content courses-tab-content">
		<?php foreach ( $categories as $index => $category ) : ?>
			<div class="tab-pane fade <?php echo ( $index === 0 ) ? 'show active' : ''; ?>" id="tabs-<?php echo esc_attr( $category->slug ); ?>">
				<div class="courses-wrapper">
					<div class="row">
						<?php
						$has_real_terms = ! empty( get_terms( [ 'taxonomy' => 'course_category', 'hide_empty' => false ] ) );
						
						$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
						
						$args = [
							'post_type'      => 'course',
							'posts_per_page' => 6,
							'paged'          => $paged,
						];
						
						if ( $has_real_terms ) {
							$args['tax_query'] = [
								[
									'taxonomy' => 'course_category',
									'field'    => 'slug',
									'terms'    => $category->slug,
								]
							];
						}

						$cat_query = new WP_Query( $args );
						
						if ( $cat_query->have_posts() ) :
							while ( $cat_query->have_posts() ) : $cat_query->the_post();
								get_template_part( 'template-parts/content', 'course' );
							endwhile;
							
							$total_pages = $cat_query->max_num_pages;
							if ( $total_pages > 1 ) {
								echo '<div class="col-12 mt-4 text-center pagination-area">';
								echo paginate_links( [
									'base'      => add_query_arg( 'paged', '%#%' ),
									'format'    => '',
									'current'   => max( 1, $paged ),
									'total'     => $total_pages,
									'prev_text' => '<i class="icofont-rounded-left"></i>',
									'next_text' => '<i class="icofont-rounded-right"></i>',
								] );
								echo '</div>';
							}
							
							wp_reset_postdata();
						else :
							echo '<div class="col-12"><p>No courses found in ' . esc_html( $category->name ) . '.</p></div>';
						endif;
						?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<!-- All Courses tab content End -->
	<?php
	return ob_get_clean();
}
add_shortcode( 'tijus_home_course_tabs', 'tijus_home_course_tabs_shortcode' );

/**
 * Run-once fix to replace Elementor static HTML with shortcode for courses.
 */
function tijus_fix_elementor_courses_once() {
    if ( ! get_option( 'tijus_elementor_courses_dynamic_fix_5' ) ) {
        $front_page_id = (int) get_option( 'page_on_front' );
        if ( $front_page_id ) {
            $elementor_data = get_post_meta( $front_page_id, '_elementor_data', true );
            
            if ( $elementor_data && is_string( $elementor_data ) ) {
                $data = json_decode( $elementor_data, true );
                if ( is_array( $data ) ) {
                    $modified = false;
                    foreach ( $data as &$section ) {
                        if ( isset($section['elements']) && is_array($section['elements']) ) {
                            foreach ( $section['elements'] as &$column ) {
                                if ( isset($column['elements']) && is_array($column['elements']) ) {
                                    foreach ( $column['elements'] as &$widget ) {
                                        if ( $widget['widgetType'] === 'html' && isset($widget['settings']['html']) ) {
                                            $html = $widget['settings']['html'];
                                            // Ensure we replace everything inside the tabbed box with the shortcode
                                            $pattern = '/\<\!\-\- All Courses Tabs Menu Start \-\-\>.*?\<\!\-\- All Courses tab content End \-\-\>/s';
                                            
                                            if ( preg_match($pattern, $html) ) {
                                                $widget['settings']['html'] = preg_replace( $pattern, '[tijus_home_course_tabs]', $html );
                                                $modified = true;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if ( $modified ) {
                        $new_json = wp_json_encode( $data );
                        update_post_meta( $front_page_id, '_elementor_data', wp_slash( $new_json ) );
                        if ( class_exists( '\Elementor\Plugin' ) ) {
                            \Elementor\Plugin::$instance->files_manager->clear_cache();
                        }
                    }
                }
            }
        }
        update_option( 'tijus_elementor_courses_dynamic_fix_5', 1 );
    }
}
add_action( 'init', 'tijus_fix_elementor_courses_once' );

/**
 * Run-once fix to update the "Other Course" button href to the actual courses page.
 */
function tijus_fix_elementor_courses_link_once() {
    if ( ! get_option( 'tijus_elementor_courses_link_fix_1' ) ) {
        $front_page_id = (int) get_option( 'page_on_front' );
        if ( $front_page_id ) {
            $elementor_data = get_post_meta( $front_page_id, '_elementor_data', true );
            
            if ( $elementor_data && is_string( $elementor_data ) ) {
                if ( strpos($elementor_data, 'href="courses.html"') !== false || strpos($elementor_data, 'href=\"courses.html\"') !== false ) {
                    // Update all statically linked instances of courses.html to point to /courses/
                    // Note: elementor data is json, so double quotes are escaped as \" 
                    $new_data = str_replace( 'href=\"courses.html\"', 'href=\"/courses/\"', $elementor_data );
                    $new_data = str_replace( 'href="courses.html"', 'href="/courses/"', $new_data );
                    
                    update_post_meta( $front_page_id, '_elementor_data', wp_slash( $new_data ) );
                    
                    if ( class_exists( '\Elementor\Plugin' ) ) {
                        \Elementor\Plugin::$instance->files_manager->clear_cache();
                    }
                }
            }
        }
        update_option( 'tijus_elementor_courses_link_fix_1', 1 );
    }
}
add_action( 'init', 'tijus_fix_elementor_courses_link_once' );

/**
 * Display a single course comment (review)
 */
function tijus_course_comment_callback( $comment, $args, $depth ) {
	$rating = get_comment_meta( $comment->comment_ID, 'course_rating', true );
	if ( ! $rating ) $rating = 5; // Default fallback to 5

	?>
	<li <?php comment_class( 'comment' ); ?> id="li-comment-<?php comment_ID(); ?>">
		<div class="comment-avatar">
			<?php echo get_avatar( $comment, 60 ); ?>
		</div>
		<div class="comment-body w-100">
			<div class="d-flex justify-content-between align-items-start">
				<div>
					<div class="comment-author"><?php echo get_comment_author(); ?></div>
					<div class="comment-date"><?php printf( '%1$s at %2$s', get_comment_date(), get_comment_time() ); ?></div>
				</div>
				<div class="comment-rating mt-1">
					<?php for ( $i = 1; $i <= 5; $i++ ) {
						echo '<i class="icofont-star ' . ( $i <= $rating ? '' : 'empty' ) . '"></i> ';
					} ?>
				</div>
			</div>
			<div class="comment-content">
				<?php comment_text(); ?>
			</div>
		</div>
	</li>
	<?php
}

/**
 * Save rating meta and update overall course rating.
 */
function tijus_save_course_comment_rating( $comment_id, $comment_approved, $commentdata ) {
	if ( isset( $_POST['course_rating'] ) && $commentdata['comment_post_ID'] ) {
		$rating = absint( $_POST['course_rating'] );
		if ( $rating > 0 && $rating <= 5 ) {
			add_comment_meta( $comment_id, 'course_rating', $rating );

			// Recalculate average rating for the course
			$post_id = $commentdata['comment_post_ID'];
			$comments = get_comments( [
				'post_id' => $post_id,
				'status'  => 'approve'
			] );

			if ( ! empty( $comments ) ) {
				$total = 0;
				$count = 0;
				foreach ( $comments as $c ) {
					$r = get_comment_meta( $c->comment_ID, 'course_rating', true );
					if ( $r ) {
						$total += intval( $r );
						$count++;
					}
				}
				if ( $count > 0 ) {
					$avg = round( $total / $count, 1 );
					update_post_meta( $post_id, '_course_rating', $avg );
				}
			}
		}
	}
}
add_action( 'comment_post', 'tijus_save_course_comment_rating', 10, 3 );

/**
 * Run-once fix to open comments for all existing courses.
 */
function tijus_open_existing_course_comments_once() {
    if ( ! get_option( 'tijus_course_comments_opened_1' ) ) {
        global $wpdb;
        $wpdb->query( "UPDATE {$wpdb->posts} SET comment_status = 'open' WHERE post_type = 'course'" );
        update_option( 'tijus_course_comments_opened_1', 1 );
    }
}
add_action( 'init', 'tijus_open_existing_course_comments_once' );

/**
 * Auto-detect and fix hardcoded database URLs on the fly for staging and local sync natively.
 * Compares the raw DB site URL with current auto-detected WP_SITEURL.
 */
add_action( 'template_redirect', 'tijus_dynamic_url_replacement', -9999 );
function tijus_dynamic_url_replacement() {
    if ( ! is_admin() ) {
        ob_start( 'tijus_replace_hardcoded_urls' );
    }
}

function tijus_replace_hardcoded_urls( $html ) {
    global $wpdb;
    static $original_url = null;
    $current_url = home_url();

    if ( $original_url === null ) {
        $original_url = $wpdb->get_var( "SELECT option_value FROM $wpdb->options WHERE option_name = 'siteurl'" );
    }

    if ( $original_url && $original_url !== $current_url ) {
        $html = str_replace( $original_url, $current_url, $html );
        $html = str_replace( str_replace('/', '\/', $original_url), str_replace('/', '\/', $current_url), $html );
    }
    return $html;
}

/**
 * Flush Elementor CSS cache automatically if environment URL changes.
 */
add_action( 'init', 'tijus_auto_flush_elementor_css' );
function tijus_auto_flush_elementor_css() {
    global $wpdb;
    
    // Avoid running this on every single page load if possible, but safe since it only checks transient
    $original_url = $wpdb->get_var( "SELECT option_value FROM $wpdb->options WHERE option_name = 'siteurl'" );
    if ( $original_url && $original_url !== home_url() ) {
		if ( ! get_transient( 'tijus_elementor_cache_cleared_' . md5( home_url() ) ) ) {
			if ( class_exists( '\Elementor\Plugin' ) ) {
				\Elementor\Plugin::$instance->files_manager->clear_cache();
			}
			set_transient( 'tijus_elementor_cache_cleared_' . md5( home_url() ), true, DAY_IN_SECONDS );
		}
    }
}
