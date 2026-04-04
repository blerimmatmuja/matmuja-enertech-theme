<?php
/**
 * Matmuja Tiefbau - Theme Functions
 *
 * @package matmuja-tiefbau
 */

// ─── THEME SETUP ─────────────────────────────────────────
function matmuja_setup() {
    load_theme_textdomain( 'matmuja-tiefbau', get_template_directory() . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'custom-logo', [
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ] );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'editor-color-palette' );
    add_theme_support( 'editor-font-sizes' );
    add_theme_support( 'editor-gradient-presets' );
    add_image_size( 'matmuja-hero', 1200, 700, true );
    add_image_size( 'matmuja-card', 640, 440, true );
    add_image_size( 'matmuja-thumbnail', 400, 300, true );
    register_nav_menus( [
        'primary'  => __( 'Primary Menu', 'matmuja-tiefbau' ),
        'footer'   => __( 'Footer Menu', 'matmuja-tiefbau' ),
        'services' => __( 'Services Dropdown', 'matmuja-tiefbau' ),
    ] );
}
add_action( 'after_setup_theme', 'matmuja_setup' );

// ─── ENQUEUE SCRIPTS & STYLES ────────────────────────────
function matmuja_scripts() {
    $theme_version = wp_get_theme()->get( 'Version' );

    wp_enqueue_style( 'matmuja-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap', [], null );
    wp_enqueue_style( 'matmuja-style', get_stylesheet_uri(), [ 'matmuja-google-fonts' ], $theme_version );

    $script_path = file_exists( get_template_directory() . '/assets/js/main.min.js' )
        ? '/assets/js/main.min.js'
        : '/assets/js/main.js';

    wp_enqueue_script( 'matmuja-script', get_template_directory_uri() . $script_path, [], $theme_version, true );

    wp_localize_script( 'matmuja-script', 'matmujaData', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'matmuja-nonce' ),
    ] );

    if ( is_singular() && comments_open() ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'matmuja_scripts' );

