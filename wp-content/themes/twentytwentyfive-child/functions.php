<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array(  ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'chld_thm_cfg_parent' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

// END ENQUEUE PARENT ACTION

function tt5_child_all_assets() {

    /* =====================
     * CSS FILES
     * ===================== */

    wp_enqueue_style(
        'bootstrap-css',
        get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css',
        array(),
        '4.6.2'
    );

    wp_enqueue_style(
        'owl-carousel-css',
        get_stylesheet_directory_uri() . '/assets/css/owl.carousel.min.css',
        array(),
        '2.3.4'
    );

    wp_enqueue_style(
        'owl-theme-default',
        get_stylesheet_directory_uri() . '/assets/css/owl.theme.default.min.css',
        array('owl-carousel-css'),
        '2.3.4'
    );

    wp_enqueue_style(
        'style-css',
        get_stylesheet_directory_uri() . '/assets/css/style.css',
        array('bootstrap-css', 'owl-theme-default'),
        '1.0.0'
    );

    wp_enqueue_style(
        'responsive-css',
        get_stylesheet_directory_uri() . '/assets/css/responsive.css',
        array('style-css'),
        '1.0.0'
    );


    /* =====================
     * JS FILES
     * ===================== */

    // WordPress built-in jQuery
    wp_enqueue_script('jquery');

    wp_enqueue_script(
        'owl-carousel-js',
        get_stylesheet_directory_uri() . '/assets/js/owl.carousel.min.js',
        array('jquery'),
        '2.3.4',
        true
    );

    wp_enqueue_script(
        'bootstrap-bundle-js',
        get_stylesheet_directory_uri() . '/assets/js/bootstrap.bundle.min.js',
        array('jquery'),
        '4.6.2',
        true
    );

    wp_enqueue_script(
        'main-scripts-js',
        get_stylesheet_directory_uri() . '/assets/js/scripts.js',
        array('jquery', 'owl-carousel-js', 'bootstrap-bundle-js'),
        '1.0.0',
        true
    );
}

add_action('wp_enqueue_scripts', 'tt5_child_all_assets');



function tt5_add_google_fonts() {
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Alkatra:wght@400..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Jost:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Tenor+Sans&display=swap',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'tt5_add_google_fonts');


// 
add_filter( 'render_block', 'customize_cat_list_html_classes', 10, 2 );

function customize_cat_list_html_classes( $block_content, $block ) {
    // Sirf us block ko target karega jisme aapne "new-arrival-cat" class di hai
    if ( isset( $block['attrs']['className'] ) && strpos( $block['attrs']['className'], 'new-arrival-cat' ) !== false ) {
        
        // 1. <ul> tag ko target karke usme "owl-stage" class add karna
        // Hum purane class attribute ko replace kar rahe hain ya naya add kar rahe hain
        $block_content = str_replace( '<ul ', '<ul class="owl-stage" ', $block_content );

        // 2. Har <li> tag ko target karke usme "owl-item" class add karna
        $block_content = str_replace( '<li ', '<li class="owl-item" ', $block_content );
    }

    return $block_content;
}


add_action('wp_footer', 'giftara_arrivals_custom_script');
function giftara_arrivals_custom_script() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        
        // Console mein check karne ke liye (Browser F12 console mein dikhega)
        console.log('Giftara Script Loaded');

        $('.owl_giftara_arrivals').owlCarousel({
            // onInitialized tab trigger hota hai jab carousel successfully ban jata hai
        
            loop: true,
            nav: false,
            dots: false,
            margin: 15,
            autoplay: false,
            autoplayTimeout: 5000,
            responsiveClass: true,
            smartSpeed: 4000,
            responsive: {
                0: {
                    items: 2,
                    nav: false,
                },
                400: {
                    items: 2,
                    nav: false
                },
                600: {
                    items: 3,
                    nav: false,
                    margin: 5,
                },
                1000: {
                    items: 3,
                    nav: false
                },
                1200: {
                    items: 4,
                    nav: false,
                }
            }
        });
    });
    </script>
    <?php
}


