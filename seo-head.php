<?php
/**
 * Frame Studio – Master SEO / GEO / AEO / LLM-SEO Head Include
 * Builds unified Schema.org JSON-LD graph, Open Graph, Twitter Cards,
 * AI crawler discovery, Geo/Local signals, and Speakable markup.
 */

/* ───────────── 1. SITE-WIDE CONFIG ───────────── */
$SITE = [
  'name'        => 'Frame Studio',
  'legal_name'  => 'Frame Web Studio',
  'tagline'     => 'Design, Develop, Deliver.',
  'url'         => 'https://framestudio.in',
  'logo'        => '/images/Frame-Studio Logo.png',
  'default_og'  => '/images/frame-studio-og.jpg',
  'email'       => 'Framestudiomail@gmail.com',
  'phone'       => '+91-9510680017',
  'founding'    => '2025',
  'locale'      => 'en_IN',
  'lang'        => 'en-IN',
  'twitter'     => '@framestudio',
  'theme'       => '#00a8ff',
  'address'     => [
      'street'  => '307, Sardar Arcade, Rolex Road, Kothariya',
      'city'    => 'Rajkot',
      'region'  => 'Gujarat',
      'postal'  => '360002',
      'country' => 'IN',
  ],
  'geo'         => ['lat' => 22.2740, 'lng' => 70.7770],
  'area_served' => ['India', 'United States', 'United Kingdom', 'United Arab Emirates', 'Canada', 'Australia'],
  'sameAs'      => [
      'https://www.instagram.com/framestudio_in/',
      'https://www.linkedin.com/company/frame-studio25/',
  ],
  'services'    => [
      ['Shopify Development',   'High-converting, bespoke Shopify eCommerce stores with custom Liquid themes and app integrations.'],
      ['WordPress Development', 'Custom, lightweight WordPress theme engineering and headless CMS solutions.'],
      ['PHP & Web Development', 'Fast, secure, scalable custom PHP web applications and business systems.'],
      ['eCommerce Development', 'Full-funnel online stores with seamless payment gateways, inventory sync and checkout optimization.'],
      ['Technical SEO & Growth','Technical SEO audits, Core Web Vitals engineering, structured schema graph, and GEO AI-search optimization.'],
      ['Website Maintenance',   'Reliable 24/7 uptime monitoring, security updates, regular backups, and continuous speed optimization.'],
  ],
  'knows_about' => ['Web design', 'Web development', 'UI/UX design', 'Shopify development', 'WordPress development', 'PHP development', 'eCommerce development', 'Technical SEO', 'Generative Engine Optimization (GEO)', 'Core Web Vitals'],
];

/* ───────────── 2. HELPERS ───────────── */
$e    = $e    ?? fn($v) => htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$abs  = $abs  ?? fn($p) => preg_match('#^https?://#i', $p) ? $p : $SITE['url'] . '/' . ltrim($p, '/');
$json = $json ?? fn($d) => json_encode($d, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_PARTIAL_OUTPUT_ON_ERROR);

$seo       = $seo ?? [];
$type      = $seo['type']        ?? 'page';
$title     = $seo['title']       ?? ($page_title ?? $SITE['name'] . ' | Premium Web Agency');
$desc      = $seo['description'] ?? ($page_description ?? '');
$keywords  = $seo['keywords']    ?? ($page_keywords ?? '');
$path      = $seo['path']        ?? (!empty($canonical_url) ? parse_url($canonical_url, PHP_URL_PATH) : parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH));
$canonical = !empty($canonical_url) ? $canonical_url : $abs($path === '/' ? '/' : rtrim($path, '/'));
$ogImage   = $abs($seo['image']  ?? ($og_image ?? $SITE['default_og']));
$noindex   = !empty($seo['noindex']);
$robots    = $noindex
  ? 'noindex, nofollow'
  : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';
$orgId     = $SITE['url'] . '/#organization';
$siteId    = $SITE['url'] . '/#website';
$pageId    = $canonical . '#webpage';

/* ───────────── 3. JSON-LD @graph (Single Connected Entity Graph) ───────────── */
$graph = [];

