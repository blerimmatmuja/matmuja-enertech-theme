<?php
/**
 * Front Page Template
 * @package matmuja-tiefbau
 */
get_header();
?>

<?php // ═══════════════════════════════════════════════════
//  HERO SECTION
// ═══════════════════════════════════════════════════ ?>
<section class="hero">
    <?php if ( $img_id = matmuja_get_option('matmuja_hero_image') ) : ?>
        <div class="hero-visual">
            <?php echo wp_get_attachment_image( $img_id, 'full', false, ['alt' => ''] ); ?>
        </div>
    <?php else : ?>
        <div class="hero-visual" aria-hidden="true">
            <svg viewBox="0 0 600 500" xmlns="http://www.w3.org/2000/svg" style="opacity:0.4;width:100%">
                <ellipse cx="400" cy="250" rx="280" ry="280" fill="rgba(245,166,35,0.3)"/>
                <circle cx="420" cy="220" r="180" fill="rgba(245,166,35,0.15)" stroke="rgba(245,166,35,0.3)" stroke-width="2"/>
            </svg>
        </div>
    <?php endif; ?>
    <div class="container">
        <div class="hero-content">
            <span class="hero-eyebrow"><?php echo esc_html( matmuja_get_option('matmuja_hero_eyebrow', 'Die Zukunft der digitalen Infrastruktur') ); ?></span>
            <h1 class="hero-title"><?php echo nl2br( esc_html( matmuja_get_option('matmuja_hero_title', "Ihr Partner für\nNext-Gen Glasfasernetze") ) ); ?></h1>
            <div class="hero-buttons">
                <a href="<?php echo esc_url( matmuja_get_option('matmuja_hero_btn_url', home_url('/kontakt')) ); ?>" class="btn btn-outline-white">
                    <?php echo esc_html( matmuja_get_option('matmuja_hero_btn_text', 'Kontaktieren Sie uns') ); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php // ═══════════════════════════════════════════════════
//  INTRO / ABOUT SECTION
// ═══════════════════════════════════════════════════ ?>
<section class="section section-intro">
    <div class="container">
        <div class="row">
            <div class="col">
                <?php $intro_img_id = matmuja_get_option( 'matmuja_intro_image' ); ?>
                <div style="border-radius:16px;overflow:hidden;background:rgba(25,25,122,0.1);min-height:320px;display:flex;align-items:center;justify-content:center;">
                    <?php if ( $intro_img_id && $intro_img_html = wp_get_attachment_image( $intro_img_id, 'large', false, ['alt' => esc_attr__( 'Intro Bild', 'matmuja-tiefbau' )] ) ) : ?>
                        <?php echo $intro_img_html; ?>
                    <?php else : ?>
                        <svg viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg" style="width:80%;opacity:0.7">
                            <rect x="100" y="180" width="200" height="80" rx="8" fill="#19197a" opacity="0.6"/>
                            <circle cx="200" cy="130" r="80" fill="none" stroke="#19197a" stroke-width="8" opacity="0.5"/>
                            <circle cx="200" cy="130" r="55" fill="none" stroke="#f5a623" stroke-width="6" opacity="0.7"/>
                            <circle cx="200" cy="130" r="30" fill="#f5a623" opacity="0.5"/>
                        </svg>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col col-2 intro-text">
                <p><strong><?php _e('Als innovatives Energie- und Tiefbauunternehmen mit Fokus auf zukunftsfähige Glasfaserlösungen unterstützen wir Netzbetreiber, Energieversorger und Stadtwerke deutschlandweit', 'matmuja-tiefbau'); ?></strong> <?php _e('bei der Realisierung leistungsstarker Breitbandnetze. Unser Expertenteam kombiniert modernste Technologien mit bewährten Methoden für eine effiziente und zuverlässige Projektumsetzung — von der strategischen Planung bis zur vollständigen Netzwerkaktivierung.', 'matmuja-tiefbau'); ?></p>
                <p><strong><?php _e('Entdecken Sie die Zukunft der Konnektivität mit uns als Partner', 'matmuja-tiefbau'); ?></strong> <?php _e('der Innovation, Präzision und Nachhaltigkeit vereint, um die digitale Transformation Ihrer Region voranzutreiben.', 'matmuja-tiefbau'); ?></p>
                <a href="<?php echo esc_url(home_url('/kontakt')); ?>" class="btn btn-primary" style="margin-top:1.5rem;">
                    <?php _e('Kostenlose Erstberatung', 'matmuja-tiefbau'); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php // ═══════════════════════════════════════════════════
