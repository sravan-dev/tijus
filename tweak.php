<?php
/**
 * Plugin Name: Dashboard Tweaks
 * Description: Hides all dashboard widgets and the Welcome Panel.
 */

/**
 * Hides all widgets from the WordPress Dashboard.
 */
function custom_hide_all_dashboard_widgets() {
	global $wp_meta_boxes;
	$screen = get_current_screen();

	// Unset all widgets for the current dashboard screen.
	if ( isset( $screen->id ) ) {
		unset( $wp_meta_boxes[ $screen->id ] );
	}
}

// Hook into all dashboard variations at a very late priority (999).
add_action( 'wp_dashboard_setup',         'custom_hide_all_dashboard_widgets', 999 );
add_action( 'wp_network_dashboard_setup', 'custom_hide_all_dashboard_widgets', 999 );
add_action( 'wp_user_dashboard_setup',    'custom_hide_all_dashboard_widgets', 999 );

// Remove the Welcome Panel.
remove_action( 'welcome_panel', 'wp_welcome_panel' );

/**
 * Refines the Dashboard UI by hiding empty containers and Screen Options.
 */
function custom_dashboard_ui_refinements() {
	$screen = get_current_screen();
	if ( ! $screen || 'dashboard' !== $screen->id ) {
		return;
	}
	?>
	<style>
		/* Hide the empty dashboard widgets wrapper */
		#dashboard-widgets-wrap {
			display: none !important;
		}
		/* Hide the Screen Options and Help tabs since the dashboard is empty */
		#screen-options-link-wrap,
		#contextual-help-link-wrap {
			display: none !important;
		}
		/* Clean up the top admin bar (Header Top) and hide the WP Logo */
		#wpadminbar #wp-admin-bar-wp-logo {
			display: none !important;
		}
		/* Fix the Dashboard Title alignment and margins */
		.wrap h1 {
			margin-top: 20px !important;
			margin-bottom: 20px !important;
		}
	</style>
	<?php
}
add_action( 'admin_head', 'custom_dashboard_ui_refinements' );