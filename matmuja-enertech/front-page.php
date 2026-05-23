<?php
/**
 * Front page template — v5 "Lichtleiter"
 *
 * @package matmuja-tiefbau
 */

get_header();

$mm = [
    'hero_eyebrow' => get_theme_mod( 'mm_hero_eyebrow', 'FTTH · TIEFBAU BIS BUCHSE' ),
    'hero_h1'      => get_theme_mod( 'mm_hero_h1',      'Glasfaser bauen wir bis zur letzten Hauswand.' ),
    'hero_lede'    => get_theme_mod( 'mm_hero_lede',    'M&M EnerTech ist ein deutscher FTTH-Tiefbaubetrieb mit zwei Ingenieuren an der Spitze. Vom Spaten bis zur Buchse — alle fünf Phasen aus einer Hand.' ),
    'hero_cta1'    => get_theme_mod( 'mm_hero_cta1_text', 'Projekt anfragen' ),
    'hero_cta1_url'=> get_theme_mod( 'mm_hero_cta1_url',  '#cta' ),
    'hero_cta2'    => get_theme_mod( 'mm_hero_cta2_text', 'Unser Prozess' ),
    'mission'      => get_theme_mod( 'mm_mission',      'Wir bauen Glasfaser so, dass sie hält — vom ersten Spatenstich bis zum aktiven Anschluss in der Wohnung.' ),
    'phases_eyebrow' => get_theme_mod( 'mm_phases_eyebrow', 'DER PROZESS' ),
    'phases_h2'    => get_theme_mod( 'mm_phases_h2',    'Vom Spaten bis zur Buchse.' ),
    'phases_lede'  => get_theme_mod( 'mm_phases_lede',  'Fünf Phasen, eine Verantwortung. Wir übernehmen die gesamte Wertschöpfungskette — und am Ende leuchtet bei Ihnen das Licht.' ),
    'team_eyebrow' => get_theme_mod( 'mm_team_eyebrow', 'ÜBER UNS' ),
    'team_h2'      => get_theme_mod( 'mm_team_h2',      'Zwei Ingenieure. Eine durchgehende Kette.' ),
    'team_lede'    => get_theme_mod( 'mm_team_lede',    'Ein Bauleiter für den Untergrund, ein Aktivierer für das Signal. Beide Ing. — beide vor Ort.' ),
    'proof_h2'     => get_theme_mod( 'mm_proof_h2',     'Was wir gebaut haben.' ),
    'faq_h2'       => get_theme_mod( 'mm_faq_h2',       'Häufige Fragen.' ),
    'cta_h2'       => get_theme_mod( 'mm_cta_h2',       'Bereit für den nächsten FTTH-Abschnitt?' ),
    'cta_btn'      => get_theme_mod( 'mm_cta_btn',      'Projekt anfragen' ),
];

$phases = [
    1 => [ 'title' => get_theme_mod( 'mm_phase_1_title', 'Planung' ),            'desc' => get_theme_mod( 'mm_phase_1_desc', 'GIS-gestützte Trassenplanung mit Netzbetreibern und Stadtwerken — vom Übergabepunkt bis zur Hauswand.' ) ],
    2 => [ 'title' => get_theme_mod( 'mm_phase_2_title', 'Tiefbau' ),            'desc' => get_theme_mod( 'mm_phase_2_desc', 'Präziser Tiefbau mit minimaler Eingriffstiefe. Microtrenching, klassischer Tiefbau und Pflugverlegung — je nach Untergrund.' ) ],
    3 => [ 'title' => get_theme_mod( 'mm_phase_3_title', 'Kabelverlegung' ),     'desc' => get_theme_mod( 'mm_phase_3_desc', 'Verlegung der Leerrohre und Einblasen der Faser. Saubere Übergabepunkte, dokumentierte Trassen.' ) ],
    4 => [ 'title' => get_theme_mod( 'mm_phase_4_title', 'Spleißen & Messung' ), 'desc' => get_theme_mod( 'mm_phase_4_desc', 'Spleißarbeiten an Muffe und Hausverteiler. OTDR-Messung dokumentiert jede einzelne Faser.' ) ],
    5 => [ 'title' => get_theme_mod( 'mm_phase_5_title', 'Hausanschluss' ),      'desc' => get_theme_mod( 'mm_phase_5_desc', 'FTTH-Anschluss bis zur aktiven Buchse. Übergabe an den Endkunden, Abnahmeprotokoll, fertig.' ) ],
];

