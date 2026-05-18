<?php
/**
 * Front page template — v2.0
 *
 * @package matmuja-tiefbau
 */

get_header();

$mm = function ( $key, $default = '' ) {
    return get_theme_mod( $key, $default );
};
?>

<!-- 1. HERO -->
<section class="hero section--dark">
    <div class="container">
        <div class="hero__grid">
            <div class="hero__content">
                <p class="eyebrow eyebrow--on-dark"><?php bloginfo( 'name' ); ?></p>
                <h1 class="hero__headline">
                    <?php echo esc_html( $mm( 'mm_hero_headline', __( 'Energietechnik, neu gedacht.', 'matmuja-tiefbau' ) ) ); ?>
                </h1>
                <p class="hero__sub">
                    <?php echo esc_html( $mm( 'mm_hero_sub', __( 'Smarte Lösungen für Industrie, Gewerbe und nachhaltige Quartiere.', 'matmuja-tiefbau' ) ) ); ?>
                </p>
                <div class="hero__ctas">
                    <a class="btn btn--primary" href="<?php echo esc_url( $mm( 'mm_hero_cta_primary_url', '#kontakt' ) ); ?>">
                        <?php echo esc_html( $mm( 'mm_hero_cta_primary', __( 'Beratung anfragen', 'matmuja-tiefbau' ) ) ); ?>
                    </a>
                    <a class="btn btn--ghost" href="<?php echo esc_url( $mm( 'mm_hero_cta_secondary_url', '#leistungen' ) ); ?>">
                        <?php echo esc_html( $mm( 'mm_hero_cta_secondary', __( 'Leistungen', 'matmuja-tiefbau' ) ) ); ?>
                    </a>
                </div>
            </div>
            <div class="hero__visual" aria-hidden="true">
                <svg viewBox="0 0 100 100" preserveAspectRatio="xMidYMid slice" style="position:absolute;inset:0;width:100%;height:100%;opacity:0.5">
                    <defs>
                        <pattern id="hero-grid" width="10" height="10" patternUnits="userSpaceOnUse">
                            <path d="M 10 0 L 0 0 0 10" fill="none" stroke="#c9a84c" stroke-width="0.2"/>
                        </pattern>
                    </defs>
                    <rect width="100" height="100" fill="url(#hero-grid)"/>
                    <circle cx="50" cy="50" r="20" fill="none" stroke="#c9a84c" stroke-width="0.4"/>
                    <circle cx="50" cy="50" r="32" fill="none" stroke="#c9a84c" stroke-width="0.2"/>
                </svg>
            </div>
        </div>
    </div>
</section>

<!-- 2. MISSION STRIP -->
<section class="section--band">
    <div class="container">
        <p class="mission-strip">
            <?php echo esc_html( $mm( 'mm_mission_text', __( 'Wir bringen smarte Energietechnik dorthin, wo sie wirklich Wirkung entfaltet.', 'matmuja-tiefbau' ) ) ); ?>
        </p>
    </div>
</section>

<!-- 3. SERVICES -->
<section id="leistungen" class="section">
    <div class="container">
        <p class="eyebrow"><?php esc_html_e( 'Was wir tun', 'matmuja-tiefbau' ); ?></p>
        <h2><?php echo esc_html( $mm( 'mm_services_heading', __( 'Unsere Leistungen', 'matmuja-tiefbau' ) ) ); ?></h2>
        <div class="services-grid">
            <?php for ( $i = 1; $i <= 3; $i++ ) :
                $title = $mm( "mm_service_{$i}_title", '' );
                $desc  = $mm( "mm_service_{$i}_desc", '' );
                if ( ! $title ) {
                    $defaults = [
                        1 => [ __( 'Photovoltaik', 'matmuja-tiefbau' ), __( 'Planung und Installation für Industrie und Gewerbe.', 'matmuja-tiefbau' ) ],
                        2 => [ __( 'Wärmepumpen', 'matmuja-tiefbau' ), __( 'Effiziente Heizungssysteme der nächsten Generation.', 'matmuja-tiefbau' ) ],
                        3 => [ __( 'Speicher & Smart Grid', 'matmuja-tiefbau' ), __( 'Intelligente Energiespeicher und Netzintegration.', 'matmuja-tiefbau' ) ],
                    ];
                    $title = $defaults[ $i ][0];
                    $desc  = $defaults[ $i ][1];
                }
                ?>
                <div class="service-card">
                    <div class="service-card__icon" aria-hidden="true"></div>
                    <h3 class="service-card__title"><?php echo esc_html( $title ); ?></h3>
                    <p class="service-card__desc"><?php echo esc_html( $desc ); ?></p>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>
