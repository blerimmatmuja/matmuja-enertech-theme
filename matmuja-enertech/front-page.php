<?php
/**
 * Front page template — v4.0 (dark cinematic, animated canvases)
 *
 * @package matmuja-tiefbau
 */

get_header();

$mm = function ( $key, $default = '' ) {
    return get_theme_mod( $key, $default );
};
?>

<!-- 1. HERO -->
<section class="hero">
    <div class="container">
        <div class="hero__inner">
            <div class="eyebrow"><span class="dot"></span><?php esc_html_e( 'Glasfaser Infrastruktur', 'matmuja-tiefbau' ); ?></div>
            <h1 class="hero__headline">
                <?php echo esc_html( $mm( 'mm_hero_headline', __( 'Vom Spaten bis zur Buchse.', 'matmuja-tiefbau' ) ) ); ?>
            </h1>
            <p class="hero__sub">
                <?php echo esc_html( $mm( 'mm_hero_sub', __( 'Glasfaserinfrastruktur von A bis Z — Tiefbau, Verlegung, Spleißen, Hausanschluss. Komplett aus einer Hand.', 'matmuja-tiefbau' ) ) ); ?>
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
    </div>
</section>

<!-- 2. MISSION STRIP -->
<section class="section--mission">
    <div class="container">
        <p class="mission-strip">
            <?php echo esc_html( $mm( 'mm_mission_text', __( 'Glasfaser komplett aus einer Hand — wir übernehmen jede Phase vom ersten Spatenstich bis zur aktiven Buchse.', 'matmuja-tiefbau' ) ) ); ?>
        </p>
    </div>
</section>

