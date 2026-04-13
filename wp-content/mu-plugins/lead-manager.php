<?php
/**
 * Plugin Name: Tijus Lead Manager
 * Description: Captures course enrollments, registers users, and manages them in a dedicated Customers tab.
 * Author: Antigravity
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Customers admin menu.
 */
function tijus_add_customers_admin_menu() {
    add_menu_page(
        'Customers',
        'Customers',
        'manage_options',
        'tijus-customers',
        'tijus_render_customers_page',
        'dashicons-groups',
        26
    );
}
add_action( 'admin_menu', 'tijus_add_customers_admin_menu' );

/**
 * Render the Customers page.
 */
function tijus_render_customers_page() {
    // Get all users with subscriber role
    $args = [
        'role'    => 'subscriber',
        'orderby' => 'registered',
        'order'   => 'DESC'
    ];
    $user_query = new WP_User_Query( $args );
    $users = $user_query->get_results();
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Customers</h1>
        <p>List of users registered via the Course Enrollment form.</p>
        
        <table class="wp-list-table widefat fixed striped table-view-list users mt-3">
            <thead>
                <tr>
                    <th class="manage-column column-name">Name</th>
                    <th class="manage-column column-email">Email</th>
                    <th class="manage-column">Phone</th>
                    <th class="manage-column">WhatsApp</th>
                    <th class="manage-column">Course Mode</th>
                    <th class="manage-column">Enrolled Course(s)</th>
                    <th class="manage-column">Location</th>
                    <th class="manage-column">Registered</th>
                </tr>
            </thead>
            <tbody>
                <?php if ( ! empty( $users ) ) : ?>
                    <?php foreach ( $users as $user ) : 
                        $phone = get_user_meta($user->ID, 'tijus_phone', true);
                        $whatsapp = get_user_meta($user->ID, 'tijus_whatsapp', true);
                        $mode = get_user_meta($user->ID, 'tijus_course_mode', true);
                        $country = get_user_meta($user->ID, 'tijus_country', true);
                        $city = get_user_meta($user->ID, 'tijus_city', true);
                        $enrolled = get_user_meta($user->ID, '_enrolled_courses', true);
                        
                        $courses_list = '-';
                        if ( is_array($enrolled) && ! empty($enrolled) ) {
                            $titles = array_map(function($cid) {
                                return get_the_title($cid);
                            }, $enrolled);
                            $courses_list = implode('<br>', $titles);
                        }
                        
                        $location = array_filter([$city, $country]);
                        $location_str = empty($location) ? '-' : implode(', ', $location);
                    ?>
                    <tr>
                        <td class="name column-name">
                            <strong><?php echo esc_html( $user->first_name . ' ' . $user->last_name ); ?></strong>
                        </td>
                        <td class="email column-email">
                            <a href="mailto:<?php echo esc_attr( $user->user_email ); ?>"><?php echo esc_html( $user->user_email ); ?></a>
                        </td>
                        <td><?php echo esc_html( $phone ?: '-' ); ?></td>
                        <td><?php echo esc_html( $whatsapp ?: '-' ); ?></td>
                        <td><?php echo esc_html( $mode ?: '-' ); ?></td>
                        <td><?php echo wp_kses_post( $courses_list ); ?></td>
                        <td><?php echo esc_html( $location_str ); ?></td>
                        <td><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $user->user_registered ) ) ); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr class="no-items">
                        <td class="colspanchange" colspan="8">No customers found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}

/**
 * Handle Enrollment Form AJAX Submission.
 */
