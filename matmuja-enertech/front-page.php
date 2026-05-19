<?php
/**
 * Front page template — v3.0 FTTH
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
                <p class="eyebrow eyebrow--on-dark"><?php esc_html_e( 'M&M EnerTech · Glasfaser', 'matmuja-tiefbau' ); ?></p>
                <h1 class="hero__headline">
                    <?php echo esc_html( $mm( 'mm_hero_headline', __( 'Vom Spaten bis zur Buchse.', 'matmuja-tiefbau' ) ) ); ?>
                </h1>
                <p class="hero__sub">
                    <?php echo esc_html( $mm( 'mm_hero_sub', __( 'Glasfaserinfrastruktur von A bis Z — Tiefbau, Verlegung, Spleißen, Hausanschluss.', 'matmuja-tiefbau' ) ) ); ?>
                </p>
                <div class="hero__ctas">
                    <a class="btn btn--primary" href="<?php echo esc_url( $mm( 'mm_hero_cta_primary_url', '#kontakt' ) ); ?>">
                        <?php echo esc_html( $mm( 'mm_hero_cta_primary', __( 'FTTH anfragen', 'matmuja-tiefbau' ) ) ); ?>
                    </a>
                    <a class="btn btn--ghost" href="<?php echo esc_url( $mm( 'mm_hero_cta_secondary_url', '#prozess' ) ); ?>">
                        <?php echo esc_html( $mm( 'mm_hero_cta_secondary', __( '5 Phasen ansehen', 'matmuja-tiefbau' ) ) ); ?>
                    </a>
                </div>
            </div>
            <div class="hero__visual" aria-hidden="true" style="color: var(--color-brand-lime);">
                <svg viewBox="0 0 200 200" preserveAspectRatio="xMidYMid slice" style="width:100%;height:100%">
                    <defs>
                        <radialGradient id="hero-glow" cx="50%" cy="50%" r="60%">
                            <stop offset="0%"   stop-color="currentColor" stop-opacity="0.25"/>
                            <stop offset="100%" stop-color="currentColor" stop-opacity="0"/>
                        </radialGradient>
                        <pattern id="hero-grid" width="14" height="14" patternUnits="userSpaceOnUse">
                            <path d="M 14 0 L 0 0 0 14" fill="none" stroke="currentColor" stroke-width="0.25" opacity="0.35"/>
                        </pattern>
                    </defs>
                    <rect width="200" height="200" fill="url(#hero-grid)"/>
                    <rect width="200" height="200" fill="url(#hero-glow)"/>
                    <line x1="40"  y1="50"  x2="100" y2="100" stroke="currentColor" stroke-width="0.7" opacity="0.7"/>
                    <line x1="160" y1="60"  x2="100" y2="100" stroke="currentColor" stroke-width="0.7" opacity="0.7"/>
                    <line x1="60"  y1="150" x2="100" y2="100" stroke="currentColor" stroke-width="0.7" opacity="0.7"/>
                    <line x1="160" y1="150" x2="100" y2="100" stroke="currentColor" stroke-width="0.7" opacity="0.7"/>
                    <circle cx="40"  cy="50"  r="4" fill="currentColor"/>
                    <circle cx="100" cy="100" r="6" fill="currentColor"/>
                    <circle cx="160" cy="60"  r="4" fill="currentColor"/>
                    <circle cx="60"  cy="150" r="4" fill="currentColor"/>
                    <circle cx="160" cy="150" r="4" fill="currentColor"/>
                    <circle cx="100" cy="100" r="14" fill="none" stroke="currentColor" stroke-width="0.6" opacity="0.4"/>
                    <circle cx="100" cy="100" r="22" fill="none" stroke="currentColor" stroke-width="0.4" opacity="0.25"/>
                </svg>
            </div>
        </div>
    </div>
</section>

<!-- 2. MISSION STRIP -->
<section class="section--band">
    <div class="container">
        <p class="mission-strip">
            <?php echo esc_html( $mm( 'mm_mission_text', __( 'Glasfaser komplett aus einer Hand — wir übernehmen jede Phase vom ersten Spatenstich bis zur aktiven Buchse.', 'matmuja-tiefbau' ) ) ); ?>
        </p>
    </div>
</section>

<!-- 3. FTTH TIMELINE -->
<section id="prozess" class="section section--warm">
    <div class="container">
        <div class="ftth-header">
            <p class="eyebrow"><?php esc_html_e( 'Unser Glasfaser-Prozess', 'matmuja-tiefbau' ); ?></p>
            <h2><?php echo esc_html( $mm( 'mm_ftth_heading', __( 'In 5 Phasen zum Hausanschluss', 'matmuja-tiefbau' ) ) ); ?></h2>
        </div>

        <ol class="ftth-timeline">
            <?php
            $phase_defaults = [
                1 => [
                    'title' => __( 'Smart Planning & Design', 'matmuja-tiefbau' ),
                    'desc'  => __( 'GIS-gestützte Trassenplanung mit KI-Optimierung — von der Adressvalidierung bis zur 3D-Visualisierung.', 'matmuja-tiefbau' ),
                    'cta'   => __( 'Projektplanung starten', 'matmuja-tiefbau' ),
                    'url'   => '/stufe-1-projektplanung',
                    'svg'   => 's1_projektplanung_mm.svg',
                ],
                2 => [
                    'title' => __( 'Precision Tiefbau', 'matmuja-tiefbau' ),
                    'desc'  => __( 'GPS-gesteuerte minimalinvasive Verfahren, die Bestandsnetze schonen und Trassen präzise vorbereiten.', 'matmuja-tiefbau' ),
                    'cta'   => __( 'Tiefbau-Details', 'matmuja-tiefbau' ),
                    'url'   => '/stufe-2-tiefbauarbeiten',
                    'svg'   => 's2_tiefbau_mm.svg',
                ],
                3 => [
                    'title' => __( 'Kabelverlegung', 'matmuja-tiefbau' ),
                    'desc'  => __( 'Mikrorohr-Systeme und Glasfaser-Einblasen mit Schutz für bestehende Infrastruktur.', 'matmuja-tiefbau' ),
                    'cta'   => __( 'Verlegung verstehen', 'matmuja-tiefbau' ),
                    'url'   => '/stufe-3-kabelverlegung',
                    'svg'   => 's3_kabelverlegung_mm.svg',
                ],
                4 => [
                    'title' => __( 'Spleißen & Messung', 'matmuja-tiefbau' ),
                    'desc'  => __( 'Präzise Faser-zu-Faser-Verbindung, OTDR-Abnahmemessung, dokumentierte Qualitätssicherung.', 'matmuja-tiefbau' ),
                    'cta'   => __( 'Spleiß-Standards', 'matmuja-tiefbau' ),
                    'url'   => '/stufe-4-spleissen',
                    'svg'   => 's4_spleissen_mm.svg',
                ],
                5 => [
                    'title' => __( 'Hausanschluss / FTTH', 'matmuja-tiefbau' ),
                    'desc'  => __( 'Die aktive Buchse beim Endkunden — bereit für Gigabit. Das Ziel der ganzen Reise.', 'matmuja-tiefbau' ),
                    'cta'   => __( 'Hausanschluss anfragen', 'matmuja-tiefbau' ),
                    'url'   => '/stufe-5-hausanschluss',
                    'svg'   => 's5_hausanschluss_mm.svg',
                ],
            ];

            for ( $i = 1; $i <= 5; $i++ ) :
                $title = $mm( "mm_phase_{$i}_title",    $phase_defaults[ $i ]['title'] );
                $desc  = $mm( "mm_phase_{$i}_desc",     $phase_defaults[ $i ]['desc'] );
                $cta   = $mm( "mm_phase_{$i}_cta_text", $phase_defaults[ $i ]['cta'] );
                $url   = $mm( "mm_phase_{$i}_cta_url",  $phase_defaults[ $i ]['url'] );
                $side  = ( $i % 2 === 1 ) ? 'right' : 'left';
                $final = ( 5 === $i ) ? ' ftth-phase--final' : '';
                $svg   = $phase_defaults[ $i ]['svg'];
                ?>
                <li class="ftth-phase ftth-phase--<?php echo esc_attr( $side ); ?><?php echo $final; ?>">
                    <div class="ftth-phase__content">
                        <p class="ftth-phase__number"><?php printf( esc_html__( 'Phase %02d', 'matmuja-tiefbau' ), $i ); ?><?php if ( 5 === $i ) : ?> · <?php esc_html_e( 'Ziellinie', 'matmuja-tiefbau' ); ?><?php endif; ?></p>
                        <h3 class="ftth-phase__title"><?php echo esc_html( $title ); ?></h3>
                        <p class="ftth-phase__desc"><?php echo esc_html( $desc ); ?></p>
                        <?php if ( $cta && $url ) : ?>
                            <a class="ftth-phase__cta" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $cta ); ?> &rarr;</a>
                        <?php endif; ?>
                    </div>
                    <div class="ftth-phase__visual" aria-hidden="true">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/' . $svg ); ?>" alt="" loading="lazy">
                    </div>
                </li>
            <?php endfor; ?>
        </ol>
    </div>
</section>

<!-- 4. PROOF -->
<section class="section section--dark">
    <div class="container">
        <div class="proof-stats">
            <div class="proof-stat">
                <div class="proof-stat__value"><?php echo esc_html( $mm( 'mm_proof_years', '12' ) ); ?>+</div>
                <div class="proof-stat__label"><?php esc_html_e( 'Jahre Tiefbau', 'matmuja-tiefbau' ); ?></div>
            </div>
            <div class="proof-stat">
                <div class="proof-stat__value"><?php echo esc_html( $mm( 'mm_proof_km', '1200' ) ); ?> km</div>
                <div class="proof-stat__label"><?php esc_html_e( 'Faser verlegt', 'matmuja-tiefbau' ); ?></div>
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

<!-- 5. FAQ -->
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

<!-- 6. CTA STRIP -->
<section id="kontakt" class="section section--dark">
    <div class="container cta-strip">
        <h2><?php echo esc_html( $mm( 'mm_cta_headline', __( 'Bereit für Ihr Glasfaserprojekt?', 'matmuja-tiefbau' ) ) ); ?></h2>
        <a class="btn btn--primary" href="<?php echo esc_url( $mm( 'mm_cta_button_url', 'mailto:info@matmuja.de' ) ); ?>">
            <?php echo esc_html( $mm( 'mm_cta_button_text', __( 'Kostenlose Erstberatung', 'matmuja-tiefbau' ) ) ); ?>
        </a>
    </div>
</section>

<?php get_footer(); ?>
