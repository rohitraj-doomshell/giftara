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

/**
 * Google Fonts ko bina kisi filter ke direct load karna
 * Taaki preload aur stylesheet dono 100% work karein
 */
function tt5_add_google_fonts_final_fix() {
    $font_url = 'https://fonts.googleapis.com/css2?family=Alkatra:wght@400..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Jost:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Tenor+Sans&display=swap';

    // 1. Preconnect (Speed ke liye)
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";

    // 2. Preload (Browser ko pehle batane ke liye)
    echo '<link rel="preload" as="style" href="' . $font_url . '" crossorigin>' . "\n";

    // 3. Actual Stylesheet (Font apply karne ke liye)
    echo '<link rel="stylesheet" href="' . $font_url . '" crossorigin>' . "\n";
}
// Isse hum wp_head mein sabse upar dalenge
add_action('wp_head', 'tt5_add_google_fonts_final_fix', 1);

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
        $('.menu-item-has-children > a').addClass('header-menu-trigger');

        // --- 2. Click Event Handler ---
        $('.header-menu-trigger').on('click', function(e) {
            
            // Check karein ki window width 991px se zyada hai ya nahi
            if (window.innerWidth > 991) {
                
                // Desktop logic: Link click hone se rokein aur menu toggle karein
                e.preventDefault();

                // Toggle classes for CSS styling
                $(this).toggleClass('open-menu active');

                // Menu Toggle Logic
                if ($('.header-categories-menu').length > 0) {
                    $('.header-categories-menu').slideToggle(300);
                }
                
            } else {
                // Mobile logic (991px or less): 
                // e.preventDefault() nahi chalega, isliye link normal behave karega 
                // aur user href wale URL par chala jayega.
                return true; 
            }
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


add_filter( 'render_block', 'remove_empty_tags_from_blog_content', 10, 2 );

function remove_empty_tags_from_blog_content( $block_content, $block ) {
    
    // Check karein ki kya block mein ".blog_content_info" class hai
    if ( isset( $block['attrs']['className'] ) && strpos( $block['attrs']['className'], 'blog_content_info' ) !== false ) {
        
        // 1. Khali <p> tags hatayein (jinme sirf space ya &nbsp; ho)
        $block_content = preg_replace('/<p[^>]*>(\s|&nbsp;)*<\/p>/', '', $block_content);
        
        // 2. <br> tags ko hatayein
        $block_content = str_replace('<br>', '', $block_content);
        $block_content = str_replace('<br />', '', $block_content);
        $block_content = str_replace('<br/>', '', $block_content);
    }

    return $block_content;
}

add_action('wp_footer', 'giftara_animated_counter_script');

function giftara_animated_counter_script() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        
        // Counter animation function
        function startCounter($this) {
            $this.prop('Counter', 0).animate({
                Counter: $this.text()
            }, {
                duration: 4000,
                easing: 'swing',
                step: function(now) {
                    $this.text(Math.ceil(now));
                },
                complete: function() {
                    $this.addClass('counted');
                }
            });
        }

        // Intersection Observer: Jab counter screen par dikhega tabhi chalega
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    let $el = $(entry.target);
                    if (!$el.hasClass('counted')) {
                        startCounter($el);
                    }
                }
            });
        }, { threshold: 0.5 }); // Jab 50% counter dikhega tab start hoga

        $('.counter').each(function() {
            observer.observe(this);
        });
    });
    </script>
    <?php
}

add_action('wp_footer', 'giftara_mobile_menu_toggle_logic');