// Organization + LocalBusiness (ProfessionalService)
$graph[] = array_filter([
  '@type'        => ['Organization', 'ProfessionalService'],
  '@id'          => $orgId,
  'name'         => $SITE['name'],
  'legalName'    => $SITE['legal_name'],
  'alternateName'=> ['Frame Web Studio', 'FrameStudio', 'Frame Studio Rajkot'],
  'slogan'       => $SITE['tagline'],
  'description'  => 'Frame Studio is a premier web design and development agency based in Rajkot, Gujarat, India, delivering custom websites, Shopify stores, and digital solutions for brands in India and worldwide.',
  'url'          => $SITE['url'] . '/',
  'logo'         => [
      '@type' => 'ImageObject',
      '@id'   => $SITE['url'] . '/#logo',
      'url'   => $abs($SITE['logo']),
  ],
  'image'        => $ogImage,
  'email'        => $SITE['email'],
  'telephone'    => $SITE['phone'],
  'foundingDate' => $SITE['founding'],
  'priceRange'   => '$$',
  'address'      => [
      '@type'           => 'PostalAddress',
      'streetAddress'   => $SITE['address']['street'],
      'addressLocality' => $SITE['address']['city'],
      'addressRegion'   => $SITE['address']['region'],
      'postalCode'      => $SITE['address']['postal'],
      'addressCountry'  => $SITE['address']['country'],
  ],
  'geo'          => [
      '@type'     => 'GeoCoordinates',
      'latitude'  => $SITE['geo']['lat'],
      'longitude' => $SITE['geo']['lng'],
  ],
  'areaServed'   => array_map(fn($c) => ['@type' => 'Country', 'name' => $c], $SITE['area_served']),
  'knowsAbout'   => $SITE['knows_about'],
  'sameAs'       => $SITE['sameAs'],
  'contactPoint' => [[
      '@type'             => 'ContactPoint',
      'contactType'       => 'customer service',
      'email'             => $SITE['email'],
      'telephone'         => $SITE['phone'],
      'areaServed'        => 'Worldwide',
      'availableLanguage' => ['English', 'Hindi', 'Gujarati'],
  ]],
  'hasOfferCatalog' => [
      '@type'            => 'OfferCatalog',
      'name'             => 'Frame Studio Services',
      'itemListElement'  => array_map(fn($s) => [
          '@type'       => 'Offer',
          'itemOffered' => ['@type' => 'Service', 'name' => $s[0], 'description' => $s[1], 'provider' => ['@id' => $orgId]],
      ], $SITE['services']),
  ],
]);

// WebSite
$graph[] = [
  '@type'       => 'WebSite',
  '@id'         => $siteId,
  'url'         => $SITE['url'] . '/',
  'name'        => $SITE['name'],
  'description' => $SITE['tagline'],
  'inLanguage'  => $SITE['lang'],
  'publisher'   => ['@id' => $orgId],
];

// WebPage (+ Speakable for Voice & AI Answer Engines)
$pageTypeMap = ['about' => 'AboutPage', 'contact' => 'ContactPage', 'article' => 'WebPage'];
$webpage = [
  '@type'              => $pageTypeMap[$type] ?? 'WebPage',
  '@id'                => $pageId,
  'url'                => $canonical,
  'name'               => $title,
  'description'        => $desc,
  'inLanguage'         => $SITE['lang'],
  'isPartOf'           => ['@id' => $siteId],
  'about'              => ['@id' => $orgId],
  'primaryImageOfPage' => ['@type' => 'ImageObject', 'url' => $ogImage],
  'speakable'          => [
      '@type'       => 'SpeakableSpecification',
      'cssSelector' => ['h1', '.answer-summary', '.faq-answer', '.paragraph-03'],
  ],
];
if (!empty($seo['modified']))  $webpage['dateModified']  = $seo['modified'];
if (!empty($seo['published'])) $webpage['datePublished'] = $seo['published'];
if (!empty($seo['breadcrumb'])) $webpage['breadcrumb']   = ['@id' => $canonical . '#breadcrumb'];
$graph[] = $webpage;

// BreadcrumbList
if (!empty($seo['breadcrumb'])) {
  $i = 0;
  $graph[] = [
    '@type'           => 'BreadcrumbList',
    '@id'             => $canonical . '#breadcrumb',
    'itemListElement' => array_map(function ($b) use (&$i, $abs) {
        return ['@type' => 'ListItem', 'position' => ++$i, 'name' => $b[0], 'item' => $abs($b[1])];
    }, $seo['breadcrumb']),
  ];
}

// Service Node (if page is a service page)
if ($type === 'service') {
  $graph[] = [
    '@type'       => 'Service',
    '@id'         => $canonical . '#service',
    'name'        => $seo['service_name'] ?? $title,
    'description' => $desc,
    'serviceType' => $seo['service_name'] ?? $title,
    'provider'    => ['@id' => $orgId],
    'areaServed'  => array_map(fn($c) => ['@type' => 'Country', 'name' => $c], $SITE['area_served']),
    'url'         => $canonical,
  ];
}

