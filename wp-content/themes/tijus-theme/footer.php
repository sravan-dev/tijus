        <!-- Footer Start  -->
        <div class="section footer-section">

            <!-- Footer Widget Section Start -->
            <div class="footer-widget-section">

                <img class="shape-1 animation-down" src="<?php echo get_template_directory_uri(); ?>/assets/images/shape/shape-21.png" alt="Shape">

                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 order-md-1 order-lg-1">

                            <!-- Footer Widget Start -->
                            <?php
                            $f_phone    = get_theme_mod( 'tijus_phone', '(970) 262-1413' );
                            $f_email    = get_theme_mod( 'tijus_email', 'address@gmail.com' );
                            $f_phone_r  = preg_replace( '/[^0-9+]/', '', $f_phone );
                            $f_addr1    = get_theme_mod( 'tijus_footer_address_title', 'Caribbean Ct' );
                            $f_addr2    = get_theme_mod( 'tijus_footer_address_city',  'Haymarket, Virginia (VA).' );
                            ?>
                            <div class="footer-widget">
                                <div class="widget-logo">
                                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo tijus_get_logo_url(); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"></a>
                                </div>

                                <div class="widget-address">
                                    <h4 class="footer-widget-title"><?php echo esc_html( $f_addr1 ); ?></h4>
                                    <p><?php echo esc_html( $f_addr2 ); ?></p>
                                </div>

                                <ul class="widget-info">
                                    <li>
                                        <p> <i class="flaticon-email"></i> <a href="mailto:<?php echo esc_attr( $f_email ); ?>"><?php echo esc_html( $f_email ); ?></a> </p>
                                    </li>
                                    <li>
                                        <p> <i class="flaticon-phone-call"></i> <a href="tel:<?php echo esc_attr( $f_phone_r ); ?>"><?php echo esc_html( $f_phone ); ?></a> </p>
                                    </li>
                                </ul>

                                <ul class="widget-social">
                                    <?php foreach ( tijus_get_social_links() as $_sl ) : ?>
                                    <li><a href="<?php echo esc_url( $_sl['url'] ); ?>"><i class="<?php echo esc_attr( $_sl['icon'] ); ?>"></i></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <!-- Footer Widget End -->

                        </div>
                        <div class="col-lg-6 order-md-3 order-lg-2">

                            <!-- Footer Widget Link Start -->
                            <div class="footer-widget-link">

                                <!-- Footer Widget Start -->
                                <div class="footer-widget">
                                    <h4 class="footer-widget-title">Category</h4>
                                    <?php
                                    if ( has_nav_menu( 'footer-category' ) ) {
                                        wp_nav_menu( array(
                                            'theme_location' => 'footer-category',
                                            'menu_class'     => 'widget-link',
                                            'container'      => false,
                                            'depth'          => 1,
                                            'fallback_cb'    => false,
                                        ) );
                                    } else {
                                        ?>
                                        <ul class="widget-link">
                                            <li><a href="#">Creative Writing</a></li>
                                            <li><a href="#">Film &amp; Video</a></li>
                                            <li><a href="#">Graphic Design</a></li>
                                            <li><a href="#">UI/UX Design</a></li>
                                            <li><a href="#">Business Analytics</a></li>
                                            <li><a href="#">Marketing</a></li>
                                        </ul>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <!-- Footer Widget End -->

                                <!-- Footer Widget Start -->
                                <div class="footer-widget">
                                    <h4 class="footer-widget-title">Quick Links</h4>
                                    <?php
                                    if ( has_nav_menu( 'footer-quick-links' ) ) {
                                        wp_nav_menu( array(
                                            'theme_location' => 'footer-quick-links',
                                            'menu_class'     => 'widget-link',
                                            'container'      => false,
                                            'depth'          => 1,
                                            'fallback_cb'    => false,
                                        ) );
                                    } else {
                                        ?>
                                        <ul class="widget-link">
                                            <li><a href="#">Privacy Policy</a></li>
                                            <li><a href="#">Discussion</a></li>
                                            <li><a href="#">Terms &amp; Conditions</a></li>
                                            <li><a href="#">Customer Support</a></li>
                                            <li><a href="#">Course FAQ's</a></li>
                                        </ul>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <!-- Footer Widget End -->

                            </div>
                            <!-- Footer Widget Link End -->

                        </div>
                        <div class="col-lg-3 col-md-6 order-md-2 order-lg-3">

                            <!-- Footer Widget Start -->
                            <div class="footer-widget">
                                <h4 class="footer-widget-title">Subscribe</h4>

                                <div class="widget-subscribe">
                                    <p>Lorem Ipsum has been them an industry printer took a galley make book.</p>

                                    <div class="widget-form">
                                        <form action="#">
                                            <input type="text" placeholder="Email here">
                                            <button class="btn btn-primary btn-hover-dark">Subscribe Now</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Footer Widget End -->

                        </div>
                    </div>
                </div>

                <img class="shape-2 animation-left" src="<?php echo get_template_directory_uri(); ?>/assets/images/shape/shape-22.png" alt="Shape">

            </div>
            <!-- Footer Widget Section End -->

            <!-- Footer Copyright Start -->
            <div class="footer-copyright">
                <div class="container">

                    <!-- Footer Copyright Start -->
                    <div class="copyright-wrapper">
                        <div class="copyright-link">
                            <a href="#">Terms of Service</a>
                            <a href="#">Privacy Policy</a>
                            <a href="#">Sitemap</a>
                            <a href="#">Security</a>
                        </div>
                        <div class="copyright-text">
                            <p>&copy; <?php echo wp_kses_post( get_theme_mod( 'tijus_copyright_text', '2021 <span>Edule</span> Made with &#10084; by <a href="#">Codecarnival</a>' ) ); ?></p>
                        </div>
                    </div>
                    <!-- Footer Copyright End -->

                </div>
            </div>
            <!-- Footer Copyright End -->

        </div>
        <!-- Footer End -->

        <!--Back To Start-->
        <a href="#" class="back-to-top">
            <i class="icofont-simple-up"></i>
        </a>
        <!--Back To End-->

    </div>






<?php wp_footer(); ?>
</body>

</html>