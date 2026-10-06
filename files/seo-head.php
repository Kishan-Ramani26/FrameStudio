<?php
/**
 * Frame Studio – SEO / GEO / AEO / LLM-SEO head include
 * Usage (top of every page, BEFORE including this file):
 *
 *   $seo = [
 *     'title'       => 'Web Design & Development Company in Rajkot | Frame Studio',
 *     'description' => '...150-160 chars...',
 *     'path'        => '/services/web-development',   // canonical path
 *     'type'        => 'service',                      // home|service|article|about|contact|page
 *     'image'       => '/assets/og/web-development.jpg',
 *     'breadcrumb'  => [['Home','/'],['Services','/services'],['Web Development','/services/web-development']],
 *     'faqs'        => [['Question?','Direct answer in 40-60 words.']],
 *     'answer'      => 'One-paragraph, 40-60 word direct answer to the page’s main question (also used for speakable).',
 *     'published'   => '2026-01-10', 'modified' => '2026-10-05',   // article only
 *     'noindex'     => false,
 *   ];
 *   include __DIR__.'/seo-head.php';
 */

/* ───────────── 1. SITE-WIDE CONFIG (edit once) ───────────── */
$SITE = [
  'name'        => 'Frame Studio',
  'legal_name'  => 'Frame Web Studio',
  'tagline'     => 'Design, Develop, Deliver.',
  'url'         => 'https://framestudio.in',
  'logo'        => '/assets/logo-512.png',          // square, min 112x112, ideally 512x512
  'default_og'  => '/images/frame-studio-og.jpg',
  'email'       => 'Framestudiomail@gmail.com',
  'phone'       => '+91-9510680017',
  'founding'    => '2025',
  'locale'      => 'en_IN',
  'lang'        => 'en-IN',
  'twitter'     => '@framestudio',
  'theme'       => '#00a8ff',
  'address'     => [                                // TODO: real address
      'street' => '307, Sardar Arcade, Rolex Road, Kothariya', 'city' => 'Rajkot', 'region' => 'Gujarat',
      'postal' => '360002', 'country' => 'IN',   // verify PIN on Google Maps
  ],
  'geo'         => ['lat' => 22.2740, 'lng' => 70.7770],   // APPROX – right-click your office on Google Maps, copy exact lat,lng
  'area_served' => ['India', 'United States', 'United Kingdom', 'United Arab Emirates', 'Canada', 'Australia'],
  'sameAs'      => [   // TODO: add ONLY real profile URLs (LinkedIn, Instagram, Behance, GitHub, Google Business Profile). Empty = omitted.
  ],
  'services'    => [                                // used in Organization → hasOfferCatalog
      ['Web Design',            'Custom UI/UX and website design for brands and startups.'],
      ['Web Development',       'Fast, secure, SEO-ready websites and web apps.'],
      ['Brand Identity',        'Logo, visual identity, typography and brand guidelines.'],
      ['SEO & Digital Growth',  'Technical SEO, GEO and AI-search optimisation.'],
  ],
  'knows_about' => ['Web design','Web development','UI/UX design','Brand identity','SEO','Generative Engine Optimization','PHP','React'],
];

/* ───────────── 2. HELPERS ───────────── */
$e   = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$abs = fn($p) => preg_match('#^https?://#i', $p) ? $p : $SITE['url'] . '/' . ltrim($p, '/');
$json = fn($d) => json_encode($d, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_PARTIAL_OUTPUT_ON_ERROR);

$seo       = $seo ?? [];
$type      = $seo['type']        ?? 'page';
$title     = $seo['title']       ?? ($page_title ?? $SITE['name']);
$desc      = $seo['description'] ?? ($page_description ?? '');
$path      = $seo['path']        ?? parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$canonical = $abs($path === '/' ? '/' : rtrim($path, '/'));
$ogImage   = $abs($seo['image']  ?? ($og_image ?? $SITE['default_og']));
$noindex   = !empty($seo['noindex']);
$robots    = $noindex
  ? 'noindex, nofollow'
  : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';
$orgId     = $SITE['url'] . '/#organization';
$siteId    = $SITE['url'] . '/#website';
$pageId    = $canonical . '#webpage';

/* ───────────── 3. JSON-LD @graph (single connected entity graph) ───────────── */
$graph = [];

