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
        'font-awesome-all', 
        get_stylesheet_directory_uri() . '/assets/css/all.min.css', 
        array(), 
        '5.0.0' 
    );

    wp_enqueue_style(
        'style-css',
        get_stylesheet_directory_uri() . '/assets/css/style.css',
        array('bootstrap-css', 'owl-theme-default'),
        '1.0.0'
    );

    // wp_enqueue_style(
    //     'responsive-css',
    //     get_stylesheet_directory_uri() . '/assets/css/responsive.css',
    //     array('style-css'),
    //     '1.0.0'
    // );


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


add_filter( 'render_block', 'add_owl_classes_to_category_carousel', 10, 2 );

function add_owl_classes_to_category_carousel( $block_content, $block ) {
    
    // 1. Check karein ki kya "category-sec-crausal" class block attributes mein hai
    if ( isset( $block['attrs']['className'] ) && strpos( $block['attrs']['className'], 'category-sec-crausal' ) !== false ) {
        
        // --- <ul> TAG HANDLING ---
        // Check karein agar <ul> mein pehle se koi class hai
        if ( strpos( $block_content, '<ul class="' ) !== false ) {
            // Agar class hai, toh "owl-stage" ko existing classes ke saath append karein
            $block_content = str_replace( '<ul class="', '<ul class="owl-stage ', $block_content );
        } else {
            // Agar class nahi hai, toh nayi class attribute banayein
            $block_content = str_replace( '<ul', '<ul class="owl-stage"', $block_content );
        }

        // --- <li> TAG HANDLING ---
        // Check karein agar <li> mein pehle se koi class hai
        if ( strpos( $block_content, '<li class="' ) !== false ) {
            // Agar class hai, toh "owl-item" ko existing classes ke saath append karein
            $block_content = str_replace( '<li class="', '<li class="owl-item ', $block_content );
        } else {
            // Agar class nahi hai, toh nayi class attribute banayein
            $block_content = str_replace( '<li', '<li class="owl-item"', $block_content );
        }
    }

    return $block_content;
}

add_action('wp_footer', 'category_sec_carousel_custom_script');

function category_sec_carousel_custom_script() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        
        // Console check karne ke liye
        console.log('Category Carousel Script Loaded');

        $('.owl_category').owlCarousel({
            loop: true,
            nav: false,
            dots: false,
            margin: 20,
            autoplay: false,
            autoplayTimeout: 5000,
            responsiveClass: true,
            smartSpeed: 3000,
            responsive: {
                0: {
                    items: 2,
                    nav: false,
                },
                400: {
                    items: 2,
                    nav: false
                },
                480: {
                    items: 3,
                    nav: false,
                    margin: 8,
                },
                576: {
                    items: 3,
                    nav: false
                },
                800: {
                    items: 4,
                    nav: false
                },
                1200: {
                    items: 5,
                    nav: false,
                }
            }
        });
    });
    </script>
    <?php
}

function remove_wp_block_library_css() {
    // 1. Core block library styles hatane ke liye
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    
    // 2. Woocommerce styles (agar install hai toh)
    wp_dequeue_style( 'wc-blocks-style' );
    
    // 3. Global styles (theme.json se aane wali inline CSS)
    wp_dequeue_style( 'global-styles' );
    
    // 4. Classic theme styles (jo block themes me bhi kabhi kabhi load hoti hain)
    wp_dequeue_style( 'classic-theme-styles' );
}
add_action( 'wp_enqueue_scripts', 'remove_wp_block_library_css', 100 );



add_action('wp_footer', 'giftara_timeline_scroll_script');

function giftara_timeline_scroll_script() {
    ?>
    <script type="text/javascript">
    (function() {
        function onScrollAnimate() {
            // ID ki jagah class use karne ke liye querySelector use kiya hai
            const timeline = document.querySelector('.timeline');
            
            // Safety check: agar page par timeline class nahi hai toh error na aaye
            if (!timeline) return;

            const steps = timeline.querySelectorAll('.step');
            const rect = timeline.getBoundingClientRect();

            if (rect.top < window.innerHeight - 100) {
                timeline.classList.add('animate-line');
                steps.forEach((step, index) => {
                    // Har step ko timing ke sath visible class dega
                    setTimeout(() => step.classList.add('visible'), index * 1200);
                });
                // Ek baar animate hone ke baad scroll event hata dega
                window.removeEventListener('scroll', onScrollAnimate);
            }
        }

        window.addEventListener('scroll', onScrollAnimate);
        window.addEventListener('load', onScrollAnimate);
    })();
    </script>
    <?php
}