//  FULL-TURNKEY BANNER
// ═══════════════════════════════════════════════════ ?>
<section class="section-sm" style="background:#fff;text-align:center;padding:4rem 0;">
    <div class="container">
        <p style="color:var(--color-text-light);font-size:1rem;letter-spacing:0.1em;text-transform:uppercase;font-weight:600;margin-bottom:0.5rem;">
            <?php _e('Komplette Lösungen', 'matmuja-tiefbau'); ?>
        </p>
        <h2><?php _e('Next-Gen Glasfasernetze', 'matmuja-tiefbau'); ?></h2>
        <p style="color:var(--color-text-light);max-width:600px;margin:0.75rem auto 0;">
            <?php _e('Von der Infrastruktur bis zur Konnektivität — nahtlose End-to-End-Implementierung', 'matmuja-tiefbau'); ?>
        </p>
    </div>
</section>

<?php // ═══════════════════════════════════════════════════
//  SERVICES TIMELINE
// ═══════════════════════════════════════════════════ ?>
<section class="section section-services">
    <div class="container">

        <?php // ─── Service Item 1: Projektplanung ─── ?>
        <div class="row" style="gap:4rem;margin-bottom:5rem;align-items:center;">
            <div class="col">
                <div class="timeline-content">
                    <span class="hero-eyebrow" style="color:var(--color-accent);"><?php _e('Phase 1', 'matmuja-tiefbau'); ?></span>
                    <h2><?php _e('Smart Planning & Design', 'matmuja-tiefbau'); ?></h2>
                    <p><?php _e('Die digitale Transformation beginnt mit intelligenten Planungslösungen. Unser Expertenteam analysiert Ihre Anforderungen mit modernsten GIS-Tools und KI-gestützten Algorithmen für optimale Trassenführung.', 'matmuja-tiefbau'); ?></p>
                    <p><?php _e('Von der digitalen Adressvalidierung über präzise Genehmigungsplanung bis zur 3D-Visualisierung: Wir entwickeln maßgeschneiderte Konzepte, die maximale Effizienz und Zukunftssicherheit garantieren.', 'matmuja-tiefbau'); ?></p>
                    <a href="<?php echo esc_url(home_url('/kontakt')); ?>" class="btn btn-outline" style="margin-top:1.5rem;"><?php _e('Projektplanung starten', 'matmuja-tiefbau'); ?></a>
                </div>
            </div>
            <div class="col" style="display:flex;align-items:center;justify-content:center;">
                <div class="service-visual">
                    <?php
                    $s1_img_id = matmuja_get_option( 'matmuja_service_1_image' );
                    if ( $s1_img_id && $s1_img_html = wp_get_attachment_image( $s1_img_id, 'large', false, ['class' => 'service-svg', 'alt' => esc_attr__( 'Smart Planning', 'matmuja-tiefbau' )] ) ) {
                        echo $s1_img_html;
                    } else {
                        echo '<img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/s1_projektplanung_mm.svg" alt="' . esc_attr__( 'Smart Planning', 'matmuja-tiefbau' ) . '" class="service-svg">';
                    }
                    ?>
                </div>
            </div>
        </div>

        <div style="width:2px;height:80px;background:var(--color-primary);margin:0 auto;opacity:0.3;"></div>
        <div style="width:16px;height:16px;background:var(--color-accent);border-radius:50%;margin:0 auto;border:3px solid var(--color-primary);"></div>
        <div style="width:2px;height:80px;background:var(--color-primary);margin:0 auto;opacity:0.3;"></div>

        <?php // ─── Service Item 2: Tiefbau ─── ?>
        <div class="row" style="gap:4rem;margin-bottom:5rem;align-items:center;flex-direction:row-reverse;">
            <div class="col">
                <div class="timeline-content">
                    <span class="hero-eyebrow" style="color:var(--color-accent);"><?php _e('Phase 2', 'matmuja-tiefbau'); ?></span>
                    <h2><?php _e('Precision Engineering', 'matmuja-tiefbau'); ?></h2>
                    <p><?php _e('Moderne Tiefbautechnik trifft auf präzise Ingenieurskunst. Unser Team setzt auf minimalinvasive Verfahren und GPS-gesteuerte Maschinen für maximale Präzision bei minimaler Umweltbelastung.', 'matmuja-tiefbau'); ?></p>
                    <p><strong><?php _e('Von der intelligenten Trassenpräparation bis zur schützendem Infrastruktursicherung', 'matmuja-tiefbau'); ?></strong> <?php _e('– mit nachhaltigen Methoden, die bestehende Netze schonen und zukunftsfähige Lösungen ermöglichen.', 'matmuja-tiefbau'); ?></p>
                    <a href="<?php echo esc_url(home_url('/dienstleistungen')); ?>" class="btn btn-outline" style="margin-top:1.5rem;"><?php _e('Tiefbau-Details entdecken', 'matmuja-tiefbau'); ?></a>
                </div>
            </div>
            <div class="col" style="display:flex;align-items:center;justify-content:center;">
                <div class="service-visual">
                    <?php
                    $s2_img_id = matmuja_get_option( 'matmuja_service_2_image' );
                    if ( $s2_img_id && $s2_img_html = wp_get_attachment_image( $s2_img_id, 'large', false, ['class' => 'service-svg', 'alt' => esc_attr__( 'Precision Engineering', 'matmuja-tiefbau' )] ) ) {
                        echo $s2_img_html;
                    } else {
                        echo '<img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/s2_tiefbau_mm.svg" alt="' . esc_attr__( 'Precision Engineering', 'matmuja-tiefbau' ) . '" class="service-svg">';
                    }
                    ?>
                </div>
            </div>
        </div>

        <div style="width:2px;height:80px;background:var(--color-primary);margin:0 auto;opacity:0.3;"></div>
        <div style="width:16px;height:16px;background:var(--color-accent);border-radius:50%;margin:0 auto;border:3px solid var(--color-primary);"></div>
        <div style="width:2px;height:80px;background:var(--color-primary);margin:0 auto;opacity:0.3;"></div>

        <?php // ─── Service Item 3: Kabelverlegung ─── ?>
        <div class="row" style="gap:4rem;margin-bottom:5rem;align-items:center;">
            <div class="col">
                <div class="timeline-content">
                    <span class="hero-eyebrow" style="color:var(--color-accent);"><?php _e('Phase 3', 'matmuja-tiefbau'); ?></span>
                    <h2><?php _e('Advanced Cable Deployment', 'matmuja-tiefbau'); ?></h2>
                    <p><?php _e('Die Kunst der präzisen Kabelverlegung bestimmt die Performance Ihres Netzwerks. Wir implementieren hochwertige Glasfaserkabel mit modernsten Verlegetechniken und automatisierten Qualitätssicherungssystemen.', 'matmuja-tiefbau'); ?></p>
                    <p><?php _e('Unsere zertifizierten Techniker garantieren eine perfekte Installation nach höchsten Standards, unterstützt durch Echtzeit-Monitoring und KI-basierte Qualitätskontrolle für langfristige Netzwerkzuverlässigkeit.', 'matmuja-tiefbau'); ?></p>
                    <a href="<?php echo esc_url(home_url('/dienstleistungen')); ?>" class="btn btn-outline" style="margin-top:1.5rem;"><?php _e('Kabeltechnologie erfahren', 'matmuja-tiefbau'); ?></a>
                </div>
            </div>
            <div class="col" style="display:flex;align-items:center;justify-content:center;">
                <div class="service-visual">
                    <?php
                    $s3_img_id = matmuja_get_option( 'matmuja_service_3_image' );
                    if ( $s3_img_id && $s3_img_html = wp_get_attachment_image( $s3_img_id, 'large', false, ['class' => 'service-svg', 'alt' => esc_attr__( 'Cable Deployment', 'matmuja-tiefbau' )] ) ) {
                        echo $s3_img_html;
                    } else {
                        echo '<img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/s3_kabelverlegung_mm.svg" alt="' . esc_attr__( 'Cable Deployment', 'matmuja-tiefbau' ) . '" class="service-svg">';
                    }
                    ?>
                </div>
            </div>
        </div>

        <div style="width:2px;height:80px;background:var(--color-primary);margin:0 auto;opacity:0.3;"></div>
        <div style="width:16px;height:16px;background:var(--color-accent);border-radius:50%;margin:0 auto;border:3px solid var(--color-primary);"></div>
        <div style="width:2px;height:80px;background:var(--color-primary);margin:0 auto;opacity:0.3;"></div>

        <?php // ─── Service Item 4: Spleißen ─── ?>
        <div class="row" style="gap:4rem;margin-bottom:5rem;align-items:center;flex-direction:row-reverse;">
            <div class="col">
                <div class="timeline-content">
                    <span class="hero-eyebrow" style="color:var(--color-accent);"><?php _e('Phase 4', 'matmuja-tiefbau'); ?></span>
                    <h2><?php _e('Fusion Splicing Excellence', 'matmuja-tiefbau'); ?></h2>
                    <p><?php _e('Präzision trifft Innovation: Unsere zertifizierten Spleißspezialisten verwenden KI-gestützte Fusionsspleißgeräte der neuesten Generation für perfekte Glasfaser-Verbindungen mit minimalen Signalverlusten.', 'matmuja-tiefbau'); ?></p>
                    <p><?php _e('Jeder Spleißpunkt wird mit fortschrittlichen OTDR-Messsystemen validiert, um unterbrechungsfreie Datenströme und optimale Netzwerkperformance zu garantieren.', 'matmuja-tiefbau'); ?></p>
                    <a href="<?php echo esc_url(home_url('/dienstleistungen')); ?>" class="btn btn-outline" style="margin-top:1.5rem;"><?php _e('Spleißtechnologie kennenlernen', 'matmuja-tiefbau'); ?></a>
                </div>
            </div>
            <div class="col" style="display:flex;align-items:center;justify-content:center;">
                <div class="service-visual">
                    <?php
                    $s4_img_id = matmuja_get_option( 'matmuja_service_4_image' );
                    if ( $s4_img_id && $s4_img_html = wp_get_attachment_image( $s4_img_id, 'large', false, ['class' => 'service-svg', 'alt' => esc_attr__( 'Fusion Splicing', 'matmuja-tiefbau' )] ) ) {
                        echo $s4_img_html;
                    } else {
                        echo '<img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/s4_spleissen_mm.svg" alt="' . esc_attr__( 'Fusion Splicing', 'matmuja-tiefbau' ) . '" class="service-svg">';
                    }
                    ?>
                </div>
            </div>
        </div>

        <div style="width:2px;height:80px;background:var(--color-primary);margin:0 auto;opacity:0.3;"></div>
        <div style="width:16px;height:16px;background:var(--color-accent);border-radius:50%;margin:0 auto;border:3px solid var(--color-primary);"></div>
        <div style="width:2px;height:80px;background:var(--color-primary);margin:0 auto;opacity:0.3;"></div>

        <?php // ─── Service Item 5: Hausanschluss ─── ?>
        <div class="row" style="gap:4rem;align-items:center;">
            <div class="col">
                <div class="timeline-content">
                    <span class="hero-eyebrow" style="color:var(--color-accent);"><?php _e('Phase 5', 'matmuja-tiefbau'); ?></span>
                    <h2><?php _e('Smart Home Connection & Activation', 'matmuja-tiefbau'); ?></h2>
                    <p><?php _e('Der finale Meilenstein: Die intelligente Hauseinführung mit modernsten ONT-Systemen und automatisierten Inbetriebnahme-Prozessen. Wir implementieren zukunftsfähige Anschlüsse mit IoT-Integration und Smart-Home-Kompatibilität.', 'matmuja-tiefbau'); ?></p>
                    <p><?php _e('Nach der Installation führen wir umfassende KI-gestützte Funktionstests durch und aktivieren Ihr Netzwerk mit Echtzeit-Monitoring — für eine garantierte Breitbandzukunft Ihrer Community.', 'matmuja-tiefbau'); ?></p>
                    <a href="<?php echo esc_url(home_url('/dienstleistungen')); ?>" class="btn btn-outline" style="margin-top:1.5rem;"><?php _e('Hauseinführung planen', 'matmuja-tiefbau'); ?></a>
                </div>
            </div>
            <div class="col" style="display:flex;align-items:center;justify-content:center;">
                <div class="service-visual">
                    <?php
                    $s5_img_id = matmuja_get_option( 'matmuja_service_5_image' );
                    if ( $s5_img_id && $s5_img_html = wp_get_attachment_image( $s5_img_id, 'large', false, ['class' => 'service-svg', 'alt' => esc_attr__( 'Smart Home Connection', 'matmuja-tiefbau' )] ) ) {
                        echo $s5_img_html;
                    } else {
                        echo '<img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/s5_hausanschluss_mm.svg" alt="' . esc_attr__( 'Smart Home Connection', 'matmuja-tiefbau' ) . '" class="service-svg">';
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
</section>

<?php // ═══════════════════════════════════════════════════
//  FULL-TURNKEY BLUE BANNER
// ═══════════════════════════════════════════════════ ?>
<section class="section-turnkey">
    <div class="container">
        <p class="turnkey-title">KOMPLETTE LÖSUNGEN</p>
        <p class="turnkey-subtitle"><?php _e('Next-Gen Glasfasernetze — Von Infrastruktur bis Konnektivität', 'matmuja-tiefbau'); ?></p>
    </div>
</section>

<?php // ═══════════════════════════════════════════════════
//  NEWS / BLOG SECTION
// ═══════════════════════════════════════════════════ ?>
<section class="section section-news">
    <div class="container">
        <h2 class="section-title text-center"><?php _e('Innovation & Insights', 'matmuja-tiefbau'); ?></h2>
        <p class="section-subtitle text-center">
            <?php _e('Entdecken Sie wegweisende Einblicke in die Zukunft der digitalen Infrastruktur und bleiben Sie über die neuesten Entwicklungen bei M&M EnerTech auf dem Laufenden.', 'matmuja-tiefbau'); ?>
        </p>

        <?php
        $recent_posts = new WP_Query([
            'posts_per_page' => 3,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);
        if ( $recent_posts->have_posts() ) : ?>
        <div class="news-grid">
            <?php while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>
            <article class="news-card">
                <?php if ( has_post_thumbnail() ) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('matmuja-card', ['class' => 'news-card-img', 'alt' => get_the_title()]); ?>
                    </a>
                <?php else : ?>
                    <div class="news-card-img-placeholder"></div>
                <?php endif; ?>
                <div class="news-card-body">
                    <?php
                    $cats = get_the_category();
                    if ( $cats ) : ?>
                    <span class="news-card-tag"><?php echo esc_html($cats[0]->name); ?></span>
                    <?php else : ?>
                    <span class="news-card-tag"><?php _e('Informationen', 'matmuja-tiefbau'); ?></span>
                    <?php endif; ?>
                    <h3 class="news-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p class="news-card-excerpt"><?php echo esc_html( matmuja_excerpt(18) ); ?></p>
                    <a href="<?php the_permalink(); ?>" class="news-card-link"><?php _e('Erfahren Sie mehr', 'matmuja-tiefbau'); ?></a>
                </div>
            </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <?php else : ?>
        <p class="text-center" style="color:var(--color-text-light);margin-top:2rem;"><?php _e('Bald verfügbar – schauen Sie bald wieder vorbei!', 'matmuja-tiefbau'); ?></p>
        <?php endif; ?>

        <div class="btn-center">
            <a href="<?php echo esc_url(home_url('/aktuelles')); ?>" class="btn btn-outline"><?php _e('Weitere Neuigkeiten', 'matmuja-tiefbau'); ?></a>
        </div>
    </div>
</section>

<?php // ═══════════════════════════════════════════════════
//  WHY US SECTION
// ═══════════════════════════════════════════════════ ?>
<section class="section section-why">
    <div class="container">
        <div class="why-grid">
            <div class="why-visual">
                <div class="why-badge">
                    <svg width="80" height="80" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="40" cy="40" r="38" fill="none" stroke="#f5a623" stroke-width="3"/>
                        <polygon points="40,10 47,28 68,28 51,40 58,58 40,46 22,58 29,40 12,28 33,28" fill="#f5a623"/>
                    </svg>
                    <p class="why-badge-title" style="margin-top:1rem;"><?php _e('Nr. 1', 'matmuja-tiefbau'); ?><br><?php _e('Glasfaser Tiefbau', 'matmuja-tiefbau'); ?></p>
                    <p class="why-badge-subtitle"><?php _e('Unternehmen in Deutschland', 'matmuja-tiefbau'); ?></p>
                </div>
            </div>
            <div>
                <h2><?php _e('Warum M&M EnerTech Ihr idealer Partner für die digitale Zukunft ist', 'matmuja-tiefbau'); ?></h2>
                <p style="color:var(--color-text-light);margin-top:1rem;"><?php _e('Unsere Expertise in der Verbindung von traditionellem Tiefbau-Know-how mit modernsten Technologien macht uns zum bevorzugten Partner für zukunftsweisende Infrastrukturprojekte.', 'matmuja-tiefbau'); ?></p>
                <p style="color:var(--color-text-light);"><?php _e('Durch den Einsatz von KI, IoT und nachhaltigen Methoden sichern wir Ihnen skalierbare, zukunftsfähige Lösungen und einen nahtlosen Projektablauf von der Vision zur Realität.', 'matmuja-tiefbau'); ?></p>
                <div class="why-features">
                    <?php
                    $features = [
                        __('KI-gestützte Planung und Optimierung für maximale Effizienz', 'matmuja-tiefbau'),
                        __('Nachgewiesene Zuverlässigkeit mit IoT-Monitoring in Echtzeit', 'matmuja-tiefbau'),
                        __('Deutschlandweite Skalierbarkeit für Mega-Infrastrukturprojekte', 'matmuja-tiefbau'),
                        __('Komplettes Ökosystem von Smart Planning bis Network Activation', 'matmuja-tiefbau'),
                        __('Zertifiziertes Expertenteam mit kontinuierlicher Weiterbildung', 'matmuja-tiefbau'),
                    ];
                    foreach ( $features as $i => $feature ) : ?>
                    <div class="why-feature">
                        <div class="why-feature-icon"><?php echo ($i+1); ?></div>
                        <span class="why-feature-text"><?php echo esc_html($feature); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php // ═══════════════════════════════════════════════════
//  FAQ SECTION
// ═══════════════════════════════════════════════════ ?>
<section class="section section-faq">
    <div class="container">
        <h2 class="text-center"><?php _e('Ihr Wissenscenter für moderne Infrastruktur', 'matmuja-tiefbau'); ?></h2>
        <p class="text-center" style="color:var(--color-text-light);max-width:600px;margin:0.75rem auto 0;">
            <?php _e('Hier beantworten wir Ihre wichtigsten Fragen zu innovativen Glasfaserlösungen und unseren fortschrittlichen Dienstleistungen im digitalen Tiefbau.', 'matmuja-tiefbau'); ?>
        </p>

        <div class="faq-list">
            <?php
            $faqs = [
                [
                    'q' => __('Wer ist der ideale Partner für moderne Glasfaser-Infrastruktur?', 'matmuja-tiefbau'),
                    'a' => __('Als spezialisierter Anbieter für intelligente Energie- und Tiefbaulösungen realisieren wir deutschlandweit zukunftsweisende Glasfasernetze für Netzbetreiber, Energieversorger und Kommunen. Unser Fokus liegt auf der Verbindung traditioneller Expertise mit KI-gestützten Innovationen.', 'matmuja-tiefbau'),
                ],
                [
                    'q' => __('Wie werden moderne Glasfasernetze implementiert?', 'matmuja-tiefbau'),
                    'a' => __('Wir kombinieren bewährte Tiefbaumethoden mit innovativen Technologien wie Microtrenching, HDD-Bohrungen und KI-gestützter Trassenoptimierung. Unser minimalinvasiver Ansatz schützt bestehende Infrastrukturen und ermöglicht nachhaltige, skalierbare Lösungen.', 'matmuja-tiefbau'),
                ],
                [
                    'q' => __('Wie bleibt die Kommunikation während des Projekts effizient?', 'matmuja-tiefbau'),
                    'a' => __('Wir setzen auf agile Kommunikationsstrukturen mit wöchentlichen Sprint-Reviews und digitalen Kollaborationsplattformen. Bei technischen Fragen steht Ihnen unser zertifiziertes Expertenteam jederzeit zur Verfügung, unterstützt durch IoT-Monitoring in Echtzeit.', 'matmuja-tiefbau'),
                ],
                [
                    'q' => __('Wie organisieren Sie komplexe Infrastrukturprojekte?', 'matmuja-tiefbau'),
                    'a' => __('Unser Projektmanagement basiert auf agilen Methoden mit Meilenstein-Tracking und KI-gestützter Ressourcenoptimierung. Alle Fortschritte werden in cloudbasierten Dashboards visualisiert, mit Integration von SharePoint und modernen Projektmanagement-Tools für maximale Transparenz.', 'matmuja-tiefbau'),
                ],
                [
                    'q' => __('Welche Qualitätsstandards garantieren Sie?', 'matmuja-tiefbau'),
                    'a' => __('Wir garantieren höchste Qualitätsstandards gemäß ZTV-Richtlinien und individuellen Vertragsvereinbarungen. Unsere Leistungen sind durch umfassende Zertifizierungen abgesichert, mit kontinuierlicher Qualitätssicherung durch automatisierte Testsysteme und regelmäßige Audits.', 'matmuja-tiefbau'),
                ],
            ];
            foreach ( $faqs as $faq ) : ?>
            <div class="faq-item">
                <button class="faq-question">
                    <?php echo esc_html($faq['q']); ?>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    <p><?php echo esc_html($faq['a']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php // ═══════════════════════════════════════════════════
//  CTA SECTION
// ═══════════════════════════════════════════════════ ?>
<section class="section section-cta">
    <div class="container">
        <div class="cta-box">
            <div class="cta-visual">
                <div class="cta-icon">
                    <svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg">
                        <rect x="8" y="10" width="44" height="34" rx="4" fill="white" opacity="0.9"/>
                        <path d="M8,44 L30,26 L52,44" fill="none" stroke="#f5a623" stroke-width="2"/>
                        <circle cx="48" cy="14" r="10" fill="#f5a623"/>
                        <text x="48" y="19" text-anchor="middle" fill="white" font-size="12" font-weight="bold">3</text>
                    </svg>
                </div>
            </div>
            <div class="cta-content">
                <h2><?php _e('Bereit für die digitale Zukunft?', 'matmuja-tiefbau'); ?> <strong><?php _e('Wir machen es möglich!', 'matmuja-tiefbau'); ?></strong></h2>
                <p><?php _e('Sie möchten Ihr Infrastrukturprojekt mit modernsten Technologien realisieren? Kontaktieren Sie unser Expertenteam für eine kostenlose Erstberatung und entdecken Sie, wie wir Ihre Vision in die Realität umsetzen.', 'matmuja-tiefbau'); ?></p>
                <a href="<?php echo esc_url(home_url('/kontakt')); ?>" class="btn btn-gold"><?php _e('Jetzt anfragen', 'matmuja-tiefbau'); ?></a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