// Organization + LocalBusiness (ProfessionalService) in one node
$graph[] = array_filter([
  '@type'        => ['Organization', 'ProfessionalService'],
  '@id'          => $orgId,
  'name'         => $SITE['name'],
  'legalName'    => $SITE['legal_name'],
  'alternateName'=> ['Frame Web Studio', 'FrameStudio', 'Frame Studio Rajkot'],
  'slogan'       => $SITE['tagline'],
  'description'  => 'Frame Studio (Frame Web Studio) is a design and development studio in Rajkot, Gujarat, India, serving clients across India and worldwide. It builds brand identities, websites and digital products. We design, develop and deliver.',
  'url'          => $SITE['url'] . '/',
  'logo'         => ['@type' => 'ImageObject', '@id' => $SITE['url'].'/#logo', 'url' => $abs($SITE['logo']), 'width' => 512, 'height' => 512],
  'image'        => $ogImage,
  'email'        => $SITE['email'],
  'telephone'    => $SITE['phone'],
  'foundingDate' => $SITE['founding'],
  'priceRange'   => '$$',
  'address'      => [
      '@type' => 'PostalAddress',
      'streetAddress'   => $SITE['address']['street'],
      'addressLocality' => $SITE['address']['city'],
      'addressRegion'   => $SITE['address']['region'],
      'postalCode'      => $SITE['address']['postal'],
      'addressCountry'  => $SITE['address']['country'],
  ],
  'geo'          => ['@type' => 'GeoCoordinates', 'latitude' => $SITE['geo']['lat'], 'longitude' => $SITE['geo']['lng']],
  'areaServed'   => array_map(fn($c) => ['@type' => 'Country', 'name' => $c], $SITE['area_served']),
  'knowsAbout'   => $SITE['knows_about'],
  'sameAs'       => $SITE['sameAs'],
  'contactPoint' => [[
      '@type' => 'ContactPoint', 'contactType' => 'sales', 'email' => $SITE['email'],
      'telephone' => $SITE['phone'], 'areaServed' => 'Worldwide',
      'availableLanguage' => ['English', 'Hindi', 'Gujarati'],
  ]],
  'hasOfferCatalog' => [
      '@type' => 'OfferCatalog', 'name' => 'Frame Studio Services',
      'itemListElement' => array_map(fn($s) => [
          '@type' => 'Offer',
          'itemOffered' => ['@type' => 'Service', 'name' => $s[0], 'description' => $s[1], 'provider' => ['@id' => $orgId]],
      ], $SITE['services']),
  ],
]);

// WebSite
$graph[] = [
  '@type' => 'WebSite', '@id' => $siteId, 'url' => $SITE['url'] . '/',
  'name' => $SITE['name'], 'description' => $SITE['tagline'],
  'inLanguage' => $SITE['lang'], 'publisher' => ['@id' => $orgId],
];

// WebPage (+ speakable for voice assistants / answer engines)
$pageTypeMap = ['about' => 'AboutPage', 'contact' => 'ContactPage', 'article' => 'WebPage'];
$webpage = [
  '@type' => $pageTypeMap[$type] ?? 'WebPage', '@id' => $pageId, 'url' => $canonical,
  'name' => $title, 'description' => $desc, 'inLanguage' => $SITE['lang'],
  'isPartOf' => ['@id' => $siteId], 'about' => ['@id' => $orgId],
  'primaryImageOfPage' => ['@type' => 'ImageObject', 'url' => $ogImage],
  'speakable' => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.answer-summary', '.faq-answer']],
];
if (!empty($seo['modified'])) $webpage['dateModified'] = $seo['modified'];
if (!empty($seo['published'])) $webpage['datePublished'] = $seo['published'];
if (!empty($seo['breadcrumb'])) $webpage['breadcrumb'] = ['@id' => $canonical . '#breadcrumb'];
$graph[] = $webpage;

// BreadcrumbList
if (!empty($seo['breadcrumb'])) {
  $i = 0;
  $graph[] = [
    '@type' => 'BreadcrumbList', '@id' => $canonical . '#breadcrumb',
    'itemListElement' => array_map(function ($b) use (&$i, $abs) {
        return ['@type' => 'ListItem', 'position' => ++$i, 'name' => $b[0], 'item' => $abs($b[1])];
    }, $seo['breadcrumb']),
  ];
}

// Service page
if ($type === 'service') {
  $graph[] = [
    '@type' => 'Service', '@id' => $canonical . '#service',
    'name' => $seo['service_name'] ?? $title, 'description' => $desc,
    'serviceType' => $seo['service_name'] ?? $title,
    'provider' => ['@id' => $orgId],
    'areaServed' => array_map(fn($c) => ['@type' => 'Country', 'name' => $c], $SITE['area_served']),
    'url' => $canonical,
  ];
}

// Article / blog post
if ($type === 'article') {
  $graph[] = [
    '@type' => 'Article', '@id' => $canonical . '#article',
    'headline' => mb_substr($title, 0, 110), 'description' => $desc,
    'image' => [$ogImage], 'mainEntityOfPage' => ['@id' => $pageId],
    'datePublished' => $seo['published'] ?? null, 'dateModified' => $seo['modified'] ?? ($seo['published'] ?? null),
    'author' => ['@type' => 'Person', 'name' => $seo['author'] ?? 'Frame Studio Team', 'url' => $abs($seo['author_url'] ?? '/about')],
    'publisher' => ['@id' => $orgId], 'inLanguage' => $SITE['lang'],
  ];
}

// FAQPage (strong for AEO / LLM extraction; Google no longer shows FAQ rich results for most sites, but AI engines still use it)
if (!empty($seo['faqs'])) {
  $graph[] = [
    '@type' => 'FAQPage', '@id' => $canonical . '#faq', 'mainEntityOfPage' => ['@id' => $pageId],
    'mainEntity' => array_map(fn($f) => [
        '@type' => 'Question', 'name' => $f[0],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
    ], $seo['faqs']),
  ];
}

