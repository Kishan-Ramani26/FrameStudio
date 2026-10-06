<?php
/**
 * Frame Studio – Dynamic XML Sitemap Generator
 * Serves /sitemap.xml via Apache RewriteRule.
 */
header('Content-Type: application/xml; charset=utf-8');

$base = 'https://framestudio.in';
$today = date('Y-m-d');

$urls = [
    // [path, priority, changefreq, lastmod]
    // Core Pages
    ['/',                                                           '1.0', 'weekly',  $today],
    ['/services',                                                   '0.9', 'weekly',  $today],
    ['/about',                                                      '0.8', 'monthly', $today],
    ['/project',                                                    '0.9', 'weekly',  $today],
    ['/pricing',                                                    '0.8', 'monthly', $today],
    ['/contact-us',                                                 '0.8', 'monthly', $today],

    // Service Landing Pages
    ['/shopify-development',                                        '0.9', 'weekly',  $today],
    ['/wordpress-development',                                      '0.9', 'weekly',  $today],
    ['/php-development',                                            '0.9', 'weekly',  $today],
    ['/ecommerce-development',                                      '0.9', 'weekly',  $today],
    ['/seo-services',                                               '0.9', 'weekly',  $today],
    ['/website-maintenance',                                        '0.8', 'monthly', $today],

    // Projects / Case Studies
    ['/project-detail/vrtaj',                                       '0.8', 'monthly', $today],
    ['/project-detail/flieo',                                       '0.8', 'monthly', $today],
    ['/project-detail/avinto',                                      '0.8', 'monthly', $today],

    // Blog & Articles
    ['/blog',                                                       '0.8', 'weekly',  $today],
    ['/blog-post/why-rajkot-businesses-need-modern-web-design',     '0.8', 'monthly', $today],
    ['/blog-post/role-of-ecommerce-in-wholesale-business',         '0.8', 'monthly', $today],
    ['/blog-post/the-future-of-graphic-design-emerging-trends',     '0.7', 'monthly', $today],
    ['/blog-post/where-design-is-headed-top-trends-shaping',         '0.7', 'monthly', $today],
];

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
echo '        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

foreach ($urls as [$path, $priority, $changefreq, $lastmod]) {
    $loc = htmlspecialchars($base . $path, ENT_XML1, 'UTF-8');
    echo "  <url>\n";
    echo "    <loc>{$loc}</loc>\n";
    echo "    <lastmod>{$lastmod}</lastmod>\n";
    echo "    <changefreq>{$changefreq}</changefreq>\n";
    echo "    <priority>{$priority}</priority>\n";
    if ($path === '/') {
        echo "    <image:image>\n";
        echo "      <image:loc>https://framestudio.in/images/Frame-Studio%20Logo.png</image:loc>\n";
        echo "      <image:title>Frame Studio Logo</image:title>\n";
        echo "    </image:image>\n";
    }
    echo "  </url>\n";
}

echo '</urlset>' . "\n";
