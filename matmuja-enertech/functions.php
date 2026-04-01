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
    add_image_size( 'matmuja-hero', 1200, 700, true );
    add_image_size( 'matmuja-card', 640, 440, true );
    register_nav_menus( [
        'primary'  => __( 'Primary Menu', 'matmuja-tiefbau' ),
        'footer'   => __( 'Footer Menu', 'matmuja-tiefbau' ),
        'services' => __( 'Services Dropdown', 'matmuja-tiefbau' ),
    ] );
}
add_action( 'after_setup_theme', 'matmuja_setup' );

// ─── ENQUEUE SCRIPTS & STYLES ────────────────────────────
function matmuja_scripts() {
    wp_enqueue_style( 'matmuja-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap', [], null );
    wp_enqueue_style( 'matmuja-style', get_stylesheet_uri(), [ 'matmuja-google-fonts' ], '1.0.0' );
    wp_enqueue_script( 'matmuja-script', get_template_directory_uri() . '/assets/js/main.js', [], '1.0.0', true );
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
        'matmuja_phone'         => [ 'label' => 'Phone Number',    'default' => '+49 173 1829 446' ],
        'matmuja_email'         => [ 'label' => 'Email Address',   'default' => 'info@matmuja.de' ],
        'matmuja_address_line1' => [ 'label' => 'Address Line 1',  'default' => 'Zollernstr. 16' ],
        'matmuja_address_line2' => [ 'label' => 'Address Line 2',  'default' => '86154 Augsburg' ],
        'matmuja_instagram'     => [ 'label' => 'Instagram URL',   'default' => '#' ],
        'matmuja_linkedin'      => [ 'label' => 'LinkedIn URL',    'default' => '#' ],
    ];
    foreach ( $fields as $id => $args ) {
        $wp_customize->add_setting( $id, [ 'default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $id, [ 'label' => __( $args['label'], 'matmuja-tiefbau' ), 'section' => 'matmuja_company', 'type' => 'text' ] );
    }

    // Hero Section
    $wp_customize->add_section( 'matmuja_hero', [
        'title'    => __( 'Hero Section', 'matmuja-tiefbau' ),
        'priority' => 31,
    ] );
    $hero_fields = [
        'matmuja_hero_eyebrow'   => [ 'label' => 'Eyebrow Text',       'default' => 'Die Komplettlösung für Glasfaser' ],
        'matmuja_hero_title'     => [ 'label' => 'Hero Title',         'default' => 'Das Tiefbauunternehmen für ihr Glasfaserprojekt' ],
        'matmuja_hero_btn_text'  => [ 'label' => 'Button Text',        'default' => 'Kontaktieren Sie uns' ],
        'matmuja_hero_btn_url'   => [ 'label' => 'Button URL',         'default' => '/kontakt' ],
    ];
    foreach ( $hero_fields as $id => $args ) {
        $wp_customize->add_setting( $id, [ 'default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $id, [ 'label' => __( $args['label'], 'matmuja-tiefbau' ), 'section' => 'matmuja_hero', 'type' => 'text' ] );
    }
    $wp_customize->add_setting( 'matmuja_hero_image', [ 'default' => '', 'sanitize_callback' => 'absint' ] );
    $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'matmuja_hero_image', [
        'label'     => __( 'Hero Background Image', 'matmuja-tiefbau' ),
        'section'   => 'matmuja_hero',
        'mime_type' => 'image',
    ] ) );
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

// ─── BODY CLASS ───────────────────────────────────────────
function matmuja_body_classes( $classes ) {
    if ( is_singular() ) {
        $classes[] = 'singular';
    }
    return $classes;
}
add_filter( 'body_class', 'matmuja_body_classes' );