function tijus_ajax_enroll_user() {
    // Check nonce
    if ( ! isset( $_POST['enroll_nonce'] ) || ! wp_verify_nonce( $_POST['enroll_nonce'], 'tijus_enroll_action' ) ) {
        wp_send_json_error( 'Invalid security token.' );
    }

    $first_name = sanitize_text_field( $_POST['first_name'] ?? '' );
    $last_name  = sanitize_text_field( $_POST['last_name'] ?? '' );
    $email      = sanitize_email( $_POST['email'] ?? '' );
    $password   = $_POST['password'] ?? '';
    $phone      = sanitize_text_field( $_POST['phone'] ?? '' );
    $whatsapp   = sanitize_text_field( $_POST['whatsapp'] ?? '' );
    $mode       = sanitize_text_field( $_POST['course_mode'] ?? '' );
    $course_id  = absint( $_POST['course_id'] ?? 0 );
    $country    = sanitize_text_field( $_POST['country'] ?? '' );
    $city       = sanitize_text_field( $_POST['city'] ?? '' );

    if ( empty( $email ) || empty( $password ) || empty( $first_name ) || empty( $phone ) || empty( $course_id ) ) {
        wp_send_json_error( 'Please fill in all required fields.' );
    }

    if ( username_exists( $email ) || email_exists( $email ) ) {
        wp_send_json_error( 'An account with this email address already exists. Please log in first, or use a different email.' );
    }

    // Create the user
    $user_id = wp_create_user( $email, $password, $email );

    if ( is_wp_error( $user_id ) ) {
        wp_send_json_error( $user_id->get_error_message() );
    }

    // Set role
    $user = new WP_User( $user_id );
    $user->set_role( 'subscriber' );

    // Save standard meta
    wp_update_user([
        'ID'         => $user_id,
        'first_name' => $first_name,
        'last_name'  => $last_name,
    ]);

    // Save custom meta
    update_user_meta( $user_id, 'tijus_phone', $phone );
    update_user_meta( $user_id, 'tijus_whatsapp', $whatsapp );
    update_user_meta( $user_id, 'tijus_course_mode', $mode );
    update_user_meta( $user_id, 'tijus_country', $country );
    update_user_meta( $user_id, 'tijus_city', $city );

    // Map course to user
    $enrolled_courses = get_user_meta( $user_id, '_enrolled_courses', true );
    if ( ! is_array( $enrolled_courses ) ) {
        $enrolled_courses = [];
    }
    if ( ! in_array( $course_id, $enrolled_courses ) ) {
        $enrolled_courses[] = $course_id;
        update_user_meta( $user_id, '_enrolled_courses', $enrolled_courses );
    }

    // Map user to course
    $course_users = get_post_meta( $course_id, '_enrolled_users', true );
    if ( ! is_array( $course_users ) ) {
        $course_users = [];
    }
    if ( ! in_array( $user_id, $course_users ) ) {
        $course_users[] = $user_id;
        update_post_meta( $course_id, '_enrolled_users', $course_users );
    }
    
    // Auto login securely
    wp_set_current_user( $user_id );
    wp_set_auth_cookie( $user_id );
    do_action( 'wp_login', $email, $user );

    wp_send_json_success( 'Successfully enrolled and registered! Redirecting to course...' );
}
add_action( 'wp_ajax_tijus_enroll_user', 'tijus_ajax_enroll_user' );
add_action( 'wp_ajax_nopriv_tijus_enroll_user', 'tijus_ajax_enroll_user' );

/**
 * Handle dynamic AJAX check for existing emails.
 */
function tijus_check_email_exists_ajax() {
    $email = sanitize_email( $_POST['email'] ?? '' );
    if ( empty( $email ) ) {
        wp_send_json_error();
    }
    
    if ( email_exists( $email ) ) {
        wp_send_json_success( ['exists' => true] );
    } else {
        wp_send_json_success( ['exists' => false] );
    }
}
add_action( 'wp_ajax_tijus_check_email_exists', 'tijus_check_email_exists_ajax' );
add_action( 'wp_ajax_nopriv_tijus_check_email_exists', 'tijus_check_email_exists_ajax' );

/**
 * Intercept auto-enrollment payloads natively post-login.
 */
function tijus_auto_enroll_intercept() {
    if ( is_user_logged_in() && isset( $_GET['auto_enroll_course'] ) ) {
        
        $user_id = get_current_user_id();
        $course_id = absint( $_GET['auto_enroll_course'] );
        
        if ( get_post_type( $course_id ) === 'course' ) {
            // Map course to user
            $enrolled_courses = get_user_meta( $user_id, '_enrolled_courses', true );
            if ( ! is_array( $enrolled_courses ) ) {
                $enrolled_courses = [];
            }
            if ( ! in_array( $course_id, $enrolled_courses ) ) {
                $enrolled_courses[] = $course_id;
                update_user_meta( $user_id, '_enrolled_courses', $enrolled_courses );
            }

            // Map user to course
            $course_users = get_post_meta( $course_id, '_enrolled_users', true );
            if ( ! is_array( $course_users ) ) {
                $course_users = [];
            }
            if ( ! in_array( $user_id, $course_users ) ) {
                $course_users[] = $user_id;
                update_post_meta( $course_id, '_enrolled_users', $course_users );
            }
        }
        
        // Strip the GET parameter securely by doing a clean redirect.
        wp_redirect( remove_query_arg( 'auto_enroll_course' ) );
        exit;
    }
}
add_action( 'template_redirect', 'tijus_auto_enroll_intercept' );
add_action( 'admin_init', 'tijus_auto_enroll_intercept' ); // Catch it if they land in WP Admin Dashboard