function giftara_mobile_menu_toggle_logic() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        
        // 1. Menu Open karne ke liye
        $('.mobile-nav-toggle').on('click', function(e) {
            e.preventDefault();
            $('.primary-menu-wrapper').addClass('open');
            // Optional: Body scroll lock karne ke liye taaki menu ke piche page na hile
            $('body').css('overflow', 'hidden'); 
        });

        // 2. Menu Close karne ke liye
        $('.mobile-menu-closico').on('click', function(e) {
            e.preventDefault();
            $('.primary-menu-wrapper').removeClass('open');
            // Body scroll wapas enable karne ke liye
            $('body').css('overflow', 'auto');
        });

        // 3. Optional: Agar user menu ke bahar click kare toh bhi band ho jaye
        $(document).on('click', function(event) {
            if (!$(event.target).closest('.primary-menu-wrapper, .mobile-nav-toggle').length) {
                $('.primary-menu-wrapper').removeClass('open');
                $('body').css('overflow', 'auto');
            }
        });

    });
    </script>
    <?php
}
/* -------------------------------------------------
   WATCH & BUY OWL INIT (USING LOCAL OWL)
------------------------------------------------- */
add_action('wp_footer', function () { ?>
    <script>
        jQuery(document).ready(function ($) {
            if ($('.watch-owlcrausal').length) {
                $('.watch-owlcrausal').owlCarousel({
                    items: 1,
                    loop: true,
                    margin: 20,
                    nav: true,
                    dots: true
                });
            }
        });
    </script>
<?php });
/* -------------------------------------------------
   WATCH & BUY SHORTCODE
------------------------------------------------- */
add_shortcode('watch_and_buy', function () {

    if (!class_exists('WooCommerce')) {
        return '<p>WooCommerce not active</p>';
    }

    $q = new WP_Query([
        'post_type'      => 'product',
        'posts_per_page' => 6,
        'tax_query'      => [
            [
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => 'watch-and-buy',
            ],
        ],
    ]);

    if (!$q->have_posts()) {
        return '<p>No Watch & Buy products found</p>';
    }

    ob_start(); ?>

    <section class="watch-buy-section">
        <h2>Watch And Buy</h2>

        <div class="owl-carousel watch-owlcrausal">
            <?php while ($q->have_posts()) : $q->the_post();
                global $product;

                $video_url = get_post_meta(get_the_ID(), 'rsfv_featured_embed_video', true);
                if (!$video_url) continue;

                if (!preg_match('/(?:shorts\/|v=|youtu\.be\/|embed\/)([A-Za-z0-9_-]+)/', $video_url, $m)) {
                    continue;
                }

                $video_id = $m[1];
            ?>
                <div class="watch-item">
                    <iframe
                        src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>?rel=0&controls=1"
                        allowfullscreen
                        loading="lazy">
                    </iframe>

                    <h3><?php the_title(); ?></h3>
                    <p><?php echo $product->get_price_html(); ?></p>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </section>

    <?php
    return ob_get_clean();
});
/**
 * 1. SEARCH SHORTCODE (Isko Editor mein [giftara_search] likh kar use karein)
 */
function giftara_search_shortcode() {
    ob_start(); 
    ?>
    <div class="header-toggles hide-no-js header_search">
        <div class="giftara-header-search">
            <form role="search" method="get" class="search-form giftara-search-box" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                
                <input type="search" 
                       class="search-field" 
                       placeholder="Search for gifts, products or categories…" 
                       name="s" 
                       value="<?php echo get_search_query(); ?>" 
                       autocomplete="off">
                
                <input type="hidden" name="post_type" value="product">
                
                <button type="submit" class="search-submit">
                    <svg class="svg-icon" aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23">
                        <path d="M38.710696,48.0601792 L43,52.3494831 L41.3494831,54 L37.0601792,49.710696 C35.2632422,51.1481185 32.9839107,52.0076499 30.5038249,52.0076499 C24.7027226,52.0076499 20,47.3049272 20,41.5038249 C20,35.7027226 24.7027226,31 30.5038249,31 C36.3049272,31 41.0076499,35.7027226 41.0076499,41.5038249 C41.0076499,43.9839107 40.1481185,46.2632422 38.710696,48.0601792 Z M36.3875844,47.1716785 C37.8030221,45.7026647 38.6734666,43.7048964 38.6734666,41.5038249 C38.6734666,36.9918565 35.0157934,33.3341833 30.5038249,33.3341833 C25.9918565,33.3341833 22.3341833,36.9918565 22.3341833,41.5038249 C22.3341833,46.0157934 25.9918565,49.6734666 30.5038249,49.6734666 C32.7048964,49.6734666 34.7026647,48.8030221 36.1716785,47.3875844 C36.2023931,47.347638 36.2360451,47.3092237 36.2726343,47.2726343 C36.3092237,47.2360451 36.347638,47.2023931 36.3875844,47.1716785 Z" transform="translate(-20 -31)"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'giftara_search', 'giftara_search_shortcode' );

