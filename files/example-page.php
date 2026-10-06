<?php
// Example: services/web-development.php
$seo = [
  'type'         => 'service',
  'service_name' => 'Web Development',
  'title'        => 'Web Development Company in Rajkot, India | Frame Studio',   // ≤ 60 chars ideal
  'description'  => 'Frame Studio builds fast, secure, SEO-ready websites and web apps for startups and brands in India and worldwide. Get a free quote today.', // 140–160
  'path'         => '/services/web-development',
  'image'        => '/assets/og/web-development.jpg',
  'image_alt'    => 'Frame Studio web development services',
  'breadcrumb'   => [['Home','/'],['Services','/services'],['Web Development','/services/web-development']],
  'answer'       => 'Frame Studio is a Rajkot-based web development studio that designs, builds and launches fast, secure and SEO-ready websites for startups and established brands.',
  'faqs'         => [
    ['How much does a website cost in India?', 'A business website with Frame Studio typically starts from ₹[your starting price] and depends on pages, features and integrations. Share your requirements for a fixed quote within 24 hours.'],
    ['How long does it take to build a website?', 'Most Frame Studio websites launch in 3–6 weeks: 1 week discovery, 1–2 weeks design, 1–3 weeks development and a final week for testing and launch.'],
  ],
];
?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
  <base href="/">
  <?php include __DIR__ . '/seo-head.php'; ?>
</head>
<body>
  <h1>Web Development Company in Rajkot</h1>
  <p class="answer-summary"><?= htmlspecialchars($seo['answer']) ?></p>
  <!-- Render the SAME FAQs visibly on the page -->
  <?php foreach ($seo['faqs'] as $f): ?>
    <h3><?= htmlspecialchars($f[0]) ?></h3>
    <p class="faq-answer"><?= htmlspecialchars($f[1]) ?></p>
  <?php endforeach; ?>
</body>
</html>