<!-- 3. FTTH TIMELINE (animated canvases) -->
<section id="prozess" class="section section--dark">
    <div class="container">
        <div class="ftth-header">
            <div class="eyebrow"><span class="dot"></span><?php esc_html_e( 'Unser Glasfaser-Prozess', 'matmuja-tiefbau' ); ?></div>
            <h2><?php echo esc_html( $mm( 'mm_ftth_heading', __( 'In 5 Phasen zum Hausanschluss', 'matmuja-tiefbau' ) ) ); ?></h2>
        </div>

        <ol class="ftth-timeline">
            <?php
            $phase_defaults = [
                1 => [
                    'tag'   => __( 'Phase 01', 'matmuja-tiefbau' ),
                    'title' => __( 'Smart Planning & Design', 'matmuja-tiefbau' ),
                    'desc'  => __( 'GIS-gestützte Trassenplanung mit KI-Optimierung — von der Adressvalidierung bis zur 3D-Visualisierung.', 'matmuja-tiefbau' ),
                    'cta'   => __( 'Projektplanung starten', 'matmuja-tiefbau' ),
                    'url'   => '/stufe-1-projektplanung',
                    'bullets' => [
                        __( 'GIS-Kartenanalyse & Geländemodell', 'matmuja-tiefbau' ),
                        __( 'KI-optimierte Trassenfindung', 'matmuja-tiefbau' ),
                        __( 'Kollisionsprüfung Bestandsnetze', 'matmuja-tiefbau' ),
                        __( '3D-BIM Projektmodell', 'matmuja-tiefbau' ),
                    ],
                ],
                2 => [
                    'tag'   => __( 'Phase 02', 'matmuja-tiefbau' ),
                    'title' => __( 'Precision Tiefbau', 'matmuja-tiefbau' ),
                    'desc'  => __( 'GPS-gesteuerte minimalinvasive Verfahren, die Bestandsnetze schonen und Trassen präzise vorbereiten.', 'matmuja-tiefbau' ),
                    'cta'   => __( 'Tiefbau-Details', 'matmuja-tiefbau' ),
                    'url'   => '/stufe-2-tiefbauarbeiten',
                    'bullets' => [
                        __( 'HDD — Horizontales Directional Drilling', 'matmuja-tiefbau' ),
                        __( 'GPS-gestützte Maschinensteuerung', 'matmuja-tiefbau' ),
                        __( 'Bestandsnetze vollständig geschützt', 'matmuja-tiefbau' ),
                        __( 'Minimale Oberflächeneingriffe', 'matmuja-tiefbau' ),
                    ],
                ],
                3 => [
                    'tag'   => __( 'Phase 03', 'matmuja-tiefbau' ),
                    'title' => __( 'Kabelverlegung', 'matmuja-tiefbau' ),
                    'desc'  => __( 'Mikrorohr-Systeme und Glasfaser-Einblasen mit Schutz für bestehende Infrastruktur.', 'matmuja-tiefbau' ),
                    'cta'   => __( 'Verlegung verstehen', 'matmuja-tiefbau' ),
                    'url'   => '/stufe-3-kabelverlegung',
                    'bullets' => [
                        __( 'Mikrorohrsysteme Ø 12–50 mm', 'matmuja-tiefbau' ),
                        __( 'Pneumatisches Einblasen bis 45 m/min', 'matmuja-tiefbau' ),
                        __( 'Bündelkabel bis 864 Fasern', 'matmuja-tiefbau' ),
                        __( 'Zugmessprotokoll & Drucktest', 'matmuja-tiefbau' ),
                    ],
                ],
                4 => [
                    'tag'   => __( 'Phase 04', 'matmuja-tiefbau' ),
                    'title' => __( 'Spleißen & Messung', 'matmuja-tiefbau' ),
                    'desc'  => __( 'Präzise Faser-zu-Faser-Verbindung, OTDR-Abnahmemessung, dokumentierte Qualitätssicherung.', 'matmuja-tiefbau' ),
                    'cta'   => __( 'Spleiß-Standards', 'matmuja-tiefbau' ),
                    'url'   => '/stufe-4-spleissen',
                    'bullets' => [
                        __( 'Fusionsspleißen < 0.02 dB Verlust', 'matmuja-tiefbau' ),
                        __( 'OTDR Reflektometrie full-trace', 'matmuja-tiefbau' ),
                        __( 'Mess- & Abnahmedokumentation', 'matmuja-tiefbau' ),
                        __( 'End-zu-End-Lichtprüfung', 'matmuja-tiefbau' ),
                    ],
                ],
                5 => [
                    'tag'   => __( 'Phase 05 · Ziellinie', 'matmuja-tiefbau' ),
                    'title' => __( 'Hausanschluss / FTTH', 'matmuja-tiefbau' ),
                    'desc'  => __( 'Die aktive Buchse beim Endkunden — bereit für Gigabit. Das Ziel der ganzen Reise.', 'matmuja-tiefbau' ),
                    'cta'   => __( 'Hausanschluss anfragen', 'matmuja-tiefbau' ),
                    'url'   => '/stufe-5-hausanschluss',
                    'bullets' => [
                        __( 'ONT / ONU Aktivierung & Konfiguration', 'matmuja-tiefbau' ),
                        __( 'Symmetrisches 1 Gbit/s Go-Live', 'matmuja-tiefbau' ),
                        __( 'Einweisung Endkunde vor Ort', 'matmuja-tiefbau' ),
                        __( 'Netzabnahme & Dokumentation', 'matmuja-tiefbau' ),
                    ],
                ],
            ];

            for ( $i = 1; $i <= 5; $i++ ) :
                $p     = $phase_defaults[ $i ];
                $title = $mm( "mm_phase_{$i}_title",    $p['title'] );
                $desc  = $mm( "mm_phase_{$i}_desc",     $p['desc'] );
                $cta   = $mm( "mm_phase_{$i}_cta_text", $p['cta'] );
                $url   = $mm( "mm_phase_{$i}_cta_url",  $p['url'] );
                ?>
                <li class="ftth-phase" id="s<?php echo $i; ?>" data-phase="<?php echo $i; ?>">
                    <div class="canvas-wrap">
                        <canvas id="c<?php echo $i; ?>" width="600" height="400" aria-hidden="true"></canvas>
                    </div>
                    <div class="ftth-phase__content">
                        <div class="ftth-phase__tag"><span class="dot"></span><?php echo esc_html( $p['tag'] ); ?></div>
                        <h3 class="ftth-phase__title"><?php echo esc_html( $title ); ?></h3>
                        <p class="ftth-phase__desc"><?php echo esc_html( $desc ); ?></p>
                        <ul class="ftth-phase__bullets">
                            <?php foreach ( $p['bullets'] as $bullet ) : ?>
                                <li><?php echo esc_html( $bullet ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php if ( $cta && $url ) : ?>
                            <a class="ftth-phase__cta" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $cta ); ?> &rarr;</a>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endfor; ?>
        </ol>
    </div>
</section>