/**
 * 2. JOIN TABLES (Connect Categories to Search)
 */
function giftara_join_tables( $join ) {
    if ( is_search() && ! is_admin() ) {
        global $wpdb;
        // Check if we are searching products
        if ( isset( $_GET['post_type'] ) && 'product' == $_GET['post_type'] ) {
            $join .= "
            LEFT JOIN {$wpdb->term_relationships} ON {$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id
            LEFT JOIN {$wpdb->term_taxonomy} ON {$wpdb->term_relationships}.term_taxonomy_id = {$wpdb->term_taxonomy}.term_taxonomy_id
            LEFT JOIN {$wpdb->terms} ON {$wpdb->term_taxonomy}.term_id = {$wpdb->terms}.term_id
            ";
        }
    }
    return $join;
}
add_filter( 'posts_join', 'giftara_join_tables' );

/**
 * 3. MODIFY WHERE CLAUSE (Search logic)
 */
function giftara_search_categories( $where ) {
    if ( is_search() && ! is_admin() ) {
        global $wpdb;
        if ( isset( $_GET['post_type'] ) && 'product' == $_GET['post_type'] ) {
            $s = get_search_query();
            // Secure the search term
            $s = esc_sql( $wpdb->esc_like( $s ) );

            // Add OR condition: If category name matches search term
            $where .= " OR (
                {$wpdb->term_taxonomy}.taxonomy IN ('product_cat', 'product_tag') 
                AND {$wpdb->terms}.name LIKE '%{$s}%'
            )";
        }
    }
    return $where;
}
add_filter( 'posts_where', 'giftara_search_categories' );

/**
 * 4. PREVENT DUPLICATES (Use DISTINCT instead of GroupBy to avoid SQL Errors)
 */
function giftara_search_distinct( $distinct ) {
    if ( is_search() && ! is_admin() ) {
        if ( isset( $_GET['post_type'] ) && 'product' == $_GET['post_type'] ) {
            return "DISTINCT";
        }
    }
    return $distinct;
}
add_filter( 'posts_distinct', 'giftara_search_distinct' );

/**
 * GIFTARA CUSTOM: Quick Enquiry Modal Logic
 */

// 1. Add "Quick Enquiry" Button next to Add to Cart
function giftara_add_enquiry_button() {
    echo '<button type="button" id="giftara-enquiry-btn" class="button giftara-popup-btn">Quick Enquiry</button>';
}
// Priority 35 usually places it after the Add to Cart button
add_action( 'woocommerce_after_add_to_cart_button', 'giftara_add_enquiry_button', 35 );


