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
            <span class="hero-eyebrow"><?php echo esc_html( matmuja_get_option('matmuja_hero_eyebrow', 'Die Komplettlösung für Glasfaser') ); ?></span>
            <h1 class="hero-title"><?php echo nl2br( esc_html( matmuja_get_option('matmuja_hero_title', "Das Tiefbauunternehmen\nfür ihr Glasfaserprojekt") ) ); ?></h1>
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
                <?php $intro_img = get_posts(['post_type'=>'attachment','posts_per_page'=>1,'orderby'=>'menu_order','meta_key'=>'_matmuja_intro_image']); ?>
                <div style="border-radius:16px;overflow:hidden;background:rgba(25,25,122,0.1);min-height:320px;display:flex;align-items:center;justify-content:center;">
                    <svg viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg" style="width:80%;opacity:0.7">
                        <rect x="100" y="180" width="200" height="80" rx="8" fill="#19197a" opacity="0.6"/>
                        <circle cx="200" cy="130" r="80" fill="none" stroke="#19197a" stroke-width="8" opacity="0.5"/>
                        <circle cx="200" cy="130" r="55" fill="none" stroke="#f5a623" stroke-width="6" opacity="0.7"/>
                        <circle cx="200" cy="130" r="30" fill="#f5a623" opacity="0.5"/>
                    </svg>
                </div>
            </div>
            <div class="col col-2 intro-text">
                <p><strong><?php _e('Als erfahrenes Tiefbauunternehmen mit Spezialisierung auf den Ausbau von Glasfaser unterstützen wir Netzbetreiber, Energieversorger und Stadtwerke in ganz Deutschland', 'matmuja-tiefbau'); ?></strong> <?php _e('dabei, leistungsstarke Breitbandnetze effizient und zuverlässig zu realisieren. Mit einem Team aus erfahrenen Spezialisten und modernster Technik garantieren wir eine reibungslose Projektabwicklung – von der ersten Planung bis zur vollständigen Inbetriebnahme.', 'matmuja-tiefbau'); ?></p>
                <p><strong><?php _e('Setzen Sie auf uns als Partner, der Qualität, Effizienz und Budgettreue vereint', 'matmuja-tiefbau'); ?></strong> <?php _e('und damit die Grundlage für eine erfolgreiche digitale Infrastruktur schaffen kann.', 'matmuja-tiefbau'); ?></p>
                <a href="<?php echo esc_url(home_url('/kontakt')); ?>" class="btn btn-primary" style="margin-top:1.5rem;">
                    <?php _e('Kostenlose Beratung', 'matmuja-tiefbau'); ?>
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
                    <h2><?php _e('Projektplanung', 'matmuja-tiefbau'); ?></h2>
                    <p><?php _e('Eine erfolgreiche Glasfaserinfrastruktur beginnt mit einer präzisen und umfassenden Planung. Unser Team analysiert die Anforderungen des Projekts und berücksichtigt sowohl technische als auch geografische Besonderheiten.', 'matmuja-tiefbau'); ?></p>
                    <p><?php _e('Von der Trassenauswahl über die Adressvalidierung bis zur Genehmigungsplanung: Wir setzen auf eine detaillierte Vorplanung, die alle Aspekte der späteren Umsetzung berücksichtigt.', 'matmuja-tiefbau'); ?></p>
                    <a href="<?php echo esc_url(home_url('/kontakt')); ?>" class="btn btn-outline" style="margin-top:1.5rem;"><?php _e('Ihre Planung anfragen', 'matmuja-tiefbau'); ?></a>
                </div>
            </div>
            <div class="col" style="display:flex;align-items:center;justify-content:center;">
                <div class="service-visual">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/s1_projektplanung_mm.svg" alt="<?php _e('Projektplanung', 'matmuja-tiefbau'); ?>" class="service-svg">
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
                    <h2><?php _e('Tiefbau', 'matmuja-tiefbau'); ?></h2>
                    <p><?php _e('In der Ausbauphase setzen wir auf modernste Technik und bewährte Methoden, um Glasfaserleitungen sicher und effizient zu verlegen. Unsere erfahrenen Fachleute gewährleisten eine saubere, termingerechte Ausführung.', 'matmuja-tiefbau'); ?></p>
                    <p><strong><?php _e('Vom Bodenaufbruch bis zur Trassenherstellung', 'matmuja-tiefbau'); ?></strong> <?php _e('– mit minimalinvasivem Ansatz, der bestehende Infrastrukturen schützt.', 'matmuja-tiefbau'); ?></p>
                    <a href="<?php echo esc_url(home_url('/dienstleistungen')); ?>" class="btn btn-outline" style="margin-top:1.5rem;"><?php _e('Mehr zum Tiefbau', 'matmuja-tiefbau'); ?></a>
                </div>
            </div>
            <div class="col" style="display:flex;align-items:center;justify-content:center;">
                <div class="service-visual">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/s2_tiefbau_mm.svg" alt="<?php _e('Tiefbau', 'matmuja-tiefbau'); ?>" class="service-svg">
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
                    <h2><?php _e('Kabelverlegung', 'matmuja-tiefbau'); ?></h2>
                    <p><?php _e('Die professionelle Verlegung der Glasfaserkabel ist ein entscheidender Schritt für die Qualität und Langlebigkeit Ihres Netzwerks. Wir verwenden hochwertige Materialien und modernste Verlegetechniken.', 'matmuja-tiefbau'); ?></p>
                    <p><?php _e('Unsere zertifizierten Techniker sorgen für eine präzise Installation, die höchsten Standards entspricht und langfristige Zuverlässigkeit gewährleistet.', 'matmuja-tiefbau'); ?></p>
                    <a href="<?php echo esc_url(home_url('/dienstleistungen')); ?>" class="btn btn-outline" style="margin-top:1.5rem;"><?php _e('Mehr zur Kabelverlegung', 'matmuja-tiefbau'); ?></a>
                </div>
            </div>
            <div class="col" style="display:flex;align-items:center;justify-content:center;">
                <div class="service-visual">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/s3_kabelverlegung_mm.svg" alt="<?php _e('Kabelverlegung', 'matmuja-tiefbau'); ?>" class="service-svg">
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
                    <h2><?php _e('Spleißen & Verbindung', 'matmuja-tiefbau'); ?></h2>
                    <p><?php _e('Das präzise Spleißen der Glasfaserkabel ist eine Kunst, die höchste Präzision und Fachkenntnis erfordert. Unsere zertifizierten Spleißtechniker verwenden modernste Fusionsspleißgeräte.', 'matmuja-tiefbau'); ?></p>
                    <p><?php _e('Jeder Spleiß wird auf optimale Lichtdurchlässigkeit und Signalqualität getestet, um eine unterbrechungsfreie Datenübertragung zu gewährleisten.', 'matmuja-tiefbau'); ?></p>
                    <a href="<?php echo esc_url(home_url('/dienstleistungen')); ?>" class="btn btn-outline" style="margin-top:1.5rem;"><?php _e('Mehr zum Spleißen', 'matmuja-tiefbau'); ?></a>
                </div>
            </div>
            <div class="col" style="display:flex;align-items:center;justify-content:center;">
                <div class="service-visual">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/s4_spleissen_mm.svg" alt="<?php _e('Spleißen', 'matmuja-tiefbau'); ?>" class="service-svg">
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
                    <h2><?php _e('Hausanschluss & Inbetriebnahme', 'matmuja-tiefbau'); ?></h2>
                    <p><?php _e('Der finale Schritt: Die Hauseinführung und vollständige Inbetriebnahme des Glasfasernetzes. Wir installieren alle notwendigen Komponenten wie HÜP (Hauseinführungsspunkt) und ONT (Optical Network Terminal).', 'matmuja-tiefbau'); ?></p>
                    <p><?php _e('Nach der Installation führen wir umfassende Funktionstests durch und nehmen das Netzwerk offiziell in Betrieb – für eine zuverlässige Breitbandversorgung.', 'matmuja-tiefbau'); ?></p>
                    <a href="<?php echo esc_url(home_url('/dienstleistungen')); ?>" class="btn btn-outline" style="margin-top:1.5rem;"><?php _e('Mehr zur Hauseinführung', 'matmuja-tiefbau'); ?></a>
                </div>
            </div>
            <div class="col" style="display:flex;align-items:center;justify-content:center;">
                <div class="service-visual">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/s5_hausanschluss_mm.svg" alt="<?php _e('Hausanschluss', 'matmuja-tiefbau'); ?>" class="service-svg">
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
        <h2 class="section-title text-center"><?php _e('Aktuelle Neuigkeiten', 'matmuja-tiefbau'); ?></h2>
        <p class="section-subtitle text-center">
            <?php _e('Entdecken Sie in unserem Blog spannende Einblicke in den Glasfaserausbau und bleiben Sie stets über aktuelle Entwicklungen und Neuigkeiten bei M&M EnerTech informiert.', 'matmuja-tiefbau'); ?>
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
                <h2><?php _e('Warum sind wir die richtige Firma für Ihr Glasfaser Projekt?', 'matmuja-tiefbau'); ?></h2>
                <p style="color:var(--color-text-light);margin-top:1rem;"><?php _e('Unsere langjährige Erfahrung und hohe Spezialisierung im Glasfaser-Tiefbau machen uns zu einem zuverlässigen Partner für anspruchsvolle Projekte im Bereich der digitalen Infrastruktur.', 'matmuja-tiefbau'); ?></p>
                <p style="color:var(--color-text-light);"><?php _e('Durch den Einsatz moderner Technologien und eines eingespielten Teams sichern wir Ihnen eine nachhaltige, zukunftsfähige Lösung und einen reibungslosen Projektablauf.', 'matmuja-tiefbau'); ?></p>
                <div class="why-features">
                    <?php
                    $features = [
                        __('Langjährige Erfahrung im Glasfaser-Tiefbau', 'matmuja-tiefbau'),
                        __('Nachgewiesene Zuverlässigkeit und Termintreue', 'matmuja-tiefbau'),
                        __('Deutschlandweite Verfügbarkeit für Glasfaser-Projekte', 'matmuja-tiefbau'),
                        __('Komplettes Leistungsspektrum des Glasfaserausbaus', 'matmuja-tiefbau'),
                        __('Eingespieltes und qualifiziertes Montage-Team', 'matmuja-tiefbau'),
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
        <h2 class="text-center"><?php _e('Häufig gestellte Fragen', 'matmuja-tiefbau'); ?></h2>
        <p class="text-center" style="color:var(--color-text-light);max-width:600px;margin:0.75rem auto 0;">
            <?php _e('Hier beantworten wir häufige Fragen rund um den Glasfaserausbau und unsere speziellen Leistungen im Tiefbau.', 'matmuja-tiefbau'); ?>
        </p>

        <div class="faq-list">
            <?php
            $faqs = [
                [
                    'q' => __('Welches Unternehmen baut Glasfaser aus?', 'matmuja-tiefbau'),
                    'a' => __('Den Ausbau von Glasfaserinfrastrukturen übernehmen in der Regel auf Glasfaser spezialisierte Tiefbauunternehmen. Unsere Firma ist darauf spezialisiert, deutschlandweit Glasfasernetze für Netzbetreiber, Energieversorger und Kommunen zu planen und umzusetzen.', 'matmuja-tiefbau'),
                ],
                [
                    'q' => __('Wie wird Glasfaser verlegt?', 'matmuja-tiefbau'),
                    'a' => __('Die Verlegung von Glasfaserleitungen erfolgt durch Tiefbau-Methoden wie offene Grabenbauweise oder innovativere Verfahren wie Microtrenching und Spülbohrtechnik, die eine minimalinvasive Installation ermöglichen.', 'matmuja-tiefbau'),
                ],
                [
                    'q' => __('Gibt es einen direkten Ansprechpartner während des Projekts?', 'matmuja-tiefbau'),
                    'a' => __('Für regelmäßige Abstimmungen setzen wir auf wöchentliche Jour-Fixe-Termine. Bei allgemeinen Kundenanliegen können Sie sich jederzeit an unseren Kundensupport wenden. Für bautechnische Fragen ist unser Bauleiter Ihr direkter Ansprechpartner.', 'matmuja-tiefbau'),
                ],
                [
                    'q' => __('Wie wird das Projektmanagement organisiert?', 'matmuja-tiefbau'),
                    'a' => __('Unser Projektmanagement basiert auf einer strukturierten Meilensteinplanung. Alle Fortschritte werden in einem detaillierten Bauzeitenplan dokumentiert. Zur Dokumentation setzen wir auf eine cloudbasierte Lösung über SharePoint und DeepUp.', 'matmuja-tiefbau'),
                ],
                [
                    'q' => __('Gibt es Garantien auf die durchgeführten Arbeiten?', 'matmuja-tiefbau'),
                    'a' => __('Ja, auf alle von uns ausgeführten Arbeiten gelten die gesetzlichen Gewährleistungsbestimmungen gemäß den Vorgaben der ZTV sowie die individuellen Regelungen des jeweiligen Vertragswerks.', 'matmuja-tiefbau'),
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
                <h2><?php _e('Sie haben weitere Fragen?', 'matmuja-tiefbau'); ?> <strong><?php _e('Wir freuen uns auf Ihr Anliegen!', 'matmuja-tiefbau'); ?></strong></h2>
                <p><?php _e('Sie möchten einen ersten Kontakt aufnehmen und prüfen, ob Ihr Vorhaben von uns realisierbar ist? Dann sprechen Sie uns gerne an.', 'matmuja-tiefbau'); ?></p>
                <a href="<?php echo esc_url(home_url('/kontakt')); ?>" class="btn btn-gold"><?php _e('Kontaktieren Sie uns', 'matmuja-tiefbau'); ?></a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
