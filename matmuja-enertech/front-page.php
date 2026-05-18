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

<!-- 4. HOW WE WORK -->
<section class="section section--dark">
    <div class="container">
        <p class="eyebrow eyebrow--on-dark"><?php esc_html_e( 'Unser Vorgehen', 'matmuja-tiefbau' ); ?></p>
        <h2><?php echo esc_html( $mm( 'mm_process_heading', __( 'So arbeiten wir', 'matmuja-tiefbau' ) ) ); ?></h2>
        <div class="process-grid">
            <?php
            $process_defaults = [
                1 => [ __( 'Analyse', 'matmuja-tiefbau' ), __( 'Bestandsaufnahme und Bedarfsklärung vor Ort.', 'matmuja-tiefbau' ) ],
                2 => [ __( 'Konzept', 'matmuja-tiefbau' ), __( 'Maßgeschneidertes Konzept inkl. Wirtschaftlichkeit.', 'matmuja-tiefbau' ) ],
                3 => [ __( 'Umsetzung', 'matmuja-tiefbau' ), __( 'Realisierung durch zertifizierte Fachpartner.', 'matmuja-tiefbau' ) ],
                4 => [ __( 'Service', 'matmuja-tiefbau' ), __( 'Monitoring, Wartung und kontinuierliche Optimierung.', 'matmuja-tiefbau' ) ],
            ];
            for ( $i = 1; $i <= 4; $i++ ) :
                $title = $mm( "mm_process_step_{$i}_title", $process_defaults[ $i ][0] );
                $desc  = $mm( "mm_process_step_{$i}_desc",  $process_defaults[ $i ][1] );
                ?>
                <div class="process-step">
                    <div class="process-step__num"><?php echo esc_html( sprintf( '%02d', $i ) ); ?></div>
                    <h3 class="process-step__title"><?php echo esc_html( $title ); ?></h3>
                    <p class="process-step__desc"><?php echo esc_html( $desc ); ?></p>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<!-- 5. PROOF -->
<section class="section section--warm">
    <div class="container">
        <div class="proof-stats">
            <div class="proof-stat">
                <div class="proof-stat__value"><?php echo esc_html( $mm( 'mm_proof_years', '12' ) ); ?>+</div>
                <div class="proof-stat__label"><?php esc_html_e( 'Jahre', 'matmuja-tiefbau' ); ?></div>
            </div>
            <div class="proof-stat">
                <div class="proof-stat__value"><?php echo esc_html( $mm( 'mm_proof_projects', '150' ) ); ?></div>
                <div class="proof-stat__label"><?php esc_html_e( 'Projekte', 'matmuja-tiefbau' ); ?></div>
            </div>
            <div class="proof-stat">
                <div class="proof-stat__value"><?php echo esc_html( $mm( 'mm_proof_cert', 'DIN' ) ); ?></div>
                <div class="proof-stat__label"><?php esc_html_e( 'zertifiziert', 'matmuja-tiefbau' ); ?></div>
            </div>
        </div>
        <div class="proof-logos" aria-label="<?php esc_attr_e( 'Kunden', 'matmuja-tiefbau' ); ?>">
            <?php
            for ( $i = 1; $i <= 6; $i++ ) {
                $logo = $mm( "mm_client_logo_{$i}", '' );
                if ( $logo ) {
                    printf( '<img src="%s" alt="" loading="lazy">', esc_url( $logo ) );
                }
            }
            ?>
        </div>
    </div>
</section>

<!-- 6. FAQ -->
<section class="section">
    <div class="container">
        <p class="eyebrow"><?php esc_html_e( 'Häufige Fragen', 'matmuja-tiefbau' ); ?></p>
        <h2><?php echo esc_html( $mm( 'mm_faq_heading', __( 'FAQ', 'matmuja-tiefbau' ) ) ); ?></h2>
        <div class="faq-list">
            <?php
            $faq_defaults = [
                [ __( 'Wie läuft eine Erstberatung ab?', 'matmuja-tiefbau' ), __( 'Wir analysieren Ihre Situation vor Ort und entwickeln ein passendes Konzept.', 'matmuja-tiefbau' ) ],
                [ __( 'Welche Förderungen sind möglich?', 'matmuja-tiefbau' ), __( 'Wir prüfen Bundes-, Landes- und KfW-Förderungen für jedes Projekt.', 'matmuja-tiefbau' ) ],
                [ __( 'Wie lange dauert eine typische Umsetzung?', 'matmuja-tiefbau' ), __( 'Je nach Projektgröße zwischen 4 und 16 Wochen ab Auftragserteilung.', 'matmuja-tiefbau' ) ],
            ];
            for ( $i = 1; $i <= 5; $i++ ) :
                $q = $mm( "mm_faq_{$i}_q", $faq_defaults[ $i - 1 ][0] ?? '' );
                $a = $mm( "mm_faq_{$i}_a", $faq_defaults[ $i - 1 ][1] ?? '' );
                if ( ! $q ) { continue; }
                ?>
                <details class="faq-item">
                    <summary><?php echo esc_html( $q ); ?></summary>
                    <div class="faq-item__answer"><?php echo esc_html( $a ); ?></div>
                </details>
            <?php endfor; ?>
        </div>
    </div>
</section>

<!-- 7. CTA STRIP -->
<section id="kontakt" class="section section--dark">
    <div class="container cta-strip">
        <h2><?php echo esc_html( $mm( 'mm_cta_headline', __( 'Bereit für die Energiezukunft?', 'matmuja-tiefbau' ) ) ); ?></h2>
        <a class="btn btn--primary" href="<?php echo esc_url( $mm( 'mm_cta_button_url', 'mailto:info@matmuja.de' ) ); ?>">
            <?php echo esc_html( $mm( 'mm_cta_button_text', __( 'Beratung anfragen', 'matmuja-tiefbau' ) ) ); ?>
        </a>
    </div>
</section>

<?php get_footer(); ?>