// 2. Add Modal HTML, CSS, and JS to the Footer
function giftara_enquiry_modal_footer() {
    // Only load this on Single Product Pages
    if ( ! is_product() ) return;
    ?>

    <div id="giftaraModal" class="giftara-modal">
        <div class="giftara-modal-content">
            <span class="close-giftara-modal">&times;</span>
            <h3>Quick Enquiry</h3>
            
            <?php echo do_shortcode('[contact-form-7 id="eed7879" title="Enquery"]'); ?>
            
        </div>
    </div>

    <style>
        /* --- 1. Button Styling --- */
        .giftara-popup-btn {
            background-color: #e44d9b !important; /* Pink Color */
            color: #fff !important;
            margin-left: 10px;
            border-radius: 50px; /* Rounded pill shape */
            border: none;
            padding: 10px 20px;
        }
        .giftara-popup-btn:hover {
            background-color: #c23b82 !important;
            opacity: 0.9;
        }

        /* --- 2. Modal Background (Overlay) --- */
        .giftara-modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 99999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* Enable scroll if form is tall */
            background-color: rgba(0,0,0,0.6); /* Black background with opacity */
            backdrop-filter: blur(4px); /* Blur effect behind modal */
        }

        /* --- 3. Modal Content Box --- */
        .giftara-modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 30px;
            border: 1px solid #888;
            width: 90%;
            max-width: 650px;
            border-radius: 12px;
            position: relative;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            font-family: var(--wp--preset--font-family--source-serif-pro, sans-serif);
        }

        /* Close (X) Button */
        .close-giftara-modal {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            position: absolute;
            right: 20px;
            top: 10px;
            line-height: 1;
        }
        .close-giftara-modal:hover { color: #000; }

        /* --- 4. FORM LAYOUT FIXES (Making col-md-6 work) --- */
        
        /* Simulate Bootstrap Row */
        .giftara-modal-content .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -10px;
            margin-left: -10px;
        }

        /* Simulate Bootstrap Columns */
        .giftara-modal-content .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding-right: 10px;
            padding-left: 10px;
            box-sizing: border-box;
        }
        
        .giftara-modal-content .col-md-12 {
            flex: 0 0 100%;
            max-width: 100%;
            padding-right: 10px;
            padding-left: 10px;
            box-sizing: border-box;
        }

        /* Input Styling */
        .giftara-modal-content input[type="text"],
        .giftara-modal-content input[type="email"],
        .giftara-modal-content input[type="tel"],
        .giftara-modal-content input[type="number"],
        .giftara-modal-content textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            background: #f9f9f9;
            box-sizing: border-box;
        }

        /* Label Styling */
        .giftara-modal-content label {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
        }

        /* Submit Button Styling */
        .giftara-modal-content input[type="submit"] {
            width: 100%;
            background-color: #e44d9b;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
        }

        /* Mobile Responsive: Stack columns on small screens */
        @media screen and (max-width: 600px) {
            .giftara-modal-content .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById("giftaraModal");
        var btn = document.getElementById("giftara-enquiry-btn");
        var span = document.getElementsByClassName("close-giftara-modal")[0];

        // Open Modal
        if(btn) {
            btn.onclick = function(e) {
                e.preventDefault(); // Prevent default link behavior
                modal.style.display = "block";
            }
        }

        // Close on X
        if(span) {
            span.onclick = function() {
                modal.style.display = "none";
            }
        }

        // Close when clicking outside the box
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    });
    </script>
    <?php
}
add_action( 'wp_footer', 'giftara_enquiry_modal_footer' );

// ==========================================
// GIFTARA FINAL SETUP
// ==========================================

// 1. Enqueue Assets
function giftara_final_assets() {
    if (!is_admin()) {
        wp_enqueue_script('three-js', 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js', array(), '0.128', true);
        wp_localize_script('jquery', 'giftara_ajax_object', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('giftara_box_nonce'),
            'is_logged_in' => is_user_logged_in()
        ));
    }
}
add_action('wp_enqueue_scripts', 'giftara_final_assets', 30);

// 2. Register Shortcode
function giftara_final_shortcode() {
    ob_start();
    $file = get_stylesheet_directory() . '/giftara-build-box.php';
    if(file_exists($file)) include $file;
    return ob_get_clean();
}
add_shortcode('giftara_build_box', 'giftara_final_shortcode');

