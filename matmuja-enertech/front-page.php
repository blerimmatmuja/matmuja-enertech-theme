<?php
/**
 * Front page template — v6 "Enfaser"
 *
 * Dark "light-through-fiber" identity. 7-section structure is locked (unchanged
 * since v4): Hero · Mission · 5-Phase process · Team · Proof · FAQ · CTA.
 * All content is driven by mm_* Customizer fields — carries over from v5 with
 * zero re-entry. Only the hero-lede default was renamed EnerTech → Enfaser.
 *
 * @package matmuja-tiefbau
 */

get_header();

$mm = [
    'hero_eyebrow' => get_theme_mod( 'mm_hero_eyebrow', 'FTTH · TIEFBAU BIS BUCHSE' ),
    'hero_h1'      => get_theme_mod( 'mm_hero_h1',      'Glasfaser bauen wir bis zur letzten Hauswand.' ),
    'hero_lede'    => get_theme_mod( 'mm_hero_lede',    'M&M Enfaser ist ein deutscher FTTH-Tiefbaubetrieb mit zwei Ingenieuren an der Spitze. Vom Spaten bis zur Buchse — alle fünf Phasen aus einer Hand.' ),
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
    <div class="shell hero-grid">
        <div class="hero-text">
            <span class="eyebrow"><?php echo esc_html( $mm['hero_eyebrow'] ); ?></span>
            <h1 class="h1"><?php echo esc_html( $mm['hero_h1'] ); ?></h1>
            <p class="lede"><?php echo esc_html( $mm['hero_lede'] ); ?></p>
            <div class="hero-ctas">
                <a class="btn btn-primary" href="<?php echo esc_url( $mm['hero_cta1_url'] ); ?>"><?php echo esc_html( $mm['hero_cta1'] ); ?></a>
                <a class="btn btn-ghost" href="#process"><?php echo esc_html( $mm['hero_cta2'] ); ?> <span class="arw" aria-hidden="true">→</span></a>
            </div>
            <div class="hero-meta">
                <div>Vom<b>Spaten</b></div>
                <div>bis zur<b>Buchse</b></div>
                <div>Phasen<b>5 / aus einer Hand</b></div>
            </div>
        </div>

        <figure class="hero-art" aria-label="Signal wandert durch die Glasfaser vom Startpunkt zur aktiven Buchse">
            <svg viewBox="-100 -100 200 200" role="img">
                <defs>
                    <linearGradient id="hg" x1="-82" y1="34" x2="82" y2="-56" gradientUnits="userSpaceOnUse">
                        <stop offset="0" stop-color="#B3A6F7"/><stop offset=".52" stop-color="#8B7BF0"/><stop offset="1" stop-color="#E6C25E"/>
                    </linearGradient>
                    <filter id="soft" x="-80%" y="-80%" width="260%" height="260%"><feGaussianBlur stdDeviation="2.6"/></filter>
                </defs>
                <circle class="ring" cx="0" cy="-10" r="86" stroke-width="1" opacity=".5"/>
                <circle class="ring" cx="0" cy="-10" r="54" stroke-width="1" opacity=".7"/>
                <path class="strand-dim" stroke-width="2.4" d="M-82,50 C-40,-28 -6,64 18,12 C38,-22 58,-14 82,-32"/>
                <path class="strand-glow" stroke-width="11" d="M-82,34 C-44,-54 -14,58 12,-4 C32,-46 56,-40 82,-56"/>
                <path class="strand-main" stroke-width="4.4" d="M-82,34 C-44,-54 -14,58 12,-4 C32,-46 56,-40 82,-56"/>
                <circle class="dot-start" cx="-82" cy="34" r="4.4"/>
                <circle cx="82" cy="-56" r="14" fill="none" stroke="#E6C25E" stroke-width="1.3" opacity=".55"/>
                <circle cx="82" cy="-56" r="9" fill="#E6C25E" opacity=".55" filter="url(#soft)"/>
                <circle class="dot-end" cx="82" cy="-56" r="7"/>
                <circle class="dot-end-core" cx="82" cy="-56" r="3.2"/>
                <circle class="pulse" r="2.8"/>
            </svg>
            <figcaption>01 Spaten → 05 Buchse</figcaption>
        </figure>
    </div>
</section>

<!-- §2 Mission strip -->
<section class="mission" id="mission">
    <div class="shell">
        <blockquote class="grad-text reveal">„<?php echo esc_html( $mm['mission'] ); ?>"</blockquote>
        <div class="attrib reveal">ING. BLERIM MATMUJA · ING. INDRIT MATMUJA</div>
    </div>
</section>

<!-- §3 Phase diagram -->
<section class="process" id="process">
    <div class="shell">
        <header class="sec-head reveal">
            <span class="eyebrow"><?php echo esc_html( $mm['phases_eyebrow'] ); ?></span>
            <h2 class="h2"><?php echo esc_html( $mm['phases_h2'] ); ?></h2>
            <p><?php echo esc_html( $mm['phases_lede'] ); ?></p>
        </header>

        <div class="fiber-frame reveal" id="fiber">
            <svg class="fiber-svg" viewBox="0 0 1200 300" aria-hidden="true">
                <defs>
                    <linearGradient id="pg" x1="0" y1="0" x2="1200" y2="0" gradientUnits="userSpaceOnUse">
                        <stop offset="0" stop-color="#B3A6F7"/><stop offset=".5" stop-color="#8B7BF0"/><stop offset="1" stop-color="#E6C25E"/>
                    </linearGradient>
                    <filter id="psoft" x="-200%" y="-200%" width="500%" height="500%"><feGaussianBlur stdDeviation="4"/></filter>
                </defs>
                <path class="fp-track" id="fpath" d="M 70 220 C 240 220, 300 70, 460 70 S 700 220, 840 220 S 1050 70, 1130 70"/>
                <path class="fp-draw"  id="fdraw" d="M 70 220 C 240 220, 300 70, 460 70 S 700 220, 840 220 S 1050 70, 1130 70"/>
                <g id="stations"></g>
                <circle class="fp-pulse" r="5"/>
            </svg>
        </div>

        <div class="captions">
            <?php foreach ( $phases as $i => $p ) : ?>
                <article class="cap" data-i="<?php echo (int) $i; ?>">
                    <div class="num">PHASE 0<?php echo (int) $i; ?> / 05</div>
                    <h3><?php echo esc_html( $p['title'] ); ?></h3>
                    <p><?php echo esc_html( $p['desc'] ); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- §4 Team -->
<section class="team" id="team">
    <div class="shell">
        <header class="sec-head reveal">
            <span class="eyebrow"><?php echo esc_html( $mm['team_eyebrow'] ); ?></span>
            <h2 class="h2"><?php echo esc_html( $mm['team_h2'] ); ?></h2>
            <p><?php echo esc_html( $mm['team_lede'] ); ?></p>
        </header>

        <div class="team-grid">
            <article class="tcard reveal">
                <div class="portrait">BM</div>
                <h3>Ing. Blerim Matmuja</h3>
                <div class="role">ING. · IT / FTTH-AKTIVIERUNG</div>
                <p class="bio">Digitale Infrastruktur, GIS-Planung, IoT und FTTH-Aktivierung. Die Übergabe an den Endkunden ist sein Tisch.</p>
                <div class="chips"><span>GIS</span><span>FTTH-Aktivierung</span><span>OTDR</span><span>IoT</span><span>Netzwerktechnik</span></div>
            </article>
            <article class="tcard reveal">
                <div class="portrait">IM</div>
                <h3>Ing. Indrit Matmuja</h3>
                <div class="role">ING. · TIEFBAU / SPLEISSEN</div>
                <p class="bio">Maschinenbau und Elektrotechnik. Bauleitung, Tiefbau, Spleißarbeiten — der erste Spatenstich ist sein Tisch.</p>
                <div class="chips"><span>Tiefbau</span><span>Spleißen</span><span>Maschinenbau</span><span>Elektrotechnik</span><span>Bauleitung</span></div>
            </article>
        </div>
    </div>
</section>

<!-- §5 Proof -->
<section class="proof" id="proof">
    <div class="shell">
        <header class="sec-head reveal">
            <span class="eyebrow">ZAHLEN</span>
            <h2 class="h2"><?php echo esc_html( $mm['proof_h2'] ); ?></h2>
        </header>
        <div class="stats">
            <?php foreach ( $stats as $s ) : ?>
                <div class="stat reveal">
                    <div class="n grad-text"><?php echo esc_html( $s['num'] ); ?></div>
                    <div class="bar" aria-hidden="true"></div>
                    <div class="u"><?php echo esc_html( $s['unit'] ); ?></div>
                    <div class="l"><?php echo esc_html( $s['label'] ); ?></div>
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
            <div class="client-strip reveal">
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
        <header class="sec-head reveal">
            <span class="eyebrow">FAQ</span>
            <h2 class="h2"><?php echo esc_html( $mm['faq_h2'] ); ?></h2>
        </header>
        <div class="faq-list reveal">
            <?php foreach ( $faqs as $f ) : ?>
                <details>
                    <summary><?php echo esc_html( $f['q'] ); ?><span class="pm" aria-hidden="true"></span></summary>
                    <div><?php echo esc_html( $f['a'] ); ?></div>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- §7 CTA strip -->
<section class="cta-strip" id="cta">
    <div class="glow" aria-hidden="true"></div>
    <div class="shell">
        <h2 class="h2 grad-text reveal"><?php echo esc_html( $mm['cta_h2'] ); ?></h2>
        <a class="btn btn-primary reveal" href="mailto:<?php echo esc_attr( get_theme_mod( 'matmuja_email', 'info@matmuja.de' ) ); ?>"><?php echo esc_html( $mm['cta_btn'] ); ?></a>
        <div class="contact reveal">
            <a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', get_theme_mod( 'matmuja_phone', '' ) ) ); ?>"><?php echo esc_html( get_theme_mod( 'matmuja_phone', '+49 — — —' ) ); ?></a>
            <span aria-hidden="true">·</span>
            <a href="mailto:<?php echo esc_attr( get_theme_mod( 'matmuja_email', 'info@matmuja.de' ) ); ?>"><?php echo esc_html( get_theme_mod( 'matmuja_email', 'info@matmuja.de' ) ); ?></a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