$stats = [
    [ 'num' => get_theme_mod( 'mm_stat_1_num',   '12+' ),  'unit' => get_theme_mod( 'mm_stat_1_unit', 'JAHRE' ),       'label' => get_theme_mod( 'mm_stat_1_label', 'Tiefbau-Erfahrung' ) ],
    [ 'num' => get_theme_mod( 'mm_stat_2_num',   '1200' ), 'unit' => get_theme_mod( 'mm_stat_2_unit', 'KM' ),          'label' => get_theme_mod( 'mm_stat_2_label', 'Faser verlegt' ) ],
    [ 'num' => get_theme_mod( 'mm_stat_3_num',   '150' ),  'unit' => get_theme_mod( 'mm_stat_3_unit', 'PROJEKTE' ),    'label' => get_theme_mod( 'mm_stat_3_label', 'Abgeschlossen' ) ],
    [ 'num' => get_theme_mod( 'mm_stat_4_num',   'DIN' ),  'unit' => get_theme_mod( 'mm_stat_4_unit', 'ZERTIFIZIERT' ),'label' => get_theme_mod( 'mm_stat_4_label', 'Qualitätsstandard' ) ],
];

$faqs = [
    [ 'q' => get_theme_mod( 'mm_faq_1_q', 'Übernehmen Sie auch nur einzelne Phasen?' ),
      'a' => get_theme_mod( 'mm_faq_1_a', 'Ja. Häufig kommen wir für Tiefbau oder Spleißarbeiten dazu — können aber jederzeit den gesamten Anschluss übernehmen, wenn gewünscht.' ) ],
    [ 'q' => get_theme_mod( 'mm_faq_2_q', 'In welcher Region arbeiten Sie?' ),
      'a' => get_theme_mod( 'mm_faq_2_a', 'Schwerpunkt Süddeutschland, Projekte auch bundesweit nach Abstimmung.' ) ],
    [ 'q' => get_theme_mod( 'mm_faq_3_q', 'Wer sind Ihre üblichen Auftraggeber?' ),
      'a' => get_theme_mod( 'mm_faq_3_a', 'Netzbetreiber, Stadtwerke und kommunale Versorger. Hausanschlüsse direkt für Endkunden ebenfalls möglich.' ) ],
    [ 'q' => get_theme_mod( 'mm_faq_4_q', 'Wie schnell können Sie starten?' ),
      'a' => get_theme_mod( 'mm_faq_4_a', 'Kurzfristige Termine nach Verfügbarkeit. Vor jeder Beauftragung gibt es eine kostenlose Vor-Ort-Begehung.' ) ],
];
?>