add_action('wp_footer', 'giftara_main_carousel_script');

function giftara_main_carousel_script() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        
        // Console log check karne ke liye (Optional)
        console.log('Owl Giftara Carousel Initialized');

        $('.owl_giftara').owlCarousel({
            loop: true,
            nav: false,
            dots: false,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 5000,
            responsiveClass: true,
            smartSpeed: 3000,
            responsive: {
                0: {
                    items: 2,
                    nav: false,
                },
                400: {
                    items: 2,
                    nav: false,
                },
                600: {
                    items: 3,
                    nav: false,
                    margin: 5,
                },
                800: {
                    items: 3,
                    nav: false
                },
                1000: {
                    items: 4,
                    nav: false,
                }
            }
        });
    });
    </script>
    <?php
}


add_action('wp_footer', 'giftara_clientele_carousel_script');

function giftara_clientele_carousel_script() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        
        // Clientele Carousel Initialization
        $('.owl_clientele').owlCarousel({
            loop: true,
            nav: false,
            dots: false,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 5000,
            responsiveClass: true,
            smartSpeed: 3000,
            responsive: {
                0: {
                    items: 3,
                    nav: false,
                },
                400: {
                    items: 3,
                    nav: false,
                    margin: 5,
                },
                600: {
                    items: 4,
                    nav: false
                },
                800: {
                    items: 5,
                    nav: false
                },
                1000: {
                    items: 6,
                    nav: false,
                }
            }
        });
    });
    </script>
    <?php
}


add_filter( 'render_block', 'wrap_category_product_list_item', 10, 2 );

function wrap_category_product_list_item( $block_content, $block ) {
    // 1. Check karein ki kya block mein ".category-product-pg" class hai
    if ( isset( $block['attrs']['className'] ) && strpos( $block['attrs']['className'], 'category-product-pg' ) !== false ) {
        
        /**
         * 2. Hum regex use karenge jo har <li>...</li> ke content ko target karega
         * Aur us content ko <div class="cate-product-bx">...</div> mein wrap karega.
         */
        
        // Yeh pattern har <li> tag ke inner content ko group karega
        $pattern = '/<li([^>]*)>(.*?)<\/li>/is';
        
        // Replacement: content ko naye div ke andar daalna
        $replacement = '<li$1><div class="cate-product-bx">$2</div></li>';
        
        $block_content = preg_replace($pattern, $replacement, $block_content);
    }

    return $block_content;
}


add_filter( 'render_block', 'wrap_blog_list_item_content', 10, 2 );

function wrap_blog_list_item_content( $block_content, $block ) {
    // 1. Check karein ki kya block mein ".blog-sec" class di gayi hai
    if ( isset( $block['attrs']['className'] ) && strpos( $block['attrs']['className'], 'blog-sec' ) !== false ) {
        
        /**
         * 2. Regex ka use karke <li> ke inner content ko target karenge.
         * $1 = <li> ke attributes (classes, ids etc.)
         * $2 = <li> ke andar ka saara content (image, title, excerpt)
         */
        $pattern = '/<li([^>]*)>(.*?)<\/li>/is';
        
        // Content ko <div class="cate-product-bx"> mein wrap karna
        $replacement = '<li$1><div class="blog-sec-bx">$2</div></li>';
        
        $block_content = preg_replace($pattern, $replacement, $block_content);
    }

    return $block_content;
}


add_filter( 'render_block', 'add_owl_item_class_to_related_products', 10, 2 );

function add_owl_item_class_to_related_products( $block_content, $block ) {
    
    // 1. Check karein ki kya "related-pro-ul" class block attributes mein hai
    if ( isset( $block['attrs']['className'] ) && strpos( $block['attrs']['className'], 'related-pro-ul' ) !== false ) {
        
        // 2. Har <li> tag ko target karke usme "owl-item" class add karna
        // Hum check kar rahe hain ki agar pehle se koi class hai toh usme append karein
        if ( strpos( $block_content, '<li class="' ) !== false ) {
            $block_content = str_replace( '<li class="', '<li class="owl-item ', $block_content );
        } else {
            $block_content = str_replace( '<li', '<li class="owl-item"', $block_content );
        }
    }

    return $block_content;
}


