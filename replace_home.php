<?php
$file = 'wp-content/themes/tijus-theme/template-parts/static-home.php';
$content = file_get_contents($file);

$start_marker = '                <!-- All Courses Tabs Menu Start -->';
$end_marker = '                <!-- All Courses tab content End -->';

$start_pos = strpos($content, $start_marker);
$end_pos = strpos($content, $end_marker) + strlen($end_marker);

if ($start_pos !== false && $end_pos !== false) {
    $before = substr($content, 0, $start_pos);
    $after = substr($content, $end_pos);

    $replacement = '                <!-- All Courses Tabs Menu Start -->
                <?php
                $categories = get_terms( [
                    \'taxonomy\'   => \'course_category\',
                    \'hide_empty\' => false,
                ] );
                // Fallback to dummy names
                if ( empty($categories) || is_wp_error($categories) ) {
                    $categories = [
                        (object)[\'slug\' => \'ui-ux-design\', \'name\' => \'UI/UX Design\'],
                        (object)[\'slug\' => \'development\', \'name\' => \'Development\'],
                        (object)[\'slug\' => \'data-science\', \'name\' => \'Data Science\'],
                        (object)[\'slug\' => \'business\', \'name\' => \'Business\'],
                        (object)[\'slug\' => \'financial\', \'name\' => \'Financial\'],
                        (object)[\'slug\' => \'marketing\', \'name\' => \'Marketing\'],
                        (object)[\'slug\' => \'design\', \'name\' => \'Design\'],
                    ];
                }
                ?>
                <div class="courses-tabs-menu courses-active">
                    <div class="swiper-container">
                        <ul class="swiper-wrapper nav">
                            <?php foreach ( $categories as $index => $category ) : ?>
                                <li class="swiper-slide">
                                    <button class="<?php echo ( $index === 0 ) ? \'active\' : \'\'; ?>" data-bs-toggle="tab" data-bs-target="#tabs-<?php echo esc_attr( $category->slug ); ?>">
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
                        <div class="tab-pane fade <?php echo ( $index === 0 ) ? \'show active\' : \'\'; ?>" id="tabs-<?php echo esc_attr( $category->slug ); ?>">
                            
                            <!-- All Courses Wrapper Start -->
                            <div class="courses-wrapper">
                                <div class="row">
                                    <?php
                                    // Allow dummy categories to display all courses as demo, otherwise strictly filter by term if terms exist
                                    $has_real_terms = ! empty( get_terms( [ \'taxonomy\' => \'course_category\', \'hide_empty\' => false ] ) );
                                    
                                    $args = [
                                        \'post_type\'      => \'course\',
                                        \'posts_per_page\' => 6,
                                    ];
                                    
                                    if ( $has_real_terms ) {
                                        $args[\'tax_query\'] = [
                                            [
                                                \'taxonomy\' => \'course_category\',
                                                \'field\'    => \'slug\',
                                                \'terms\'    => $category->slug,
                                            ]
                                        ];
                                    }

                                    $cat_query = new WP_Query( $args );
                                    
                                    if ( $cat_query->have_posts() ) :
                                        while ( $cat_query->have_posts() ) : $cat_query->the_post();
                                            get_template_part( \'template-parts/content\', \'course\' );
                                        endwhile;
                                        wp_reset_postdata();
                                    else :
                                        echo \'<div class="col-12"><p>No courses found in \' . esc_html( $category->name ) . \'.</p></div>\';
                                    endif;
                                    ?>
                                </div>
                            </div>
                            <!-- All Courses Wrapper End -->
                            
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- All Courses tab content End -->';

    file_put_contents($file, $before . $replacement . $after);
    echo "Replaced successfully.\\n";
} else {
    echo "Markers not found.\\n";
}
?>