// 3. AJAX Mail Handler
add_action('wp_ajax_giftara_send_order_emails', 'giftara_send_final_order');
function giftara_send_final_order() {
    check_ajax_referer('giftara_box_nonce', 'nonce');
    
    $current_user = wp_get_current_user();
    $data = json_decode(stripslashes($_POST['order_data']), true);
    $type = $_POST['type']; // 'sample' or 'order'
    
    $to = $current_user->user_email;
    $admin_email = get_option('admin_email');
    $subject = "Giftara: " . ucfirst($type) . " Request Received";
    
    // Construct Email Body
    $message = "Hello " . $current_user->display_name . ",\n\n";
    $message .= "We have received your request for a " . $type . ".\n\n";
    $message .= "Occasion: " . $data['occasion'] . "\n";
    $message .= "Packaging: " . $data['box']['name'] . "\n";
    $message .= "Quantity: " . $data['orderQty'] . "\n\n";
    $message .= "We will contact you shortly.";

    // Handle Logo Attachment if exists
    $attachments = array();
    if (!empty($_FILES['company_logo'])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        $uploaded = wp_handle_upload($_FILES['company_logo'], array('test_form' => false));
        if ($uploaded && !isset($uploaded['error'])) {
            $attachments[] = $uploaded['file'];
        }
    }
    
    // Send Mails
    wp_mail($to, $subject, $message);
    wp_mail($admin_email, "New $type Request", print_r($data, true), '', $attachments);
    
    wp_send_json_success(['message' => 'Order received successfully!']);
}

/**
 * Giftara "First Purchase" 20% Off Popup
 * Home Page + Scroll Trigger Popup
 */
function giftara_newsletter_popup()
{

    // Sirf frontend + sirf Home Page
    if (is_admin() || ! is_front_page()) return;
?>

    <div id="giftaraScrollModal" class="giftara-overlay">
        <div class="giftara-popup-content">
            <button type="button" class="giftara-close-btn">&times;</button>

            <div class="giftara-popup-body">
                <div class="giftara-popup-text">
                    <h2>20% Off Your First Purchase</h2>
                    <p>
                        Provide your name and mobile number to get special offers,
                        early access to new collections, and personalized updates on WhatsApp.
                    </p>

                    <div class="giftara-form-wrapper">
                        <?php echo do_shortcode('[contact-form-7 id="117062e" title="Purchase Form"]'); ?>
                    </div>
                </div>

                <div class="giftara-popup-image">
                    <img src="https://staging.thegiftara.com/wp-content/uploads/2026/01/popup-img.png" alt="Special Offer">
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Close Button */
        .giftara-close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            background: transparent;
            border: none;
            font-size: 30px;
            font-weight: bold;
            color: #E256B9;
            cursor: pointer;
            z-index: 10;
            line-height: 1;
        }

        .giftara-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 999999;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(3px);
        }

        .giftara-popup-content {
            background: #fff;
            width: 90%;
            max-width: 900px;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
            display: flex;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            font-family: var(--wp--preset--font-family--source-serif-pro, sans-serif);
        }

        .giftara-close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            background: none;
            border: none;
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
            z-index: 10;
        }

        .giftara-popup-body {
            display: flex;
            width: 100%;
        }

        .giftara-popup-text {
            flex: 1;
            padding: 40px;
        }

        .giftara-popup-text h2 {
            font-size: 28px;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .giftara-popup-text p {
            font-size: 14px;
            color: #555;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .giftara-popup-image {
            flex: 1;
        }

        .giftara-popup-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .giftara-form-wrapper input[type="text"],
        .giftara-form-wrapper input[type="email"],
        .giftara-form-wrapper input[type="tel"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f9f9f9;
        }

        .giftara-form-wrapper input[type="submit"] {
            width: 100%;
            background: #e44d9b;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
        }

        .giftara-form-wrapper input[type="submit"]:hover {
            background: #c23b82;
        }

        @media (max-width: 768px) {
            .giftara-popup-body {
                flex-direction: column-reverse;
            }

            .giftara-popup-image {
                height: 150px;
            }

            .giftara-popup-text {
                padding: 20px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var modal = document.getElementById('giftaraScrollModal');
            var closeBtn = document.querySelector('.giftara-close-btn');

            function showPopupOnScroll() {

                var scrollPercent =
                    (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100;

                if (scrollPercent > 30) { // 30% scroll
                    modal.style.display = 'flex';
                    window.removeEventListener('scroll', showPopupOnScroll); // ek baar show hoke stop
                }
            }

            window.addEventListener('scroll', showPopupOnScroll);

            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    modal.style.display = 'none';
                });
            }

            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });

        });
    </script>


<?php
}