// Article Node (if page is a blog post)
if ($type === 'article') {
  $graph[] = [
    '@type'           => 'Article',
    '@id'             => $canonical . '#article',
    'headline'        => mb_substr($title, 0, 110),
    'description'     => $desc,
    'image'           => [$ogImage],
    'mainEntityOfPage'=> ['@id' => $pageId],
    'datePublished'   => $seo['published'] ?? null,
    'dateModified'    => $seo['modified']  ?? ($seo['published'] ?? null),
    'author'          => [
        '@type' => 'Person',
        'name'  => $seo['author'] ?? 'Kishan Ramani',
        'url'   => $abs($seo['author_url'] ?? '/about'),
    ],
    'publisher'       => ['@id' => $orgId],
    'inLanguage'      => $SITE['lang'],
  ];
}

// FAQPage Schema
if (!empty($seo['faqs'])) {
  $graph[] = [
    '@type'            => 'FAQPage',
    '@id'              => $canonical . '#faq',
    'mainEntityOfPage' => ['@id' => $pageId],
    'mainEntity'       => array_map(fn($f) => [
        '@type'          => 'Question',
        'name'           => $f[0],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
    ], $seo['faqs']),
  ];
}

// HowTo Schema
if (!empty($seo['howto'])) {
  $graph[] = [
    '@type' => 'HowTo',
    'name'  => $seo['howto']['name'],
    'step'  => array_map(fn($s, $n) => ['@type' => 'HowToStep', 'position' => $n + 1, 'name' => $s[0], 'text' => $s[1]],
              $seo['howto']['steps'], array_keys($seo['howto']['steps'])),
  ];
}

$jsonld = ['@context' => 'https://schema.org', '@graph' => array_values(array_filter($graph))];
?>
<!-- Character Encoding & Viewport -->
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
<meta name="color-scheme" content="dark light" />

<!-- Primary Search Meta Tags -->
<title><?= $e($title) ?></title>
<meta name="title" content="<?= $e($title) ?>" />
<meta name="description" content="<?= $e($desc) ?>" />
<?php if (!empty($keywords)): ?>
<meta name="keywords" content="<?= $e($keywords) ?>" />
<?php endif; ?>
<meta name="author" content="<?= $e($SITE['name']) ?>" />
<meta name="publisher" content="<?= $e($SITE['name']) ?>" />
<meta name="robots" content="<?= $e($robots) ?>" />
<meta name="googlebot" content="<?= $e($robots) ?>" />
<meta name="bingbot" content="<?= $e($robots) ?>" />
<link rel="canonical" href="<?= $e($canonical) ?>" />
<link rel="alternate" hreflang="<?= $e($SITE['lang']) ?>" href="<?= $e($canonical) ?>" />
<link rel="alternate" hreflang="x-default" href="<?= $e($canonical) ?>" />

<!-- Open Graph / Social Media -->
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

<!-- Twitter / X Cards -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="<?= $e($SITE['twitter']) ?>" />
<meta name="twitter:creator" content="<?= $e($SITE['twitter']) ?>" />
<meta name="twitter:title" content="<?= $e($title) ?>" />
<meta name="twitter:description" content="<?= $e($desc) ?>" />
<meta name="twitter:image" content="<?= $e($ogImage) ?>" />
<meta name="twitter:image:alt" content="<?= $e($seo['image_alt'] ?? $title) ?>" />

<!-- Theme & PWA -->
<meta name="theme-color" content="<?= $e($SITE['theme']) ?>" />
<meta name="msapplication-TileColor" content="<?= $e($SITE['theme']) ?>" />
<meta name="format-detection" content="telephone=no" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="application-name" content="<?= $e($SITE['name']) ?>" />
<meta name="apple-mobile-web-app-title" content="<?= $e($SITE['name']) ?>" />

<!-- Local & Geo Signals (Rajkot, Gujarat, India) -->
<meta name="geo.region" content="IN-GJ" />
<meta name="geo.placename" content="<?= $e($SITE['address']['city']) ?>" />
<meta name="geo.position" content="<?= $e($SITE['geo']['lat'] . ';' . $SITE['geo']['lng']) ?>" />
<meta name="ICBM" content="<?= $e($SITE['geo']['lat'] . ', ' . $SITE['geo']['lng']) ?>" />

<!-- AI Search & LLM Discovery (GEO / AEO) -->
<link rel="sitemap" type="application/xml" title="Sitemap" href="/sitemap.xml" />
<link rel="alternate" type="text/plain" title="LLMs.txt" href="/llms.txt" />
<link rel="alternate" type="text/plain" title="LLMs full content" href="/llms-full.txt" />
<meta name="ai-content-declaration" content="human-authored" />

<!-- Performance & DNS Preconnect -->
<link rel="dns-prefetch" href="//cdn.jsdelivr.net" />
<link rel="dns-prefetch" href="//unpkg.com" />
<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin />
<link rel="preconnect" href="https://unpkg.com" crossorigin />

<!-- Connected Schema.org JSON-LD Graph -->
<script type="application/ld+json"><?= $json($jsonld) ?></script>
