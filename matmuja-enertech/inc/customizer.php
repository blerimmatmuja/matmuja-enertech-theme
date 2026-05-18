<?php
/**
 * Customizer settings for v2.0.
 *
 * @package matmuja-tiefbau
 */

defined( 'ABSPATH' ) || exit;

add_action( 'customize_register', function ( WP_Customize_Manager $wp ) {

    $wp->add_panel( 'mm_v2', [
        'title'    => __( 'M&M EnerTech (v2.0)', 'matmuja-tiefbau' ),
        'priority' => 30,
    ] );

    $sections = [
        'mm_hero'     => __( 'Hero', 'matmuja-tiefbau' ),
        'mm_mission'  => __( 'Mission strip', 'matmuja-tiefbau' ),
        'mm_services' => __( 'Leistungen', 'matmuja-tiefbau' ),
        'mm_process'  => __( 'Prozess', 'matmuja-tiefbau' ),
        'mm_proof'    => __( 'Proof', 'matmuja-tiefbau' ),
        'mm_faq'      => __( 'FAQ', 'matmuja-tiefbau' ),
        'mm_cta'      => __( 'CTA', 'matmuja-tiefbau' ),
    ];
    foreach ( $sections as $id => $label ) {
        $wp->add_section( $id, [ 'title' => $label, 'panel' => 'mm_v2' ] );
    }

    $text = function ( $id, $section, $label, $default = '' ) use ( $wp ) {
        $wp->add_setting( $id, [ 'default' => $default, 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
        $wp->add_control( $id, [ 'label' => $label, 'section' => $section, 'type' => 'text' ] );
    };
    $textarea = function ( $id, $section, $label, $default = '' ) use ( $wp ) {
        $wp->add_setting( $id, [ 'default' => $default, 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ] );
        $wp->add_control( $id, [ 'label' => $label, 'section' => $section, 'type' => 'textarea' ] );
    };
    $url = function ( $id, $section, $label, $default = '' ) use ( $wp ) {
        $wp->add_setting( $id, [ 'default' => $default, 'sanitize_callback' => 'esc_url_raw', 'transport' => 'refresh' ] );
        $wp->add_control( $id, [ 'label' => $label, 'section' => $section, 'type' => 'url' ] );
    };
    $image = function ( $id, $section, $label ) use ( $wp ) {
        $wp->add_setting( $id, [ 'default' => '', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'refresh' ] );
        $wp->add_control( new WP_Customize_Image_Control( $wp, $id, [ 'label' => $label, 'section' => $section ] ) );
    };

    // Hero
    $text( 'mm_hero_headline', 'mm_hero', __( 'Headline', 'matmuja-tiefbau' ), 'Energietechnik, neu gedacht.' );
    $textarea( 'mm_hero_sub', 'mm_hero', __( 'Sub-headline', 'matmuja-tiefbau' ), 'Smarte Lösungen für Industrie, Gewerbe und nachhaltige Quartiere.' );
    $text( 'mm_hero_cta_primary',     'mm_hero', __( 'Primary CTA label', 'matmuja-tiefbau' ), 'Beratung anfragen' );
    $url(  'mm_hero_cta_primary_url', 'mm_hero', __( 'Primary CTA URL', 'matmuja-tiefbau' ), '#kontakt' );
    $text( 'mm_hero_cta_secondary',     'mm_hero', __( 'Secondary CTA label', 'matmuja-tiefbau' ), 'Leistungen' );
    $url(  'mm_hero_cta_secondary_url', 'mm_hero', __( 'Secondary CTA URL', 'matmuja-tiefbau' ), '#leistungen' );

    // Mission
    $textarea( 'mm_mission_text', 'mm_mission', __( 'Mission sentence', 'matmuja-tiefbau' ),
        'Wir bringen smarte Energietechnik dorthin, wo sie wirklich Wirkung entfaltet.' );

    // Services (3)
    $text( 'mm_services_heading', 'mm_services', __( 'Section heading', 'matmuja-tiefbau' ), 'Unsere Leistungen' );
    for ( $i = 1; $i <= 3; $i++ ) {
        $text(     "mm_service_{$i}_title", 'mm_services', sprintf( __( 'Service %d title', 'matmuja-tiefbau' ), $i ) );
        $textarea( "mm_service_{$i}_desc",  'mm_services', sprintf( __( 'Service %d description', 'matmuja-tiefbau' ), $i ) );
    }

    // Process (4)
    $text( 'mm_process_heading', 'mm_process', __( 'Section heading', 'matmuja-tiefbau' ), 'So arbeiten wir' );
    for ( $i = 1; $i <= 4; $i++ ) {
        $text(     "mm_process_step_{$i}_title", 'mm_process', sprintf( __( 'Step %d title', 'matmuja-tiefbau' ), $i ) );
        $textarea( "mm_process_step_{$i}_desc",  'mm_process', sprintf( __( 'Step %d description', 'matmuja-tiefbau' ), $i ) );
    }

    // Proof
    $text( 'mm_proof_years',    'mm_proof', __( 'Stat: years',    'matmuja-tiefbau' ), '12' );
    $text( 'mm_proof_projects', 'mm_proof', __( 'Stat: projects', 'matmuja-tiefbau' ), '150' );
    $text( 'mm_proof_cert',     'mm_proof', __( 'Stat: cert label', 'matmuja-tiefbau' ), 'DIN' );
    for ( $i = 1; $i <= 6; $i++ ) {
        $image( "mm_client_logo_{$i}", 'mm_proof', sprintf( __( 'Client logo %d', 'matmuja-tiefbau' ), $i ) );
    }

    // FAQ (5)
    $text( 'mm_faq_heading', 'mm_faq', __( 'Section heading', 'matmuja-tiefbau' ), 'FAQ' );
    for ( $i = 1; $i <= 5; $i++ ) {
        $text(     "mm_faq_{$i}_q", 'mm_faq', sprintf( __( 'Q%d', 'matmuja-tiefbau' ), $i ) );
        $textarea( "mm_faq_{$i}_a", 'mm_faq', sprintf( __( 'A%d', 'matmuja-tiefbau' ), $i ) );
    }

    // CTA
    $text( 'mm_cta_headline',    'mm_cta', __( 'Headline', 'matmuja-tiefbau' ), 'Bereit für die Energiezukunft?' );
    $text( 'mm_cta_button_text', 'mm_cta', __( 'Button text', 'matmuja-tiefbau' ), 'Beratung anfragen' );
    $url(  'mm_cta_button_url',  'mm_cta', __( 'Button URL', 'matmuja-tiefbau' ), 'mailto:info@matmuja.de' );
} );