<!-- §1 Hero -->
<section class="hero" id="hero">
    <div class="shell">
        <div class="hero-text">
            <div class="eyebrow"><?php echo esc_html( $mm['hero_eyebrow'] ); ?></div>
            <h1 class="h1"><?php echo esc_html( $mm['hero_h1'] ); ?></h1>
            <p class="lede"><?php echo esc_html( $mm['hero_lede'] ); ?></p>
            <div class="hero-ctas">
                <a class="btn btn-primary" href="<?php echo esc_url( $mm['hero_cta1_url'] ); ?>"><?php echo esc_html( $mm['hero_cta1'] ); ?></a>
                <a class="btn btn-ghost" href="#phases"><?php echo esc_html( $mm['hero_cta2'] ); ?> <span aria-hidden="true">→</span></a>
            </div>
        </div>
        <div class="hero-art" aria-hidden="true">
            <svg viewBox="0 0 240 240" xmlns="http://www.w3.org/2000/svg">
                <circle cx="120" cy="120" r="100" fill="none" stroke="#0a0e1a" stroke-width="2"/>
                <circle cx="120" cy="120" r="56"  fill="none" stroke="#0040ff" stroke-width="2"/>
                <circle cx="120" cy="120" r="6"   fill="#ff6b1a"/>
                <line x1="120" y1="20" x2="120" y2="64"  stroke="#0a0e1a" stroke-width="1"/>
                <line x1="120" y1="176" x2="120" y2="220" stroke="#0a0e1a" stroke-width="1"/>
                <line x1="20" y1="120" x2="64" y2="120"  stroke="#0a0e1a" stroke-width="1"/>
                <line x1="176" y1="120" x2="220" y2="120" stroke="#0a0e1a" stroke-width="1"/>
                <text x="120" y="14" text-anchor="middle" font-family="Geist Mono, monospace" font-size="9" fill="#9aa1b0" letter-spacing="1">JACKET</text>
                <text x="120" y="236" text-anchor="middle" font-family="Geist Mono, monospace" font-size="9" fill="#9aa1b0" letter-spacing="1">STRAND</text>
            </svg>
        </div>
    </div>
</section>

<!-- §2 Mission strip -->
<section class="mission" id="mission">
    <div class="shell">
        <blockquote>„<?php echo esc_html( $mm['mission'] ); ?>"</blockquote>
        <div class="attrib">ING. BLERIM MATMUJA · ING. INDRIT MATMUJA</div>
    </div>
</section>

<!-- §3 Phase diagram -->
<section class="phases" id="phases">
    <div class="shell">
        <header class="reveal">
            <div class="eyebrow"><?php echo esc_html( $mm['phases_eyebrow'] ); ?></div>
            <h2 class="h2"><?php echo esc_html( $mm['phases_h2'] ); ?></h2>
            <p><?php echo esc_html( $mm['phases_lede'] ); ?></p>
        </header>

        <div class="fiber-stage" data-fiber-stage>
            <div class="fiber-svg-wrap">
                <svg class="fiber-svg" viewBox="0 0 1200 320" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path class="fiber-path" d="M 60 240 C 220 240, 280 60, 440 60 S 660 240, 820 240 S 1040 60, 1140 60" />
                    <path class="fiber-path draw" data-fiber-draw d="M 60 240 C 220 240, 280 60, 440 60 S 660 240, 820 240 S 1040 60, 1140 60" />

                    <?php
                    $station_t = [ 0.05, 0.27, 0.5, 0.73, 0.95 ];
                    foreach ( $station_t as $i => $t ) :
                        $idx = $i + 1;
                    ?>
                        <g class="fiber-station" data-station="<?php echo (int) $idx; ?>" data-station-t="<?php echo esc_attr( $t ); ?>">
                            <circle class="bg" r="18"/>
                            <text dy="42" text-anchor="middle">0<?php echo (int) $idx; ?> / 05</text>
                        </g>
                    <?php endforeach; ?>

                    <circle class="fiber-pulse" data-fiber-pulse r="6"/>
                </svg>
            </div>

            <div class="fiber-captions" aria-live="polite">
                <?php foreach ( $phases as $i => $p ) : ?>
                    <div class="fiber-caption<?php echo $i === 1 ? ' active' : ''; ?>" data-caption="<?php echo (int) $i; ?>">
                        <div class="num">PHASE 0<?php echo (int) $i; ?> / 05</div>
                        <h3 class="h3"><?php echo esc_html( $p['title'] ); ?></h3>
                        <p><?php echo esc_html( $p['desc'] ); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- §4 Team -->