// ─── WIDGET AREAS ─────────────────────────────────────────
function matmuja_widgets_init() {
    register_sidebar( [
        'name'          => __( 'Blog Sidebar', 'matmuja-tiefbau' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Widgets in this area appear in the blog sidebar.', 'matmuja-tiefbau' ),
        'before_widget' => '<div class="sidebar-widget" id="%1$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ] );
    register_sidebar( [
        'name'          => __( 'Footer Widget Area', 'matmuja-tiefbau' ),
        'id'            => 'footer-1',
        'before_widget' => '<div class="footer-widget" id="%1$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ] );
}
add_action( 'widgets_init', 'matmuja_widgets_init' );

// ─── CUSTOMIZER ───────────────────────────────────────────
function matmuja_customize_register( $wp_customize ) {
    // Company Info
    $wp_customize->add_section( 'matmuja_company', [
        'title'    => __( 'Company Information', 'matmuja-tiefbau' ),
        'priority' => 30,
    ] );
    $fields = [
        'matmuja_phone'         => [ 'label' => 'Phone Number',    'default' => '+49 173 1829 446', 'sanitize' => 'sanitize_text_field' ],
        'matmuja_email'         => [ 'label' => 'Email Address',   'default' => 'info@matmuja.de', 'sanitize' => 'sanitize_email' ],
        'matmuja_address_line1' => [ 'label' => 'Address Line 1',  'default' => 'Zollernstr. 16', 'sanitize' => 'sanitize_text_field' ],
        'matmuja_address_line2' => [ 'label' => 'Address Line 2',  'default' => '86154 Augsburg', 'sanitize' => 'sanitize_text_field' ],
        'matmuja_instagram'     => [ 'label' => 'Instagram URL',   'default' => '#', 'sanitize' => 'esc_url_raw' ],
        'matmuja_linkedin'      => [ 'label' => 'LinkedIn URL',    'default' => '#', 'sanitize' => 'esc_url_raw' ],
    ];
    foreach ( $fields as $id => $args ) {
        $wp_customize->add_setting( $id, [
            'default'           => $args['default'],
            'sanitize_callback' => $args['sanitize'],
            'transport'         => 'postMessage'
        ] );
        $wp_customize->add_control( $id, [
            'label'   => __( $args['label'], 'matmuja-tiefbau' ),
            'section' => 'matmuja_company',
            'type'    => 'text'
        ] );
    }

    // Hero Section
    $wp_customize->add_section( 'matmuja_hero', [
        'title'    => __( 'Hero Section', 'matmuja-tiefbau' ),
        'priority' => 31,
    ] );
    $hero_fields = [
        'matmuja_hero_eyebrow'   => [ 'label' => 'Eyebrow Text',       'default' => 'Die Komplettlösung für Glasfaser', 'sanitize' => 'sanitize_text_field' ],
        'matmuja_hero_title'     => [ 'label' => 'Hero Title',         'default' => 'Das Tiefbauunternehmen für ihr Glasfaserprojekt', 'sanitize' => 'sanitize_text_field' ],
        'matmuja_hero_btn_text'  => [ 'label' => 'Button Text',        'default' => 'Kontaktieren Sie uns', 'sanitize' => 'sanitize_text_field' ],
        'matmuja_hero_btn_url'   => [ 'label' => 'Button URL',         'default' => '/kontakt', 'sanitize' => 'esc_url_raw' ],
    ];
    foreach ( $hero_fields as $id => $args ) {
        $wp_customize->add_setting( $id, [
            'default'           => $args['default'],
            'sanitize_callback' => $args['sanitize'],
            'transport'         => 'postMessage'
        ] );
        $wp_customize->add_control( $id, [
            'label'   => __( $args['label'], 'matmuja-tiefbau' ),
            'section' => 'matmuja_hero',
            'type'    => 'text'
        ] );
    }
    $wp_customize->add_setting( 'matmuja_hero_image', [
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage'
    ] );
    $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'matmuja_hero_image', [
        'label'     => __( 'Hero Background Image', 'matmuja-tiefbau' ),
        'section'   => 'matmuja_hero',
        'mime_type' => 'image',
    ] ) );

    // Intro Image
    $wp_customize->add_setting( 'matmuja_intro_image', [
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage'
    ] );
    $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'matmuja_intro_image', [
        'label'     => __( 'Intro Image', 'matmuja-tiefbau' ),
        'section'   => 'matmuja_intro',
        'mime_type' => 'image',
    ] ) );

    // Services Section Images
    $wp_customize->add_section( 'matmuja_services', [
        'title'    => __( 'Service Phase Images', 'matmuja-tiefbau' ),
        'priority' => 33,
    ] );
    $service_images = [
        'matmuja_service_1_image' => __( 'Phase 1: Smart Planning Image', 'matmuja-tiefbau' ),
        'matmuja_service_2_image' => __( 'Phase 2: Precision Engineering Image', 'matmuja-tiefbau' ),
        'matmuja_service_3_image' => __( 'Phase 3: Cable Deployment Image', 'matmuja-tiefbau' ),
        'matmuja_service_4_image' => __( 'Phase 4: Splicing Image', 'matmuja-tiefbau' ),
        'matmuja_service_5_image' => __( 'Phase 5: Smart Home Connection Image', 'matmuja-tiefbau' ),
    ];
    foreach ( $service_images as $setting_id => $label ) {
        $wp_customize->add_setting( $setting_id, [
            'default'           => '',
            'sanitize_callback' => 'absint',
            'transport'         => 'postMessage'
        ] );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $setting_id, [
            'label'     => $label,
            'section'   => 'matmuja_services',
            'mime_type' => 'image',
        ] ) );
    }

    // Intro Section
    $wp_customize->add_section( 'matmuja_intro', [
        'title'    => __( 'Intro Section', 'matmuja-tiefbau' ),
        'priority' => 32,
    ] );
    $intro_fields = [
        'matmuja_intro_title'    => [ 'label' => 'Intro Title',    'default' => 'Über Matmuja Tiefbau', 'sanitize' => 'sanitize_text_field' ],
        'matmuja_intro_text'     => [ 'label' => 'Intro Text',     'default' => 'Als innovatives Energie- und Tiefbauunternehmen mit Fokus auf zukunftsfähige Glasfaserlösungen unterstützen wir Netzbetreiber, Energieversorger und Stadtwerke deutschlandweit bei der Realisierung leistungsstarker Breitbandnetze. Unser Expertenteam kombiniert modernste Technologien mit bewährten Methoden für eine effiziente und zuverlässige Projektumsetzung — von der strategischen Planung bis zur vollständigen Netzwerkaktivierung.', 'sanitize' => 'wp_kses_post' ],
        'matmuja_intro_btn_text' => [ 'label' => 'Button Text',    'default' => 'Kostenlose Beratung', 'sanitize' => 'sanitize_text_field' ],
        'matmuja_intro_btn_url'  => [ 'label' => 'Button URL',     'default' => '/kontakt', 'sanitize' => 'esc_url_raw' ],
    ];
    foreach ( $intro_fields as $id => $args ) {
        $wp_customize->add_setting( $id, [
            'default'           => $args['default'],
            'sanitize_callback' => $args['sanitize'],
            'transport'         => 'postMessage'
        ] );
        $wp_customize->add_control( $id, [
            'label'   => __( $args['label'], 'matmuja-tiefbau' ),
            'section' => 'matmuja_intro',
            'type'    => 'textarea'
        ] );
    }
}
add_action( 'customize_register', 'matmuja_customize_register' );

