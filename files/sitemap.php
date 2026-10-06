<?php
// Serves /sitemap.xml  (see .htaccess rewrite). Add every public URL below.
header('Content-Type: application/xml; charset=utf-8');
$base = 'https://framestudio.in';
$urls = [  // [path, priority, changefreq, lastmod]
  ['/',                          '1.0', 'weekly',  date('Y-m-d')],
  ['/about',                     '0.8', 'monthly', '2026-10-01'],
  ['/services',                  '0.9', 'monthly', '2026-10-01'],
  ['/services/web-design',       '0.9', 'monthly', '2026-10-01'],
  ['/services/web-development',  '0.9', 'monthly', '2026-10-01'],
  ['/portfolio',                 '0.8', 'weekly',  '2026-10-01'],
  ['/contact',                   '0.7', 'yearly',  '2026-10-01'],
  // TODO: replace with your real URLs / load blog posts from your database
];
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as [$p, $pr, $cf, $lm]) {
  echo "  <url><loc>" . htmlspecialchars($base . $p) . "</loc><lastmod>$lm</lastmod><changefreq>$cf</changefreq><priority>$pr</priority></url>\n";
}
echo '</urlset>';