// HowTo (optional) – $seo['howto'] = ['name'=>..., 'steps'=>[['Step name','Step text'],…]]
if (!empty($seo['howto'])) {
  $graph[] = [
    '@type' => 'HowTo', 'name' => $seo['howto']['name'],
    'step' => array_map(fn($s, $n) => ['@type' => 'HowToStep', 'position' => $n + 1, 'name' => $s[0], 'text' => $s[1]],
              $seo['howto']['steps'], array_keys($seo['howto']['steps'])),
  ];
}

$jsonld = ['@context' => 'https://schema.org', '@graph' => array_values(array_filter($graph))];
?>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
<meta name="color-scheme" content="light" />

<!-- Primary -->
<title><?= $e($title) ?></title>
<meta name="description" content="<?= $e($desc) ?>" />
<meta name="author" content="<?= $e($SITE['name']) ?>" />
<meta name="publisher" content="<?= $e($SITE['name']) ?>" />
<meta name="robots" content="<?= $e($robots) ?>" />
<meta name="googlebot" content="<?= $e($robots) ?>" />
<meta name="bingbot" content="<?= $e($robots) ?>" />
<link rel="canonical" href="<?= $e($canonical) ?>" />
<link rel="alternate" hreflang="<?= $e($SITE['lang']) ?>" href="<?= $e($canonical) ?>" />
<link rel="alternate" hreflang="x-default" href="<?= $e($canonical) ?>" />

<!-- Open Graph -->
<meta property="og:type" content="<?= $type === 'article' ? 'article' : 'website' ?>" />
<meta property="og:url" content="<?= $e($canonical) ?>" />
<meta property="og:title" content="<?= $e($title) ?>" />
<meta property="og:description" content="<?= $e($desc) ?>" />
<meta property="og:image" content="<?= $e($ogImage) ?>" />
<meta property="og:image:secure_url" content="<?= $e($ogImage) ?>" />
<meta property="og:image:type" content="image/jpeg" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:image:alt" content="<?= $e($seo['image_alt'] ?? $title) ?>" />
<meta property="og:site_name" content="<?= $e($SITE['name']) ?>" />
<meta property="og:locale" content="<?= $e($SITE['locale']) ?>" />
<?php if ($type === 'article' && !empty($seo['published'])): ?>
<meta property="article:published_time" content="<?= $e($seo['published']) ?>" />
<meta property="article:modified_time" content="<?= $e($seo['modified'] ?? $seo['published']) ?>" />
<meta property="article:author" content="<?= $e($seo['author'] ?? $SITE['name']) ?>" />
<?php endif; ?>

<!-- Twitter / X -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="<?= $e($SITE['twitter']) ?>" />
<meta name="twitter:creator" content="<?= $e($SITE['twitter']) ?>" />
<meta name="twitter:title" content="<?= $e($title) ?>" />
<meta name="twitter:description" content="<?= $e($desc) ?>" />
<meta name="twitter:image" content="<?= $e($ogImage) ?>" />
<meta name="twitter:image:alt" content="<?= $e($seo['image_alt'] ?? $title) ?>" />

<!-- Branding / PWA -->
<meta name="theme-color" content="<?= $e($SITE['theme']) ?>" />
<meta name="msapplication-TileColor" content="<?= $e($SITE['theme']) ?>" />
<meta name="format-detection" content="telephone=no" />
<meta name="application-name" content="<?= $e($SITE['name']) ?>" />
<meta name="apple-mobile-web-app-title" content="<?= $e($SITE['name']) ?>" />
<link rel="icon" href="/favicon.ico" sizes="any" />
<link rel="icon" type="image/svg+xml" href="/favicon.svg" />
<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
<link rel="manifest" href="/site.webmanifest" />

<!-- Local / Geo (Bing + secondary signals; Google relies on schema + Business Profile) -->
<meta name="geo.region" content="IN-GJ" />
<meta name="geo.placename" content="<?= $e($SITE['address']['city']) ?>" />
<meta name="geo.position" content="<?= $e($SITE['geo']['lat'] . ';' . $SITE['geo']['lng']) ?>" />
<meta name="ICBM" content="<?= $e($SITE['geo']['lat'] . ', ' . $SITE['geo']['lng']) ?>" />

<!-- Discovery for crawlers & LLMs -->
<link rel="sitemap" type="application/xml" title="Sitemap" href="/sitemap.xml" />
<link rel="alternate" type="text/plain" title="LLMs.txt" href="/llms.txt" />
<link rel="alternate" type="text/plain" title="LLMs full content" href="/llms-full.txt" />
<?php if (!empty($seo['markdown_url'])): ?>
<link rel="alternate" type="text/markdown" href="<?= $e($abs($seo['markdown_url'])) ?>" />
<?php endif; ?>
<meta name="ai-content-declaration" content="human-authored" />

<!-- Performance hints -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link rel="dns-prefetch" href="https://www.googletagmanager.com" />

<!-- Structured data: one connected entity graph -->
<script type="application/ld+json"><?= $json($jsonld) ?></script>