<section class="team" id="team">
    <div class="shell">
        <header class="reveal">
            <div class="eyebrow"><?php echo esc_html( $mm['team_eyebrow'] ); ?></div>
            <h2 class="h2"><?php echo esc_html( $mm['team_h2'] ); ?></h2>
            <p><?php echo esc_html( $mm['team_lede'] ); ?></p>
        </header>

        <div class="team-grid">
            <article class="team-card reveal">
                <div class="team-portrait">BM</div>
                <h3>Ing. Blerim Matmuja</h3>
                <div class="role">ING. · IT / FTTH-AKTIVIERUNG</div>
                <p class="bio">Digitale Infrastruktur, GIS-Planung, IoT und FTTH-Aktivierung. Übergabe an den Endkunden ist sein Tisch.</p>
                <div class="team-skills">
                    <span>GIS</span><span>FTTH-Aktivierung</span><span>OTDR</span><span>IoT</span><span>Netzwerktechnik</span>
                </div>
            </article>
            <article class="team-card reveal">
                <div class="team-portrait">IM</div>
                <h3>Ing. Indrit Matmuja</h3>
                <div class="role">ING. · TIEFBAU / SPLEISSEN</div>
                <p class="bio">Maschinenbau und Elektrotechnik. Bauleitung, Tiefbau, Spleißarbeiten — der erste Spatenstich ist sein Tisch.</p>
                <div class="team-skills">
                    <span>Tiefbau</span><span>Spleißen</span><span>Maschinenbau</span><span>Elektrotechnik</span><span>Bauleitung</span>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- §5 Proof -->
<section class="proof" id="proof">
    <div class="shell">
        <header class="reveal">
            <div class="eyebrow">ZAHLEN</div>
            <h2 class="h2"><?php echo esc_html( $mm['proof_h2'] ); ?></h2>
        </header>
        <div class="stats">
            <?php foreach ( $stats as $s ) : ?>
                <div class="stat reveal">
                    <div class="num"><?php echo esc_html( $s['num'] ); ?></div>
                    <div class="underline" aria-hidden="true"></div>
                    <div class="unit"><?php echo esc_html( $s['unit'] ); ?></div>
                    <div class="label"><?php echo esc_html( $s['label'] ); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
        $logos = [];
        for ( $i = 1; $i <= 6; $i++ ) {
            $url = get_theme_mod( 'mm_client_logo_' . $i );
            if ( $url ) { $logos[] = $url; }
        }
        if ( ! empty( $logos ) ) : ?>
            <div class="client-strip">
                <?php foreach ( $logos as $url ) : ?>
                    <img src="<?php echo esc_url( $url ); ?>" alt="" loading="lazy">
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- §6 FAQ -->
<section class="faq" id="faq">
    <div class="shell">
        <header class="reveal">
            <div class="eyebrow">FAQ</div>
            <h2 class="h2"><?php echo esc_html( $mm['faq_h2'] ); ?></h2>
        </header>
        <?php foreach ( $faqs as $f ) : ?>
            <details>
                <summary><?php echo esc_html( $f['q'] ); ?></summary>
                <div><?php echo esc_html( $f['a'] ); ?></div>
            </details>
        <?php endforeach; ?>
    </div>
</section>

<!-- §7 CTA strip -->
<section class="cta-strip" id="cta">
    <div class="shell">
        <h2 class="h2"><?php echo esc_html( $mm['cta_h2'] ); ?></h2>
        <a class="btn btn-primary" href="mailto:<?php echo esc_attr( get_theme_mod( 'matmuja_email', 'info@matmuja.de' ) ); ?>"><?php echo esc_html( $mm['cta_btn'] ); ?></a>
        <div class="contact">
            <a href="tel:<?php echo esc_attr( get_theme_mod( 'matmuja_phone', '' ) ); ?>"><?php echo esc_html( get_theme_mod( 'matmuja_phone', '+49 — — —' ) ); ?></a>
            &nbsp;·&nbsp;
            <a href="mailto:<?php echo esc_attr( get_theme_mod( 'matmuja_email', 'info@matmuja.de' ) ); ?>"><?php echo esc_html( get_theme_mod( 'matmuja_email', 'info@matmuja.de' ) ); ?></a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