<!-- 4. ABOUT US / TEAM -->
<section id="ueber-uns" class="section section--dark">
    <div class="container">
        <div class="ftth-header">
            <div class="eyebrow"><span class="dot"></span><?php esc_html_e( 'Über uns', 'matmuja-tiefbau' ); ?></div>
            <h2><?php esc_html_e( 'Das Team hinter M&M EnerTech', 'matmuja-tiefbau' ); ?></h2>
        </div>

        <div class="about-intro">
            <p><strong><?php esc_html_e( 'Bei M&M EnerTech arbeiten Informatik- und Maschinenbauingenieure Hand in Hand.', 'matmuja-tiefbau' ); ?></strong> <?php esc_html_e( 'Diese Kombination ermöglicht uns, Projekte ganzheitlich zu denken — von der digitalen Planung über den physischen Tiefbau bis zur vollständigen Netzwerkaktivierung.', 'matmuja-tiefbau' ); ?></p>
            <p><?php esc_html_e( 'Wir sind kein Großkonzern. Das bedeutet für Sie: persönliche Betreuung, direkte Kommunikation und ein Team, das wirklich für Ihr Projekt brennt.', 'matmuja-tiefbau' ); ?></p>
        </div>

        <div class="team-grid">
            <article class="team-card">
                <header class="team-card__header">
                    <div class="team-card__avatar" aria-hidden="true">&#x1F468;&#x200D;&#x1F4BB;</div>
                    <div class="team-card__name">Ing. Blerim Matmuja</div>
                    <div class="team-card__role"><?php esc_html_e( 'Informationstechnologie & Digitale Infrastruktur', 'matmuja-tiefbau' ); ?></div>
                </header>
                <div class="team-card__body">
                    <p class="team-card__bio"><?php esc_html_e( 'Mit einem Abschluss in Informationstechnologie und langjähriger Erfahrung in der Netzwerkplanung bringt Blerim die digitale Intelligenz in jedes Projekt. Er verantwortet die GIS-gestützte Trassenplanung, das IoT-Monitoring und die vollständige Netzwerkaktivierung nach Projektabschluss.', 'matmuja-tiefbau' ); ?></p>
                    <p class="team-card__bio"><?php esc_html_e( 'Sein Fokus liegt auf der Entwicklung smarter, skalierbarer Systeme — von der KI-gestützten Routenoptimierung bis zur Echtzeit-Überwachung der verlegten Glasfasernetze.', 'matmuja-tiefbau' ); ?></p>
                    <div class="team-card__skills">
                        <span class="team-card__skill"><?php esc_html_e( 'GIS-Planung', 'matmuja-tiefbau' ); ?></span>
                        <span class="team-card__skill"><?php esc_html_e( 'Netzwerkarchitektur', 'matmuja-tiefbau' ); ?></span>
                        <span class="team-card__skill"><?php esc_html_e( 'IoT-Monitoring', 'matmuja-tiefbau' ); ?></span>
                        <span class="team-card__skill"><?php esc_html_e( 'FTTH-Aktivierung', 'matmuja-tiefbau' ); ?></span>
                        <span class="team-card__skill"><?php esc_html_e( 'KI-Optimierung', 'matmuja-tiefbau' ); ?></span>
                    </div>
                </div>
            </article>

            <article class="team-card">
                <header class="team-card__header">
                    <div class="team-card__avatar" aria-hidden="true">&#x1F477;</div>
                    <div class="team-card__name">Ing. Indrit Matmuja</div>
                    <div class="team-card__role"><?php esc_html_e( 'Maschinenbau & Elektrotechnik', 'matmuja-tiefbau' ); ?></div>
                </header>
                <div class="team-card__body">
                    <p class="team-card__bio"><?php esc_html_e( 'Als Maschinenbauingenieur mit Schwerpunkt Elektrotechnik leitet Indrit alle Tiefbau- und Installationsarbeiten im Feld. Er sorgt dafür, dass jeder Graben, jedes Leerrohr und jede Hauseinführung exakt nach DIN-Norm und DVGW-Vorschrift ausgeführt wird.', 'matmuja-tiefbau' ); ?></p>
                    <p class="team-card__bio"><?php esc_html_e( 'Seine praktische Erfahrung mit modernen Baumaschinen, Spleißgeräten und Elektroinstallationen macht ihn zum Rückgrat der operativen Projektdurchführung — von der Baustellenleitung bis zur finalen Abnahme.', 'matmuja-tiefbau' ); ?></p>
                    <div class="team-card__skills">
                        <span class="team-card__skill"><?php esc_html_e( 'Tiefbau', 'matmuja-tiefbau' ); ?></span>
                        <span class="team-card__skill"><?php esc_html_e( 'Elektrotechnik', 'matmuja-tiefbau' ); ?></span>
                        <span class="team-card__skill"><?php esc_html_e( 'Glasfaserspleißen', 'matmuja-tiefbau' ); ?></span>
                        <span class="team-card__skill"><?php esc_html_e( 'DIN-Normen', 'matmuja-tiefbau' ); ?></span>
                        <span class="team-card__skill"><?php esc_html_e( 'Baustellenleitung', 'matmuja-tiefbau' ); ?></span>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- 5. PROOF -->
<section class="section section--dark-deep">
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

<!-- 6. FAQ -->
<section class="section section--dark">
    <div class="container">
        <div class="ftth-header">
            <div class="eyebrow"><span class="dot"></span><?php esc_html_e( 'Häufige Fragen', 'matmuja-tiefbau' ); ?></div>
            <h2><?php echo esc_html( $mm( 'mm_faq_heading', __( 'FAQ', 'matmuja-tiefbau' ) ) ); ?></h2>
        </div>
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
<section id="kontakt" class="section cta-strip">
    <div class="container">
        <h2><?php echo esc_html( $mm( 'mm_cta_headline', __( 'Bereit für Ihr Glasfaserprojekt?', 'matmuja-tiefbau' ) ) ); ?></h2>
        <a class="btn btn--primary" href="<?php echo esc_url( $mm( 'mm_cta_button_url', 'mailto:info@matmuja.de' ) ); ?>">
            <?php echo esc_html( $mm( 'mm_cta_button_text', __( 'Kostenlose Erstberatung', 'matmuja-tiefbau' ) ) ); ?>
        </a>
    </div>
</section>

<?php get_footer(); ?>
