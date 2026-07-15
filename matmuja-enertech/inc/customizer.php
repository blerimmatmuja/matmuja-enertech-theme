<?php
/**
 * Customizer settings for v4.0 (dark cinematic).
 *
 * @package matmuja-tiefbau
 */

defined( 'ABSPATH' ) || exit;

add_action( 'customize_register', function ( WP_Customize_Manager $wp ) {

    $wp->add_panel( 'mm_v2', [
        'title'    => __( 'M&M Enfaser (v6.0)', 'matmuja-tiefbau' ),
        'priority' => 30,
    ] );

    $sections = [
        'mm_hero'    => __( 'Hero', 'matmuja-tiefbau' ),
        'mm_mission' => __( 'Mission strip', 'matmuja-tiefbau' ),
        'mm_ftth'    => __( 'FTTH-Prozess', 'matmuja-tiefbau' ),
        'mm_proof'   => __( 'Proof', 'matmuja-tiefbau' ),
        'mm_faq'     => __( 'FAQ', 'matmuja-tiefbau' ),
        'mm_cta'     => __( 'CTA', 'matmuja-tiefbau' ),
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
    $text( 'mm_hero_headline', 'mm_hero', __( 'Headline', 'matmuja-tiefbau' ), 'Vom Spaten bis zur Buchse.' );
    $textarea( 'mm_hero_sub', 'mm_hero', __( 'Sub-headline', 'matmuja-tiefbau' ), 'Glasfaserinfrastruktur von A bis Z — Planung, Verlegung, Montage, Spleißen, Hausanschluss.' );
    $text( 'mm_hero_cta_primary',     'mm_hero', __( 'Primary CTA label', 'matmuja-tiefbau' ), 'FTTH anfragen' );
    $url(  'mm_hero_cta_primary_url', 'mm_hero', __( 'Primary CTA URL', 'matmuja-tiefbau' ), '#kontakt' );
    $text( 'mm_hero_cta_secondary',     'mm_hero', __( 'Secondary CTA label', 'matmuja-tiefbau' ), '5 Phasen ansehen' );
    $url(  'mm_hero_cta_secondary_url', 'mm_hero', __( 'Secondary CTA URL', 'matmuja-tiefbau' ), '#prozess' );

    // Mission
    $textarea( 'mm_mission_text', 'mm_mission', __( 'Mission sentence', 'matmuja-tiefbau' ),
        'Glasfaser komplett aus einer Hand — wir übernehmen jede Phase von der Planung bis zur aktiven Buchse.' );

    // FTTH phases (5)
    $text( 'mm_ftth_heading', 'mm_ftth', __( 'Section heading', 'matmuja-tiefbau' ), 'In 5 Phasen zum Hausanschluss' );
    $phase_defaults = [
        1 => [ 'Smart Planning & Design',  'GIS-gestützte Trassenplanung mit KI-Optimierung — von der Adressvalidierung bis zur 3D-Visualisierung.',  'Projektplanung starten',  '/stufe-1-projektplanung' ],
        2 => [ 'Verlegung & Montage',       'Leerrohre und Glasfaser fachgerecht verlegt und eingeblasen — Bestandsnetze geschont, Trassen dokumentiert.',  'Verlegung-Details',       '/stufe-2-verlegung' ],
        3 => [ 'Kabelverlegung',            'Mikrorohr-Systeme und Glasfaser-Einblasen mit Schutz für bestehende Infrastruktur.',                       'Verlegung verstehen',     '/stufe-3-kabelverlegung' ],
        4 => [ 'Spleißen & Messung',        'Präzise Faser-zu-Faser-Verbindung, OTDR-Abnahmemessung, dokumentierte Qualitätssicherung.',                'Spleiß-Standards',        '/stufe-4-spleissen' ],
        5 => [ 'Hausanschluss / FTTH',      'Die aktive Buchse beim Endkunden — bereit für Gigabit. Das Ziel der ganzen Reise.',                       'Hausanschluss anfragen',  '/stufe-5-hausanschluss' ],
    ];
    for ( $i = 1; $i <= 5; $i++ ) {
        list( $pt, $pd, $pc, $pu ) = $phase_defaults[ $i ];
        $text(     "mm_phase_{$i}_title",    'mm_ftth', sprintf( __( 'Phase %d title', 'matmuja-tiefbau' ),       $i ), $pt );
        $textarea( "mm_phase_{$i}_desc",     'mm_ftth', sprintf( __( 'Phase %d description', 'matmuja-tiefbau' ), $i ), $pd );
        $text(     "mm_phase_{$i}_cta_text", 'mm_ftth', sprintf( __( 'Phase %d CTA label', 'matmuja-tiefbau' ),   $i ), $pc );
        $url(      "mm_phase_{$i}_cta_url",  'mm_ftth', sprintf( __( 'Phase %d CTA URL', 'matmuja-tiefbau' ),     $i ), $pu );
    }

    // Proof
    $text( 'mm_proof_years',    'mm_proof', __( 'Stat: years',    'matmuja-tiefbau' ), '12' );
    $text( 'mm_proof_km',       'mm_proof', __( 'Stat: km fiber', 'matmuja-tiefbau' ), '1200' );
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
    $text( 'mm_cta_headline',    'mm_cta', __( 'Headline', 'matmuja-tiefbau' ), 'Bereit für Ihr Glasfaserprojekt?' );
    $text( 'mm_cta_button_text', 'mm_cta', __( 'Button text', 'matmuja-tiefbau' ), 'Kostenlose Erstberatung' );
    $url(  'mm_cta_button_url',  'mm_cta', __( 'Button URL', 'matmuja-tiefbau' ), 'mailto:info@matmuja.de' );
} );