add_filter( 'render_block', 'wrap_related_products_content', 10, 2 );

function wrap_related_products_content( $block_content, $block ) {
    // 1. Check karein ki kya block mein "related-pro-ul" class hai
    if ( isset( $block['attrs']['className'] ) && strpos( $block['attrs']['className'], 'related-pro-ul' ) !== false ) {
        
        /**
         * 2. Regex logic:
         * Yeh har <li> ke content ko target karega aur use wrap karega.
         * $1: li ke attributes (jaise class="product" etc.)
         * $2: li ke andar ka sara content (image, title, price)
         */
        $pattern = '/<li([^>]*)>(.*?)<\/li>/is';
        
        // Naye div "related-pro-box" ke sath replacement
        $replacement = '<li$1><div class="related-pro-box">$2</div></li>';
        
        $block_content = preg_replace($pattern, $replacement, $block_content);
    }

    return $block_content;
}


add_action('wp_footer', 'giftara_related_products_carousel_script');

function giftara_related_products_carousel_script() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        
        // Related Products Carousel Initialization
        $('.related_products_carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 4000,
            smartSpeed: 1200,
            responsive: {
                0: {
                    items: 1
                },
                359: {
                    items: 2
                },
                768: {
                    items: 3
                },
                991: {
                    items: 3
                },
                1200: {
                    items: 4
                }
            }
        });
    });
    </script>
    <?php
}

/**
 * Remove all WooCommerce default styles
 */
// add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );


function remove_wp_layout_inline_styles() {
    // Ye block themes ki layout-related inline CSS ko remove karta hai
    remove_filter( 'render_block', 'wp_render_layout_support_flag', 10, 2 );
    remove_filter( 'render_block_core_group', 'wp_render_layout_support_flag', 10, 2 );
}
add_action( 'init', 'remove_wp_layout_inline_styles' );


// 
add_action('wp_footer', 'giftara_header_menu_toggle_script');

function giftara_header_menu_toggle_script() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        
        // --- 1. 'header-menu-trigger' class add karna ---
        // Un sabhi links ko target karega jinke niche sub-menu hai
        $('.menu-item-has-children > a').addClass('header-menu-trigger');

        // --- 2. Click Event Handler ---
        $('.header-menu-trigger').on('click', function(e) {
            // Default link action rokne ke liye (taaki page refresh na ho)
            e.preventDefault();

            // Toggle classes for CSS styling
            $(this).toggleClass('open-menu active');

            // --- 3. Menu Toggle Logic ---
            // Agar aap specifically '.header-categories-menu' ko toggle karna chahte hain:
            if ($('.header-categories-menu').length > 0) {
                $('.header-categories-menu').slideToggle(300);
            }

            // Agar aap <a> ke theek niche wale sub-menu ko toggle karna chahte hain (Alternate logic):
            // $(this).siblings('.sub-menu').slideToggle(300);
        });
    });
    </script>
    <?php
}

// scrolling modal

add_action('wp_footer', 'giftara_scroll_popup_modal_script');

function giftara_scroll_popup_modal_script() {
    ?>
    <script type="text/javascript">
    (function() {
        let modalShown = false; // Sirf ek baar open hone ke liye

        window.addEventListener('scroll', function() {
            // Check: Kya modal pehle dikha hai? Aur kya scroll 2000px se zyada hai?
            if (!modalShown && window.scrollY > 2000) { 
                
                var modalElement = document.getElementById('scrollModal');
                
                // Safety: Agar HTML mein 'scrollModal' exist karta hai tabhi chale
                if (modalElement) {
                    modalShown = true;
                    
                    // Bootstrap 5 Modal initialize aur show karna
                    var myModal = new bootstrap.Modal(modalElement);
                    myModal.show();
                }
            }
        });
    })();
    </script>
    <?php
}


add_filter( 'render_block', function( $block_content, $block ) {
    
    // Inhe aise hi rehne dein, WordPress inka matlab samajhta hai
    if ( isset($block['blockName']) && $block['blockName'] === 'core/html' ) {
        
        // Bas ye class name match hona chahiye jo aapne editor mein dala hai
        if ( strpos( $block_content, 'scrolling-modal-form' ) !== false ) {
            
            return do_shortcode( $block_content );
        }
    }
    
    return $block_content;
}, 10, 2 );