// ─── HELPER FUNCTIONS ─────────────────────────────────────
function matmuja_get_option( $key, $default = '' ) {
    return get_theme_mod( $key, $default );
}

function matmuja_posted_on() {
    echo '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time>';
}

function matmuja_posted_by() {
    echo '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>';
}

function matmuja_excerpt( $length = 20 ) {
    $excerpt = wp_trim_words( get_the_excerpt(), $length, '...' );
    return $excerpt;
}

// ─── EXCERPT LENGTH ───────────────────────────────────────
function matmuja_excerpt_length( $length ) { return 25; }
add_filter( 'excerpt_length', 'matmuja_excerpt_length' );

// ─── CUSTOM READ MORE ─────────────────────────────────────
function matmuja_excerpt_more( $more ) { return '...'; }
add_filter( 'excerpt_more', 'matmuja_excerpt_more' );

// ─── CUSTOM POST TYPES ────────────────────────────────────
function matmuja_register_post_types() {
    // Services CPT
    register_post_type( 'service', [
        'labels' => [
            'name'          => __( 'Services', 'matmuja-tiefbau' ),
            'singular_name' => __( 'Service', 'matmuja-tiefbau' ),
            'add_new_item'  => __( 'Add New Service', 'matmuja-tiefbau' ),
        ],
        'public'       => true,
        'has_archive'  => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-admin-tools',
        'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
        'rewrite'      => [ 'slug' => 'dienstleistungen' ],
    ] );
    // References CPT
    register_post_type( 'reference', [
        'labels' => [
            'name'          => __( 'References', 'matmuja-tiefbau' ),
            'singular_name' => __( 'Reference', 'matmuja-tiefbau' ),
        ],
        'public'       => true,
        'has_archive'  => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-star-filled',
        'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
        'rewrite'      => [ 'slug' => 'referenzen' ],
    ] );
}
add_action( 'init', 'matmuja_register_post_types' );

// ─── SCHEMA MARKUP ─────────────────────────────────────
function matmuja_schema_markup() {
    if ( is_front_page() ) {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Matmuja Tiefbau',
            'description' => 'Professionelles Tiefbauunternehmen mit Spezialisierung auf Glasfaserinfrastruktur',
            'url' => home_url('/'),
            'logo' => get_template_directory_uri() . '/assets/images/logo.png',
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => matmuja_get_option('matmuja_phone', '+49 173 1829 446'),
                'contactType' => 'customer service',
                'availableLanguage' => 'German'
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => matmuja_get_option('matmuja_address_line1', 'Zollernstr. 16'),
                'addressLocality' => 'Augsburg',
                'postalCode' => '86154',
                'addressCountry' => 'DE'
            ],
            'sameAs' => array_filter([
                matmuja_get_option('matmuja_instagram'),
                matmuja_get_option('matmuja_linkedin')
            ])
        ];
        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
    }
}
add_action( 'wp_head', 'matmuja_schema_markup' );
